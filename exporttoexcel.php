<?php
session_start();
if($_SESSION['role'] === 'admin' && isset($_SESSION['username'])  && isset($_SESSION['password'])):
?>
<?php  
include("config/db_connect.php");
$filename = "PGH Attendance Record as of \t".date("M-d-Y");
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");

?>
<?php include('template/header.php')?>
 

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
$date = date("F j, Y");
 
$searchSQL = 'SELECT * FROM attendance_records  ORDER BY record_id DESC';
$result = mysqli_query($conn,$searchSQL);

if(mysqli_num_rows($result)>0)
{
?>
<table width="50%" align="center" cellpadding="5" class="table2" >
<th height="35" colspan="3" bgcolor="#CCCCFF">PRESENT TODAY</th>
<tr>
	<td><center><strong>ID</strong></center></td>
<td><center><strong>Name</strong></center></td>
<td width="15%"><center>
  <strong>IN</strong>
</center></td>

<td width="15%"><center>
  <strong>OUT</strong>
</center></td>

<?php
	while($row = mysqli_fetch_array($result))
	{

?>
	<tr style="font-weight:bold">
	
	<td width="20%" style="color:blue"><center><?php echo $row['record_id']; ?></center></td>
	<td width="34%"><strong><?php echo $row['attendeesName']; ?></strong></td>
	<td width="33%" style="color:blue"><center><?php echo $row['time_IN']; ?></center></td>
	<td width="33%" style="color:red"><center><?php echo $row['time_OUT']; ?></center></td>
	
	</tr>
<?php
		
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
<?php include('template/footer.php')?>
 
<?php 
else:
header('Location: index.php');

endif;
?>