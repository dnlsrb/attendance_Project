<?php include('../auth/auth_all.php');?>
 
<?php
if(isset($_GET['getsubmit'])):
include_once('../database/db_connect.php');	 

	$event_id = mysqli_real_escape_string($conn, $_GET['event_id']);
	$sql = "SELECT * FROM event_list WHERE event_id = $event_id";
	$result = mysqli_query($conn, $sql);
	$eventList = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
 
$filename = htmlspecialchars($eventList['eventName']) ." of \t".date("M-d-Y");
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	

 

<style>
.table2
{
	font-family: "Arial Narrow";
	font-size: 14px;
	border:thin #CCC;
	border-collapse:collapse;
	
}
td
{
	border-bottom: #CCC solid thin;
}
body {
	font-family: "Arial Narrow";
	margin-left: 0px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
 

<?php
include_once('../database/db_connect.php');
$date = date("F j, Y");
 
$searchSQL = "SELECT * FROM attendance_records WHERE event_id = '$event_id' AND archived = 0 ORDER BY created_At DESC";
$result = mysqli_query($conn,$searchSQL);

if(mysqli_num_rows($result)>0)
{
?>
<table width="50%" align="center" cellpadding="5" class="table2" >
<th height="35" colspan="5" bgcolor="#CCCCFF">PRESENT TODAY : <?php echo htmlspecialchars($eventList['eventName']) ?></th>
<tr>
	<td><center><strong>#</strong></center></td>
	<td><center><strong>ID</strong></center></td>
<td><center><strong>Name</strong></center></td>
<td width="15%"><center>
  <strong>IN</strong>
</center></td>

<td width="15%"><center>
  <strong>OUT</strong>
</center></td>

<?php $count = 1;  
	while($row = mysqli_fetch_array($result))
	{
		$date_IN = strtotime(htmlspecialchars($row['time_IN'])); 
		if($row['time_OUT'] != ""){ 
		$date_OUT  = strtotime(htmlspecialchars($row['time_OUT'])); 	
		}else{
		 
		}
?>
	<tr style="font-weight:bold">
	<td width="20%" style="color:blue"><center><?php echo $count; ?></center></td>
	<td width="20%" style="color:blue"><center><?php echo htmlspecialchars($row['record_id']); ?></center></td>
	<td width="34%"><strong><?php echo htmlspecialchars($row['attendeesName']); ?></strong></td>
	<td width="33%" style="color:blue"><center><?php echo date('M d, Y h:i:s: A', $date_IN) ; ?></center></td>
	<td width="33%" style="color:red"><center><?php if($row['time_OUT'] != ""){echo date('M d, Y h:i:s: A', $date_OUT);}else{ } ?></center></td>
	
	</tr>
<?php
	$count++;
	}
}
else
{
?>
	<strong><font face="Arial">No activity log yet</font></strong>
<?php mysqli_close($conn);
}
?>
</table>
</body>
</html>
<?php else:
	header("Location: ../../index.php");
	?>	
<?php endif;?>