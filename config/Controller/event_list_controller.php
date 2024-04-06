<?php
include_once('config/database/db_connect.php');

$sql = 'SELECT * FROM event_list WHERE archived = 0 ORDER BY created_At';
$result = mysqli_query($conn, $sql);
$eventLists= mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
 

// eventName	eventHeaderImage	eventBackgroundImage	eventStart	eventEnd

$errors = array(
  'eventName' => '',
  'eventHeaderImage' => '', 
  'eventBackgroundImage' => '', 
  'eventStart	' => '',
  'eventEnd	' => ''
);

$required_fields =['eventName', 'eventHeaderImage', 'eventBackgroundImage', 'eventStart', 'eventEnd'];

if(isset($_POST['submit'])){
include_once('config/database/db_connect.php');
  
// Event Name
  if(empty($_POST['eventName'])){
    $errors['eventName'] = 'event name is required';
  }
  else{
    $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);    
  }

// Event Start
  if(empty($_POST['eventStart'])){
    $errors['eventStart'] = 'event start is required';
  }else{
    $eventStart = mysqli_real_escape_string($conn, $_POST['eventStart']);
  }

// Event End
  if(empty($_POST['eventEnd'])){
    $errors['eventEnd'] = 'event start is required';
  }else{
    $eventEnd = mysqli_real_escape_string($conn, $_POST['eventEnd']);
  }

  if(!array_filter($errors)){
    
  $eventHeaderImage_Name =$_FILES['eventHeaderImage']['name'];
  $eventHeaderImage_Size =$_FILES['eventHeaderImage']['size'];
  $eventHeaderImage_Tmp = $_FILES['eventHeaderImage']['tmp_name'];
  $eventHeaderImage_error = $_FILES['eventHeaderImage']['error']; 
 
  $eventBackgroundImage_Name =$_FILES['eventBackgroundImage']['name'];
  $eventBackgroundImage_Size =$_FILES['eventBackgroundImage']['size'];
  $eventBackgroundImage_Tmp = $_FILES['eventBackgroundImage']['tmp_name'];
  $eventBackgroundImage_error = $_FILES['eventBackgroundImage']['error']; 
  
  $event_id_query = "SELECT COUNT(*) as count_id FROM event_list WHERE (LAST_DAY(CURDATE()) - LAST_DAY(CURDATE())+1) <= DAY(created_At) AND DAY(LAST_DAY(CURDATE())) >= DAY(created_At) AND MONTH(LAST_DAY(CURDATE())) = MONTH(created_At) AND YEAR(LAST_DAY(CURDATE())) = YEAR(created_At)";
  $event_count_query = "SELECT COUNT(*) as count_event FROM event_list";

  $event_count_result = mysqli_query($conn, $event_count_query);
  $event_count_total = mysqli_fetch_assoc($event_count_result)['count_event'];
  mysqli_free_result($event_count_result);

  $event_id_result = mysqli_query($conn, $event_id_query);
  $event_id_total = mysqli_fetch_assoc($event_id_result)['count_id'];
  mysqli_free_result($event_id_result);
  
  $currentDateTime = date('my');
  $event_count = $event_count_total + 1;
  $event_id = $currentDateTime . $event_id_total + 1;


  // IMAGE - HEADER 
  $image_header = strtolower(pathinfo($eventHeaderImage_Name, PATHINFO_EXTENSION));
  $eventHeaderImage = "HD".$event_id.'.'.$image_header;
  $header_uploadpath ='Image/Header/'.$eventHeaderImage;

  // IMAGE - BACKGROUND
  $image_background = strtolower(pathinfo($eventBackgroundImage_Name, PATHINFO_EXTENSION));
  $eventBackgroundImage = "BG".$event_id.'.'.$image_background;
  $Background_uploadpath ='Image/Background/'.$eventBackgroundImage;

  move_uploaded_file($eventHeaderImage_Tmp, $header_uploadpath);
  move_uploaded_file($eventBackgroundImage_Tmp, $Background_uploadpath);

  $sql = "INSERT INTO event_list(eventName, eventHeaderImage, eventBackgroundImage, eventStart, eventEnd, event_id, event_count) 
  VALUES ('$eventName', '$eventHeaderImage','$eventBackgroundImage','$eventStart','$eventEnd','$event_id', '$event_count')";

      // save to db and check
      if(mysqli_query($conn, $sql)){
        mysqli_close($conn);
        header('Location: event_List.php');
      } else {
        // error
        echo 'query error: ' . mysqli_error($conn);
      }

  }
   
  
 
} 

 


?>