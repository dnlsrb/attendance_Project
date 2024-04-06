<?php include('config/auth/auth_all.php');?>
<?php require('config/Controller/attendance_controller.php');?>


<!-- SCRIPT -->
<script src="js/instascan.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- SCRIPT -->


<?php include('template/header.php')?>
<style>
  table {
    background-image:url("Image/Background/<?php echo htmlspecialchars($eventLists['eventBackgroundImage']);?>");
    background-size: cover;
    /* Adjust other background properties as needed */
  }
</style>
 
 <video id="preview" width="50%" height="50%"></video>
<p id="waitMessage"></p>
 
<br>
<?php if($eventLists):?>
 
    <a href="event_List.php">Go Back </a><br>

 <form action="config/Controller/exporttoexcel.php" method="GET">
    <input type="submit" name="getsubmit" value="Download Excel">
    <input type="hidden" name="authentication" value="allowed">
    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($id);  ?>">
</form>
 
<form  id="scan_form"  action="attendance_List.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST">
    <?php if(isset($name_error)): echo $name_error; endif;?>
    <h3>Event Name: <?php echo htmlspecialchars($eventLists['eventName']);?></h3>
    <input type="text" name="attendeesName" id="attendeesName" placeholder="Attendees Name" value=""> 
    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($id);  ?>">
    <input type="submit" id="btnsubmit" name="submit" value="submit">
</form>
 
<!-- SCRIPT -->
<script>
    document.getElementById('waitMessage').innerText = "Please wait...";
    setTimeout(function() {
      
	let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
	Instascan.Camera.getCameras().then(function(cameras){
		if(cameras.length > 0){
			scanner.start(cameras[0]);
		}else{
			 
		}
    document.getElementById('waitMessage').innerText = "";
	}).catch(function(e){
		console.error(e);
	});

	scanner.addListener('scan',function(c){
		document.getElementById('attendeesName').value=c;
        // 1 Sec Delay to Avoid Time in and Time out in the flash
        document.getElementById('btnsubmit').click();
    
	}); }, 1000);
</script>
<!-- SCRIPT -->

<p>Total Attendees: <?php echo $count_display?></p>
<?php if($Attendees_Records): ?>
<table  >
<tr>
    <th>#</th>
    <th>ID</th>
    <th>name</th>
    <!-- <th>email</th> -->
    <th>Time in</th>
    <th>Time out</th>
    <th></th>
</tr>
<?php $count = 1;?>
<?php  echo '<tr>'; foreach( $Attendees_Records as $Attendees):?>
<td><?php echo $count; ?></td>
<td><?php echo htmlspecialchars($Attendees['record_id']); ?></td>
<td><?php echo htmlspecialchars($Attendees['attendeesName']);  ?></td>
<!-- <td><?php echo htmlspecialchars($Attendees['attendeesEmail']);  ?></td> -->
<td><?php echo htmlspecialchars( $Attendees['time_IN']);?></td>
<td><?php echo htmlspecialchars($Attendees['time_OUT']);  ?></td>
<td>


<form action="attendance_List.php" method="POST">
<input type="hidden" name="delete_record" value="<?php echo $Attendees['record_id'];?>">
<input type="hidden" name="event_id" value="<?php echo $Attendees['event_id'];?>">
<input type="submit" name="delete" value="delete" >  
</form>
 


</td>
<?php $count++;?>
<?php 
echo '<tr>';   
endforeach;
unset($count);
?>
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

 

 