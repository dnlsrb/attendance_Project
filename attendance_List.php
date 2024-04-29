<?php include('config/auth/auth_all.php');?>
<?php require('config/Controller/attendance_controller.php');?>


<!-- SCRIPT -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
<script src="js/instascan.js"></script>
<script src="js/time.js"></script>
 
<!-- SCRIPT -->

 
<style>
  table {
    background-image:url("image/background/<?php echo htmlspecialchars($eventLists['eventBackgroundImage']);?>");
    background-size: cover;
 
  }
</style>
 
<div class="position-relative"> 


<?php $title = htmlspecialchars($eventLists['eventName']);?>
<?php include('template/header.php')?>
<?php if(isset($name_error)):
        echo '<div class="alert alert-danger position-absolute top-0 end-0 m-3 " role="alert">';
        echo $name_error['attendeesError'];
        echo ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
     ?>
<?php endif;?>
 

<div onLoad="startTime()"> 
    <strong>
        <time id="time">00:00:00</time><br>
        <?php echo "Today is ".date("l F d, Y");?>
    </strong>
</div>
 
    
<video id="preview" width="50%" height="50%"></video>
<p id="waitMessage"></p>
 
<br>
<?php if($eventLists):?>
 
    <a href="event_List.php">Go Back </a><br>

 <form action="export_to_excel.php" method="GET">
    <input type="submit" name="getsubmit" value="Download Excel">
    <!-- <input type="hidden" name="authentication" value="allowed"> -->
    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($id);  ?>">
</form>
 
<form  id="scan_form"  action="attendance_List.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST">
    
    <h3>Event Name: <?php echo htmlspecialchars($eventLists['eventName']);?></h3>
    <input type="text" name="attendeesName"  id="attendeesName" placeholder="Attendees Name" value=""> 
    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($id);  ?>">
    <input type="submit" id="btnsubmit" name="submit" value="submit">
</form>
<script src="js/camera.js"></script>
 
 
<iframe src="iframe_attendance.php?id=<?php echo htmlspecialchars($id); ?>"  scrolling="yes" width="100%" height="300px" frameborder="0"></iframe>

<?php else: ?>
    <h>no data found</h><br>
    <?php endif; ?>
    </div>
</div>
 


</div>
</div>
</div>
</div>
<?php include('template/footer.php')?>

 

 