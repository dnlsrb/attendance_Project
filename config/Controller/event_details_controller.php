
<?php
include_once('config/database/db_connect.php');

class eventDetailsController{

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    
    public function validator($event_id){
    
        if(isset($event_id) && preg_match('/^\d+$/', $event_id)){
           
            $validated = "SELECT archived FROM event_list WHERE event_id = $event_id" ;
            $result = mysqli_query($this->conn, $validated);
            
            if(mysqli_num_rows($result) === 0){
                 
                mysqli_free_result($result);
                header('Location: error/404.php');
            }
        
            $archived = mysqli_fetch_assoc($result);
            $validating = $archived['archived'];
        
            if($validating == 1){
               
                mysqli_free_result($result);
                header('Location: error/403.php');
            }
            else{
               
                mysqli_free_result($result);
            }
    
        }else{
       
            header('Location: error/404.php');
        }
        }

    public function getList($sql){
 
 
  
        $result = mysqli_query($this->conn, $sql);
        if(mysqli_query($this->conn, $sql)){
            $eventList = mysqli_fetch_assoc($result);
        }else{ 
            echo 'query error: ' . mysqli_error($this->conn);
        }
       

        return $eventList;
    }

    public function getCount($sql)
    {

        $result = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_assoc($result)['count'];
        mysqli_free_result($result);

        return $data;
    }
    
    private function validateCreatedEvent($eventData){
            $errors = [];

        if(empty($eventData['eventName'])){
            $errors['eventName'] = 'event name is required';
            }
        if(empty($eventData['eventStart'])){
            $errors['eventStart'] = 'event start is required';
            } 
        if(empty($eventData['eventEnd'])){
            $errors['eventEnd'] = 'event start is required';
            } 

        return $errors;
    }


    public function deleteList($event_id){
         
        $sql = "UPDATE event_list SET archived = 1 WHERE event_id = $event_id";
        if(mysqli_query($this->conn, $sql)){
            mysqli_close($this->conn);  
            header('Location: event_List.php');
            exit();
        }else{
            echo 'query error: ' . mysqli_error($this->conn);
            
        }
    
    }
    public function uploadBanner($oldpath,$category,$imageName, $imageTemp, $event_id, $SET){
       
 
        if (file_exists($oldpath) ) {
           unlink($oldpath);
        }  
        
        // IMAGE - HEADER 
        $pathExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $bannerNewName = "$category".$event_id.'.'.$pathExtension;
        $uploadpath ="image/$category/".$bannerNewName;
        move_uploaded_file($imageTemp, $uploadpath);

        $sql = 
        "UPDATE event_list 
            SET {$SET} = '$bannerNewName'
            WHERE event_id = $event_id";
        $update_query = mysqli_query($this->conn, $sql);
    }


    public function eventUpdate($eventData){
        // HEADER
        $errors = $this->validateCreatedEvent($eventData);
        
         if(!array_filter($errors)){
        if(!empty($eventData['imageName_header'])){
        $this->uploadBanner(
        $eventData['oldpath_header'], 
        'header', 
        $eventData['imageName_header'], 
        $eventData['imageTemp_header'], 
        $eventData['event_id'], 
        'eventHeaderImage');
        }
        if(!empty($eventData['imageName_background'])){
        // BACKGROUND
        $this->uploadBanner(
         $eventData['oldpath_background'], 
        'background', 
        $eventData['imageName_background'], 
        $eventData['imageTemp_background'], 
        $eventData['event_id'], 
        'eventBackgroundImage');
        }

        $sql = "UPDATE event_list 
        SET 
        eventName = '{$eventData['eventName']}',
        eventStart = '{$eventData['eventStart']}', 
        eventEnd = '{$eventData['eventEnd']}'
        WHERE event_id = '{$eventData['event_id']}'";

        $update_query = mysqli_query($this->conn, $sql);
        
         
        header('Location: event_Details.php?id='.$eventData['event_id']);
        }else{
            return $errors;
        }
      
    }
 

    public function closeConnection() {
        mysqli_close($this->conn);
    }
}

 
$eventManager = new eventDetailsController($conn);
 
$eventManager ->validator($_GET['id']);

if(isset($_POST['delete'])){
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $eventManager->deleteList($event_id); 
}
$event_id = mysqli_real_escape_string($conn, $_GET['id']);
$eventList = $eventManager->getList("SELECT * FROM event_list WHERE event_id = $event_id");
$count_display = $eventManager->getCount("SELECT COUNT(*) as count FROM attendance_records WHERE event_id = '$event_id' AND archived = 0");
$attendees_Records = $eventManager->getList(  "SELECT attendeesName FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id  
    WHERE attendance_records.event_id = $event_id AND attendance_records.archived = 0
    ORDER BY time_IN DESC"
);

if(isset($_POST['submit'])){
    $eventData = [
        'event_id' => mysqli_real_escape_string($conn, $_POST['event_id']),
        'oldpath_header' => 'image/header/'.mysqli_real_escape_string($conn, $_POST['old_header_path']),
        'imageName_header' => $_FILES['eventHeaderImage']['name'],
        'imageTemp_header' => $_FILES['eventHeaderImage']['tmp_name'],
        'oldpath_background' => 'image/background/'.mysqli_real_escape_string($conn, $_POST['old_background_path']),
        'imageName_background' => $_FILES['eventBackgroundImage']['name'],
        'imageTemp_background' => $_FILES['eventBackgroundImage']['tmp_name'],
        'eventName' => mysqli_real_escape_string($conn, $_POST['eventName']),
        'eventStart' => mysqli_real_escape_string($conn, $_POST['eventStart']),
        'eventEnd' => mysqli_real_escape_string($conn, $_POST['eventEnd'])
    ];
  
    $errors = $eventManager->eventUpdate($eventData);
}
$eventManager->closeConnection();



?>