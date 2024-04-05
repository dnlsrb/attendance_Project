<?php include('authentication.php');?>
<?php
if(isset($_GET['id'])){
    include_once('config/db_connect.php');
    $event_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM event_list WHERE event_id = $event_id";
    $result = mysqli_query($conn, $sql);
    $eventList = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);

}

if(isset($_POST['delete'])){
    include_once('config/db_connect.php');
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
    include_once('config/db_connect.php');
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


<?php include('template/header.php');?>
        <h4>Edit Event</h4>
<form action="event_Details.php" method="POST"> 

    <label for="eventName">Event Name</label><br>
    <input name="eventName"  value="<?php echo  htmlspecialchars($eventList['eventName']); ?> " type="text"><br> 
    Background image: <input type="file" name="eventBackgroundImage" accept=".jpg, .png, .jpeg, .gif," > <br>
     Header Image: <input type="file" name="eventHeaderImage" accept=".jpg, .png, .jpeg, .gif,"> <br>
     <p style="color:red;"> <?php echo  $errors['eventStart'] ?? '' ;?> </p> 
     Event Start: <input type="date" name="eventStart" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($eventList['eventStart']); ?> " ><br>
     <p style="color:red;"><?php echo  $errors['eventEnd'] ?? '' ;?></p>
     Event End <input type="date" name="eventEnd" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($eventList['eventEnd']); ?> " >
     <br>       
    <input type="hidden" name="event_id"  value="<?php echo htmlspecialchars($eventList['event_id']); ?>">
    <input type="submit"   value="submit" name="submit">

 
</form>
<form action="event_Details.php" method="POST">
 
<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eventList['event_id']);?>">
<input type="submit" name="delete" value="delete" >  
</form>

<a href="event_List.php">BACK</a>
 

<?php include('template/footer.php');?>
 
 