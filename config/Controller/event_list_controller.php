
<?php
include_once('config/database/db_connect.php');

class eventListController{
  private $conn;

  public function __construct($conn) {
      $this->conn = $conn;
  }

  public function displayEventList($searchSql){
    $sql = "SELECT * FROM event_list WHERE $searchSql archived = 0 ORDER BY created_At ASC";
    $result = mysqli_query($this->conn, $sql);
    if($result){
      $eventLists= mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return  $eventLists;
       
    }
    else{
      echo 'query error: ' . mysqli_error($this->conn);
    } 
  }


  public function uploadBanner($category,$imageName, $imageTemp, $event_id, $SET){
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

    return $bannerNewName;
}

  public function NoTimeOutWithinTheDay(){

    $sql_no_timeOut = "UPDATE attendance_records SET time_OUT = 'NO DATA' 
    WHERE created_at < DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY) 
    AND time_OUT = '' 
    AND archived = 0";

    if(mysqli_query($this->conn, $sql_no_timeOut)){ 
     
    }
    else{
        echo 'query error: ' . mysqli_error($this->conn);
    }
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

  public function createdEvent($eventData){
    $errors = $this->validateCreatedEvent($eventData);

    
  if(!array_filter($errors)){
    
    $event_id_query = "SELECT COUNT(*) as count_id FROM event_list WHERE (LAST_DAY(CURDATE()) - LAST_DAY(CURDATE())+1) <= DAY(created_At) AND DAY(LAST_DAY(CURDATE())) >= DAY(created_At) AND MONTH(LAST_DAY(CURDATE())) = MONTH(created_At) AND YEAR(LAST_DAY(CURDATE())) = YEAR(created_At)";
    $event_count_query = "SELECT COUNT(*) as count_event FROM event_list";
  
    $event_count_result = mysqli_query($this->conn, $event_count_query);
    $event_count_total = mysqli_fetch_assoc($event_count_result)['count_event'];
    mysqli_free_result($event_count_result);
  
    $event_id_result = mysqli_query($this->conn, $event_id_query);
    $event_id_total = mysqli_fetch_assoc($event_id_result)['count_id'];
    mysqli_free_result($event_id_result);
    
    $currentDateTime = date('my');
    $event_count = $event_count_total + 1;
    $event_id = $currentDateTime . $event_id_total + 1;
    
    if($eventData['eventHeaderImage_Name'] != ''){ 
    $eventHeaderImage = $this->uploadBanner('header',$eventData['eventHeaderImage_Name'], $eventData['eventHeaderImage_Tmp'], $event_id, 'eventHeaderImage');
    } else{
      $eventHeaderImage = 'default.jpg';
    }

    if($eventData['eventBackgroundImage_Name'] != ''){ 
    $eventBackgroundImage = $this->uploadBanner('background',$eventData['eventBackgroundImage_Name'], $eventData['eventBackgroundImage_Tmp'], $event_id, 'eventBackgroundImage');
    } else{
      $eventBackgroundImage = 'default.jpg';
    }
    $sql = "INSERT INTO event_list(eventName, eventHeaderImage, eventBackgroundImage, eventStart, eventEnd, event_id, event_count) 
    VALUES ('{$eventData['eventName']}', '$eventHeaderImage','$eventBackgroundImage','{$eventData['eventStart']}','{$eventData['eventEnd']}','$event_id', '$event_count')";
  
        // save to db and check
        if(mysqli_query($this->conn, $sql)){
          header('Location: event_list.php');
        } else {
          // error
          echo 'query error: ' . mysqli_error($this->conn);
        }
  
    }

    return $errors;
  }

 

  public function closeConnection() {
    mysqli_close($this->conn);
  }

}

$eventListManager = new eventListController($conn);
$eventListManager->NoTimeOutWithinTheDay();
if(!isset($_POST['search'])){ 
$eventLists = $eventListManager->displayEventList('');
}


if(isset($_GET['search'])){
  $searchSql = '';
  $startRange =  mysqli_real_escape_string($conn, $_GET['startRange']);
  $endRange =  mysqli_real_escape_string($conn, $_GET['endRange']);
  $name =  mysqli_real_escape_string($conn, $_GET['name']);
  
if(!empty($_GET['startRange'])){ 
  $searchSql .= " eventStart >= '" . $startRange . "' AND ";
}
if(!empty( $_GET['endRange'])){
  $searchSql .= " eventEnd <= '" . $endRange . "' AND ";
}
if(!empty($_GET['name'])){ 
  $searchSql .= "eventName LIKE '%" . $name . "%' AND ";
} 
 
$eventLists = $eventListManager->displayEventList($searchSql);
}

if(isset($_POST['submit'])){
  include_once('config/database/db_connect.php');
    $eventData = [
      'eventHeaderImage_Name' => $_FILES['eventHeaderImage']['name'],
      'eventHeaderImage_Size' => $_FILES['eventHeaderImage']['size'],
      'eventHeaderImage_Tmp' => $_FILES['eventHeaderImage']['tmp_name'],
      'eventHeaderImage_error' => $_FILES['eventHeaderImage']['error'], 
     
      'eventBackgroundImage_Name' => $_FILES['eventBackgroundImage']['name'],
      'eventBackgroundImage_Size' => $_FILES['eventBackgroundImage']['size'],
      'eventBackgroundImage_Tmp' => $_FILES['eventBackgroundImage']['tmp_name'],
      'eventBackgroundImage_error' => $_FILES['eventBackgroundImage']['error'],
      
      'eventName' => mysqli_real_escape_string($conn, $_POST['eventName']),
      'eventStart' => mysqli_real_escape_string($conn, $_POST['eventStart']),  
      'eventEnd' => mysqli_real_escape_string($conn, $_POST['eventEnd']),  
    ];

    $errors = $eventListManager->createdEvent($eventData);
  }  
$eventListManager->closeConnection();
?>