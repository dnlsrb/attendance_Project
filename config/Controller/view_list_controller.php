<?php

class ViewController{

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
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
    
            return $data;
        }
        
        public function getCount($sql){
        
            $result = mysqli_query($this->conn, $sql);
            $data = mysqli_fetch_assoc($result)['count'];
            mysqli_free_result($result);
        
            return $data;
            
        }
        public function getEvent($sql){
        
            $result = mysqli_query($this->conn, $sql);
            $data = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
        
            return $data;
             
        }
    
        public function archiveAttendees($delete_record, $event_id){
        
            $sql = "UPDATE attendance_records SET archived = 1 WHERE record_id=$delete_record";
            if(mysqli_query($this->conn, $sql)){
                mysqli_close($this->conn);
                header('Location: view_list.php?id='. $event_id);
                exit();
            }else{
                echo 'query error: ' . mysqli_error($this->conn);
            }
        }
         

        public function unarchiveAttendees($delete_record, $event_id){
        
            $sql = "UPDATE attendance_records SET archived = 0 WHERE record_id=$delete_record";
            if(mysqli_query($this->conn, $sql)){
                mysqli_close($this->conn);
                header('Location: view_list.php?id='. $event_id);
                exit();
            }else{
                echo 'query error: ' . mysqli_error($this->conn);
            }
        }
        public function closeConnection() {
            mysqli_close($this->conn);
        }
}

    $ViewManagement = new ViewController($conn);
    $ViewManagement->validator($_GET['id']);
    $id= mysqli_real_escape_string($conn, $_GET['id']);
    $eventLists = $ViewManagement->getEvent("SELECT * FROM event_list WHERE event_id = $id");
     $count_display = $ViewManagement->getCount("SELECT COUNT(*) as count FROM attendance_records WHERE event_id = '$id' AND archived = 0");
     
     
     if(isset($_POST['search'])){ 
        $name =  mysqli_real_escape_string($conn, $_POST['name']);
        $searchSql = "attendeesName LIKE '%" . $name . "%' AND ";
     }
     else{
        $searchSql = '';
     }
     
     $attendees_Records = $ViewManagement->getList(
        "SELECT record_id, attendance_records.event_id, attendeesName, time_IN, time_OUT, eventName, attendance_records.archived
        FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id 
        WHERE $searchSql attendance_records.event_id = $id  
        ORDER BY attendance_records.created_At DESC");
      
 
     if(isset($_POST['archive'])){
         $archive_record = mysqli_real_escape_string($conn, $_POST['archive_record']);
         $event_id= mysqli_real_escape_string($conn, $_POST['event_id']);
         $ViewManagement->archiveAttendees($archive_record, $event_id);
     }
     if(isset($_POST['unarchive'])){
        $unarchive_record = mysqli_real_escape_string($conn, $_POST['unarchive_record']);
        $event_id= mysqli_real_escape_string($conn, $_POST['event_id']);
        $ViewManagement->unarchiveAttendees($unarchive_record, $event_id);
    }

    

$ViewManagement->closeConnection();
?>
