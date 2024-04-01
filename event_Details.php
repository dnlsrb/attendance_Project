<?php
session_start();
if($_SESSION['role'] === 'admin' && isset($_SESSION['username'])  && isset($_SESSION['password'])):
?>
<?php

include('config/db_connect.php');

if(isset($_GET['id'])){

$event_id = mysqli_real_escape_string($conn, $_GET['id']);

// make sql
$sql = "SELECT * FROM event_list WHERE event_id = $event_id";

// get the query result
$result = mysqli_query($conn, $sql);
 
$eventList = mysqli_fetch_assoc($result);

// FREE RESULT FROM MEMORY
mysqli_free_result($result);

// CLOSE CONNECTION
mysqli_close($conn);
 
 

}


?>
<?php
 include('config/db_connect.php');

 if(isset($_POST['delete'])){
    

     
    $event_id= mysqli_real_escape_string($conn, $_POST['event_id']);
    $sql = "UPDATE event_list SET archived = 1 WHERE event_id = $event_id";
    if(mysqli_query($conn, $sql)){
        // success
        
       header('Location: event_List.php');
    }else{
        echo 'query error: ' . mysqli_error($conn);
    }

 
}

if(isset($_POST['submit'])){

    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
     
    $sql = "UPDATE event_list SET eventName = '$eventName' WHERE event_id = $event_id";
    $update_query = mysqli_query($conn, $sql);
    
    header("Location: event_Details.php?id=". $event_id );
    mysqli_close($conn);
     
}
// $eventName
// $eventBackgroundImage
// $eventHeaderImage
// $eventStart
// $eventEnd
// $archived 
 
?>
<?php include('template/header.php');?>
 <div class="container d-flex justify-content-center align-items-center mt-5">
    <div> 
        <h4>Edit Event</h4>
<form action="event_Details.php" method="POST"> 
    <label for="eventName">Event Name</label><br>
<input name="eventName"  value="<?php echo htmlspecialchars($eventList['eventName']); ?> " type="text"> 
<input type="hidden" name="event_id"  value="<?php echo htmlspecialchars($eventList['event_id']); ?>">
<input type="submit" class="btn btn-primary" value="submit" name="submit">
 
 
</form>
<form action="event_Details.php" method="POST">
 
<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eventList['event_id']);?>">
<input type="submit" name="delete" value="delete" >  
</form>

<a href="event_List.php">BACK</a>
</div>
</div>

<?php include('template/footer.php');?>
 

<?php 
else:
header('Location: index.php');

endif;
?>