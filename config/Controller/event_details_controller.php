
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
        header('Location: event_List.php');
    }else{
        echo 'query error: ' . mysqli_error($conn);
        mysqli_close($conn);  
    }

}

if(isset($_POST['submit'])){
    include_once('config/database/db_connect.php');
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
    $sql = "UPDATE event_list SET eventName = '$eventName' WHERE event_id = $event_id";
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