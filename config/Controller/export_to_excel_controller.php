 
 
<?php
if(isset($_GET['getsubmit'])):
	include_once('config/database/db_connect.php');

	$event_id = mysqli_real_escape_string($conn, $_GET['event_id']);
	$sql = "SELECT * FROM event_list WHERE event_id = $event_id";
	$result = mysqli_query($conn, $sql);
	if ($result) {
	$eventList = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	 
	$filename = htmlspecialchars($eventList['eventName']) ." of \t".date("M-d-Y");
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=$filename.xls");
	}else{
		die(mysqli_error($conn));
	}
 

else:
	header("Location:index.php");
 
 endif;?>