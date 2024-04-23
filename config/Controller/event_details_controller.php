
<?php
if(isset($_GET['id'])){
    include_once('config/database/db_connect.php');
    $event_id = mysqli_real_escape_string($conn, $_GET['id']);
 
    $sql = "SELECT * FROM event_list WHERE event_id = $event_id";
    $result = mysqli_query($conn, $sql);
    $eventList = mysqli_fetch_assoc($result);
    
    mysqli_free_result($result);
    mysqli_close($conn);

}

if(isset($_POST['delete'])){
    include_once('config/database/db_connect.php');
    $event_id= mysqli_real_escape_string($conn, $_POST['event_id']);
    $sql = "UPDATE event_list SET archived = 1 WHERE event_id = $event_id";
    if(mysqli_query($conn, $sql)){
        mysqli_close($conn);  
        header('Location: event_List.php?id='.$event_id);
    }else{
        echo 'query error: ' . mysqli_error($conn);
        mysqli_close($conn);  
    }

}
 

if(isset($_POST['submit'])){
    include_once('config/database/db_connect.php');
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
    $eventStart = mysqli_real_escape_string($conn, $_POST['eventStart']);
    $eventEnd = mysqli_real_escape_string($conn, $_POST['eventEnd']);


    if(!empty($_FILES['eventHeaderImage']['name'])){
        $old_header_path = 'image/header/'.mysqli_real_escape_string($conn, $_POST['old_header_path']);
       
        if (file_exists($old_header_path)) {
           unlink($old_header_path);
        }  
         
        $eventHeaderImage_Name =$_FILES['eventHeaderImage']['name'];
        $eventHeaderImage_Tmp = $_FILES['eventHeaderImage']['tmp_name'];
        
        // IMAGE - HEADER 
        $image_header_path = strtolower(pathinfo($eventHeaderImage_Name, PATHINFO_EXTENSION));
        $eventHeaderImage = "HD".$event_id.'.'.$image_header_path;
        $header_uploadpath ='image/header/'.$eventHeaderImage;
        move_uploaded_file($eventHeaderImage_Tmp, $header_uploadpath);

        $sql = 
        "UPDATE event_list 
            SET eventHeaderImage = '$eventHeaderImage'
            WHERE event_id = $event_id";
        $update_query = mysqli_query($conn, $sql);
    
    }
    
    if(!empty($_FILES['eventBackgroundImage']['name'])){
        $old_background_path = 'image/background/'.mysqli_real_escape_string($conn, $_POST['old_background_path']);
        if (file_exists($old_background_path)) {
            unlink($old_background_path);
         } 
        
        $eventBackgroundImage_Name =$_FILES['eventBackgroundImage']['name'];
        $eventBackgroundImage_Tmp = $_FILES['eventBackgroundImage']['tmp_name'];

        // IMAGE - BACKGROUND
        $image_background_path = strtolower(pathinfo($eventBackgroundImage_Name, PATHINFO_EXTENSION));
        $eventBackgroundImage = "BG".$event_id.'.'.$image_background_path;
        $Background_uploadpath ='image/background/'.$eventBackgroundImage;
        move_uploaded_file($eventBackgroundImage_Tmp, $Background_uploadpath);

        $sql = 
        "UPDATE event_list 
            SET eventBackgroundImage = '$eventBackgroundImage'
            WHERE event_id = $event_id";
        $update_query = mysqli_query($conn, $sql);
         
    }
     
    $sql = "UPDATE event_list 
            SET 
            eventName = '$eventName',
            eventStart = '$eventStart', 
            eventEnd = '$eventEnd'
            WHERE event_id = $event_id";

    $update_query = mysqli_query($conn, $sql);
    mysqli_close($conn);
    header('Location: event_Details.php?id='.$event_id);
 
}

 

// $eventName
// $eventBackgroundImage
// $eventHeaderImage
// $eventStart
// $eventEnd
// $archived 

?>