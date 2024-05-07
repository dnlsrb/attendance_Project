<?php include('config/auth/auth_all.php');?>
 
<?php require('config/Controller/attendance_controller.php');?>
 
 
 
 
<!-- SCRIPT -->
<script src="js/instascan.js"></script>
<script src="js/time.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="  crossorigin="anonymous"></script>
<!-- SCRIPT -->
 
 
<style>
    body{
    background-image:url("image/background/<?php echo htmlspecialchars($eventLists['eventBackgroundImage']);?>");
    background-size: cover;
    background-repeat:no-repeat;
        
    } 
</style>

<div class="position-relative"> 

<?php $header= 'background-image:url( image/header/' . htmlspecialchars($eventLists['eventHeaderImage']) . ' ) ;  background-size: cover; height:20vh;'?>
<?php $title = htmlspecialchars($eventLists['eventName']);?>
<?php include('template/header.php')?>
 
 
 
 
<div class="container-fluid position-relative">
<div class="toast-container position-static">
  
</div>  
<?php if(isset($name_error)):
        echo '<div class="alert alert-danger position-absolute top-0 end-0 m-3 " role="alert">';
        echo $name_error['attendeesError'];
        echo ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
     ?>
<?php endif;?>
<div class="row">
<div class="d-flex justify-content-center align-items-center mt-3 "> 
    
    <h3 class="fw-bold"><u><?php echo htmlspecialchars($eventLists['eventName']);?></u> </h3>
    <span class="badge text-bg-primary m-3"  id="count"></span>
    <hr>    
</div>
    <div class="col-sm-4 col-12  ">
 
<div class="text-center mt-3 mb-2" onLoad="startTime()"> 
    <strong>
        <time class="display-3 fw-bold" id="time">00:00:00</time><br>
        <p  class="h5"><?php echo "Today is ".date("l F d, Y");?></p>
    </strong>
</div>

    <video  id="preview"  width="100%"> </video>
    <p class="h6 text-center " id="waitMessage"></p>
    
<form  id="scan_form" autocomplete="off"     >
<div > 
    <input type="text" name="attendeesName" id="attendeesName" class="w-100 form-control" placeholder="Attendees Name" > 
    <input type="hidden" name="event_id" id="get_id" value="<?php echo htmlspecialchars($id);  ?>">
    <input type="submit" id="btnsubmit"  class="d-sm-none w-100" name="submit" value="submit"> 
    <!-- d-sm-none  -->
    </div>
</form>
</div>
<script>
$(function() {
        function sendData($form){
            let dataString = $form.serialize();

            return $.ajax({
                type: 'POST',
                url: 'get_attendance.php',
                data: dataString
            });
        }
   
     $('form').on('submit', function(e) {
        e.preventDefault();
        
        let $attendeesNameInput = $('#attendeesName');
        sendData($(this)).done(function() {
            e.preventDefault();
            $attendeesNameInput.val('');
 
                
        });

     });
}); 
</script> 
 
    <div class="col">
    <div id="message"></div>
    <?php if($eventLists):?>
<table class="no-background table table-transparent shadow-sm opacity-75">
    <thead>
        <tr>
  
            <th>NAME</th>
            <th>TIME IN</th>
            <th>TIME OUT</th>
        </tr>
    </thead>
    <tbody id="data-container">
        <!-- Attendance data will be appended here -->
    </tbody>
</table>

<script src="js/camera.js"></script>

<?php else: ?>
<?php endif; ?>
    </div>
</div>

</div>


 
 
 
<br>
 
</div>
</div>
 
<div class="position-absolute top-0 start-0">
<button type="button" id="click" class="btn border-0"><i   id="icon" class="fa-solid fa-caret-down"></i></button>
</div>

<script>
$(function() {
    // Function to fetch attendance data
    function fetchAttendance() {
        $.ajax({
            type: "GET",
            url: "get_list_attendance.php?id=<?php echo $id;?>",
            dataType: "json",
            success: function(data) {
                $("#data-container").empty();
                data.attendees_Records.forEach(function(record) {
                    $("#data-container").append('<tr><td class="fw-bold">' + record.attendeesName + '</td>' + '<td class="fw-bold text-success">' + record.time_IN+ '</td>' + '<td class="fw-bold text-primary  ">' + record.time_OUT + '</td></tr>');
                    
                });
                $("#count").html('<tr><td class="fw-bold">' +data.count_display +'</tr>');
            }
        });
    }
   
 
    // Fetch attendance initially
    fetchAttendance();

    // Update attendance every 5 seconds (adjust interval as needed)
    setInterval(fetchAttendance, 2000);
});

</script>
<script>
  document.getElementById('click').addEventListener('click', function() {
    var icon = document.getElementById("icon");
        if (icon.classList.contains("fa-caret-down")) {
            icon.classList.remove("fa-caret-down");
            icon.classList.add("fa-caret-up");
        } else {
            icon.classList.remove("fa-caret-up");
            icon.classList.add("fa-caret-down");
        }
    var hiddenElement = document.getElementById('hidden-class-2');
    hiddenElement.classList.toggle('d-none');
  });
</script>
</div>
</div>
</div>
</div>
<?php include('template/footer.php')?>

 

 