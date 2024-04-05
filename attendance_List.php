<?php include('authentication.php');?>
<?php
include_once('config/db_connect.php');

// DISPLAY DATA
// ------------------------------------------------------------------------------------------
    if(isset($_GET['id'])){

        $date = date("M d, Y h:i:s A");
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $sql = "SELECT * FROM event_list WHERE event_id = $id";
        $result = mysqli_query($conn, $sql);
        $eventLists = mysqli_fetch_assoc($result);

        $count_Attendees = "SELECT COUNT(*) as count FROM attendance_records WHERE event_id = '$id' AND archived = 0";
        $count_result = mysqli_query($conn, $count_Attendees);
        $count_display = mysqli_fetch_assoc($count_result)['count'];

        mysqli_free_result($count_result);
        mysqli_free_result($result);
        
        $AttendanceList_sql = 
        "SELECT record_id, attendance_records.event_id, attendeesName, attendeesEmail, time_IN, time_OUT,  eventName
        FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id 
        WHERE attendance_records.event_id = $id AND attendance_records.archived = 0
        ORDER BY time_IN DESC
        ";
        $AttendanceList_result = mysqli_query($conn, $AttendanceList_sql);
        $Attendees_Records = mysqli_fetch_all($AttendanceList_result, MYSQLI_ASSOC);
        
        mysqli_free_result($AttendanceList_result);
    }
 

// BUTTON SUBMIT
// ------------------------------------------------------------------------------------------
    if(isset($_POST['submit'])){
    $name_error = "";
    $attendeesName = mysqli_real_escape_string($conn, $_POST['attendeesName']);

        if(preg_match('/[0-9]/', $attendeesName)) {
            echo $name_error = "No Numbers Allowed";
        } 
        elseif(empty($attendeesName)){
            echo $name_error = "Name is empty";
        }
        else{ 
            $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
            $timeOut_query = "SELECT * FROM attendance_records WHERE attendeesName = '$attendeesName' AND event_id = '$event_id'  AND time_OUT = '' AND archived = 0 ORDER BY created_At DESC";
            $timeOut_result = mysqli_query($conn, $timeOut_query);
            $timeOut_display = mysqli_fetch_assoc($timeOut_result);
            
            if(mysqli_num_rows($timeOut_result) === 1){

                $sql_update = "UPDATE attendance_records SET time_OUT = '$date' WHERE attendeesName = '$attendeesName' AND event_id = '$event_id'";
                $timeOut_update = mysqli_query($conn, $sql_update);
                mysqli_free_result($timeOut_result);
                mysqli_close($conn);
                header('Location: attendance_List.php?id='. $event_id);
            }
            else{ 

                $time_IN = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD;
                $total = "SELECT COUNT(*) as count FROM attendance_records WHERE (LAST_DAY(CURDATE()) - LAST_DAY(CURDATE())+1) <= DAY(created_At) AND DAY(LAST_DAY(CURDATE())) >= DAY(created_At) AND MONTH(LAST_DAY(CURDATE())) = MONTH(created_At) AND YEAR(LAST_DAY(CURDATE())) = YEAR(created_At)";
                $submit_result = mysqli_query($conn, $total);
                $count = mysqli_fetch_assoc($submit_result)['count'];
                $currentDateTime = date('my');
                
                $record_id = $currentDateTime  . $count + 1 ;


            mysqli_free_result($submit_result);

            $sql = "INSERT INTO attendance_records(record_id, event_id, attendeesName, time_IN) 
            VALUES ('$record_id','$event_id', '$attendeesName', '$date' )"   ;

                    if(mysqli_query($conn, $sql)){
                        mysqli_close($conn);
                        header('Location: attendance_List.php?id='. $event_id);
                    } else {
                        // error
                        echo 'query error: ' . mysqli_error($conn);
                    }
                    }
            }
    }
 
 
// DELETE DATA
// ------------------------------------------------------------------------------------------
    if(isset($_POST['delete'])){
        

        $delete_record = mysqli_real_escape_string($conn, $_POST['delete_record']);
        $event_id= mysqli_real_escape_string($conn, $_POST['event_id']);
        $sql = "UPDATE attendance_records SET archived = 1 WHERE record_id=$delete_record";
        if(mysqli_query($conn, $sql)){
            mysqli_close($conn);
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

 <form action="exporttoexcel.php" method="GET">
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

 

 