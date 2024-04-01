<?php
session_start();
 
if($_SESSION['role'] === 'admin' && isset($_SESSION['username'])  && isset($_SESSION['password'])):
?>
<?php
 
include_once('config/db_connect.php');
 
 

// GET ID 
if(isset($_GET['id'])){


$id = mysqli_real_escape_string($conn, $_GET['id']);

// FOR Event Name and To Get ID
$sql = "SELECT * FROM event_list WHERE event_id = $id";
$result = mysqli_query($conn, $sql);
$eventLists = mysqli_fetch_assoc($result);

mysqli_free_result($result);
 
//  SQL Query FOR DISPLAY at Table 
$AttendanceList_sql = 
"SELECT record_id, attendance_records.event_id, attendeesName, attendeesEmail, time_IN, time_OUT,  eventName
 FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id 
 WHERE attendance_records.event_id = $id AND attendance_records.archived = 0
 ORDER BY time_IN DESC
 ";
$AttendanceList_result = mysqli_query($conn, $AttendanceList_sql);
$Attendees_Records = mysqli_fetch_all($AttendanceList_result, MYSQLI_ASSOC);
 
mysqli_free_result($AttendanceList_result);


// SUBMIT
if(isset($_POST['btnsubmit'])){
 

$attendeesName = mysqli_real_escape_string($conn, $_POST['attendeesName']);
$attendeesEmail = mysqli_real_escape_string($conn, $_POST['attendeesEmail']);
$event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
$time_IN = $current_date = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD;

$total = "SELECT COUNT(*) as count FROM attendance_records WHERE (LAST_DAY(CURDATE()) - LAST_DAY(CURDATE())+1) <= DAY(time_IN) AND DAY(LAST_DAY(CURDATE())) >= DAY(time_IN) AND MONTH(LAST_DAY(CURDATE())) = MONTH(time_IN) AND YEAR(LAST_DAY(CURDATE())) = YEAR(time_IN)";
$submit_result = mysqli_query($conn, $total);
$count = mysqli_fetch_assoc($submit_result)['count'];
$currentDateTime = date('my');
 
$record_id = $currentDateTime  . $count + 1 ;


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
<!-- SCRIPT -->
  <script src="instascan.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- SCRIPT -->
<?php include('template/header.php')?>
<div class="container-fluid  "> 
 
 
<div class="container d-flex justify-content-center align-items-center  ">
    <div class="row">
    <div class="col ">

    <video id="preview" width="100%" height="50%" style="border-radius:20px;"></video>

 
    </div>
    <div class="col">
    
<div class=" w-100">
<br>
<?php if($eventLists):?>
    <a class="btn btn-primary mb-3" href="event_List.php">Go Back </a><br>
 
<div class="d-flex justify-content-center align-items-center"> 
<form class="card  p-3 mb-5 mt-3 d-flex"  id="scan_form"  action="attendance_List.php?id=<?php echo $id;  ?>" method="POST">
<h3>Event Name: <?php echo htmlspecialchars($eventLists['eventName']);?></h3>
<input type="text" name="attendeesName" id="attendeesName" placeholder="Attendees Name" value=""> 
<!-- <input type="email" name="attendeesEmail" placeholder="Attendees Email">  -->
<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($id);  ?>">
<input type="submit" id="btnsubmit" name="btnsubmit" value="btnsubmit">

<script>
	let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
	Instascan.Camera.getCameras().then(function(cameras){
		if(cameras.length > 0){
			scanner.start(cameras[0]);
		}else{
			alert('No se encontraron cámaras');
		}

	}).catch(function(e){
		console.error(e);
	});

	scanner.addListener('scan',function(c){
		document.getElementById('attendeesName').value=c;
 
        document.getElementById('btnsubmit').click();
	 
	});
</script>

</form>
</div>

<?php if($Attendees_Records): ?>
<table class="table table-striped  ">
<tr>
    <th>ID</th>
    <th>name</th>
    <th>email</th>
    <th>Time in</th>
    <th>Time out</th>
    <th></th>
</tr>
 
<?php  echo '<tr>'; foreach( $Attendees_Records as $Attendees):?>
<td><?php echo htmlspecialchars($Attendees['record_id']); ?></td>
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

    </div>
    </div>
 


 
</div>
</div>
</div>
<?php include('template/footer.php')?>

<?php 
else:
header('Location: index.php');

endif;
?>

 