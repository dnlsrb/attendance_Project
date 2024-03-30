<?php
 
include_once('config/db_connect.php');
 
 

// GET ID 
if(isset($_GET['id'])){


$id = mysqli_real_escape_string($conn, $_GET['id']);

// FOR Event Name and To Get ID
$sql = "SELECT * FROM event_list WHERE event_id = $id";
$result = mysqli_query($conn, $sql);
$eventLists = mysqli_fetch_assoc($result);

 
//  SQL Query FOR DISPLAY
$AttendanceList_sql = 
"SELECT record_id, attendance_records.event_id, attendeesName, attendeesEmail, time_IN, time_OUT,  eventName
 FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id 
 WHERE attendance_records.event_id = $id AND archived = 0
 ORDER BY time_IN ASC
 ";

// Get Result
$AttendanceList_result = mysqli_query($conn, $AttendanceList_sql);
// fetch 
$Attendees_Records = mysqli_fetch_all($AttendanceList_result , MYSQLI_ASSOC);



mysqli_free_result($result);
mysqli_free_result($AttendanceList_result);


// SUBMIT
if(isset($_POST['submit'])){
 

$attendeesName = mysqli_real_escape_string($conn, $_POST['attendeesName']);
$attendeesEmail = mysqli_real_escape_string($conn, $_POST['attendeesEmail']);
$event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
 
$time_IN = $current_date = date('Y-m-d H:i'); // Format: YYYY-MM-DD;

$total = "SELECT COUNT(*) as count FROM attendance_records WHERE event_id = $event_id AND LAST_DAY(CURDATE()) >= time_IN AND DAYOFMONTH(CURDATE()) <= time_IN";
$submit_result = mysqli_query($conn, $total);
$count = mysqli_fetch_assoc($submit_result)['count'];
 
 
$record_id =  $event_id  . $count + 1 ;


mysqli_free_result($submit_result);

$sql = "INSERT INTO attendance_records(record_id, event_id, attendeesName, attendeesEmail, time_IN) 
VALUES ('$record_id','$event_id', '$attendeesName','$attendeesEmail','$time_IN' )";

// save to db and check
if(mysqli_query($conn, $sql)){
    //success
    header('Location: attendance_List.php?id='. $event_id);
} else {
    // error
     echo 'query error: ' . mysqli_error($conn);
}

}


}  


// DELETE
if(isset($_POST['delete'])){
    

    $delete_record = mysqli_real_escape_string($conn, $_POST['delete_record']);
    $event_id= mysqli_real_escape_string($conn, $_POST['event_id']);
    $sql = "UPDATE attendance_records SET archived = 1 WHERE record_id=$delete_record";
    if(mysqli_query($conn, $sql)){
        // success
        
       header('Location: attendance_List.php?id='. $event_id);
    }else{
        echo 'query error: ' . mysqli_error($conn);
    }

 
}
 mysqli_close($conn);
?>

<?php include('template/header.php')?>

<br>
<?php if($eventLists):?>
<h>Event Name: <?php echo htmlspecialchars($eventLists['eventName']);?></h>
<form action="attendance_List.php?id=<?php echo $id;  ?>" method="POST">
<input type="text" name="attendeesName" placeholder="Attendees Name"><br>
<input type="email" name="attendeesEmail" placeholder="Attendees Email"><br>
<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($id);  ?>">
<input type="submit" name="submit" value="submit">

</form>

<?php if($Attendees_Records): ?>
<table>
<tr>
    <th>ID</th>
    <th>name</th>
    <th>email</th>
    <th>Time in</th>
    <th>Time out</th>
    <th></th>
</tr>
 
<?php  echo '<tr>'; foreach( $Attendees_Records as $Attendees):?>
<td><?php echo htmlspecialchars($Attendees['record_id']);  ?></td>
<td><?php echo htmlspecialchars($Attendees['attendeesName']);  ?></td>
<td><?php echo htmlspecialchars($Attendees['attendeesEmail']);  ?></td>
<td><?php echo htmlspecialchars($Attendees['time_IN']);  ?></td>
<td><?php echo htmlspecialchars($Attendees['time_OUT']);  ?></td>
<td>


<form action="attendance_List.php" method="POST">
<input type="hidden" name="delete_record" value="<?php echo $Attendees['record_id'];?>">
<input type="hidden" name="event_id" value="<?php echo $Attendees['event_id'];?>">
<input type="submit" name="delete" value="delete" >  
</form>


</td>
<?php echo '<tr>';   endforeach;?>
</table>
<?php else: ?>
<h3>No Attendees Yet</h3><br>
<?php endif ?>
 

<?php else: ?>

    
<h>no data found</h><br>
<?php endif; ?>



<a href="event_List.php">Go Back </a>

<?php include('template/footer.php')?>