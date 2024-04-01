<?php
session_start();
 
if($_SESSION['role'] === 'admin' && isset($_SESSION['username'])  && isset($_SESSION['password'])):
?>
<?php

// RECEIVE DATA

// eventName	eventHeaderImage	eventBackgroundImage	eventStart	eventEnd
if(isset($_POST['submit'])){
include_once('config/db_connect.php');

  $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
  $eventHeaderImage = 'NULL';
  $eventBackgroundImage = 'NULL';
  $eventStart = mysqli_real_escape_string($conn, $_POST['eventStart']);
  $eventEnd = mysqli_real_escape_string($conn, $_POST['eventEnd']);
 
  $event_id_query = "SELECT COUNT(*) as count_id FROM event_list WHERE (LAST_DAY(CURDATE()) - LAST_DAY(CURDATE())+1) <= DAY(created_At) AND DAY(LAST_DAY(CURDATE())) >= DAY(created_At) AND MONTH(LAST_DAY(CURDATE())) = MONTH(created_At) AND YEAR(LAST_DAY(CURDATE())) = YEAR(created_At)";
  $event_count_query = "SELECT COUNT(*) as count_event FROM event_list";

  $event_count_result = mysqli_query($conn, $event_count_query);
  $event_count_total = mysqli_fetch_assoc($event_count_result)['count_event'];
  mysqli_free_result($event_count_result);

  $event_id_result = mysqli_query($conn, $event_id_query);
  $event_id_total = mysqli_fetch_assoc($event_id_result)['count_id'];
  mysqli_free_result($event_id_result);


  $currentDateTime = date('my');
  $event_count = $event_count_total + 1;
  $event_id = $currentDateTime . $event_id_total + 1;

      $sql = "INSERT INTO event_list(eventName, eventHeaderImage, eventBackgroundImage, eventStart, eventEnd, event_id, event_count) 
      VALUES ('$eventName', '$eventHeaderImage','$eventBackgroundImage','$eventStart','$eventEnd','$event_id', '$event_count')";

      // save to db and check
      if(mysqli_query($conn, $sql)){
        //success
        header('Location: event_List.php');
      } else {
        // error
        echo 'query error: ' . mysqli_error($conn);
      }
 
mysqli_close($conn);
}
 

  // Display Event List Data
  include_once('config/db_connect.php');
  $sql = 'SELECT * FROM event_list WHERE archived = 0 ORDER BY created_At';
  $result = mysqli_query($conn, $sql);
  $eventLists= mysqli_fetch_all($result, MYSQLI_ASSOC);

  mysqli_free_result($result);
  mysqli_close($conn);


?>

<?php include('template/header.php')?>
 
<div class="container-fluid  "> 
 
 
  <div class="container  ">
  <div class="row align-items-start">
    <div class="col-10 col-md-4">
    <h3 class="text-start m-3">Create Event</h3>
    <form action="event_List.php" class="card m-0 p-3" method="POST">
     
     Event Name: <input type="text" name="eventName"><br>
     Background image: <input type="file" name="eventBackgroundImage" > <br>
     Header Image: <input type="file" name="eventHeaderImage" > <br>
     Event Start: <input type="date" name="eventStart" ><br>
     Event End <input type="date" name="eventEnd" >
     <br>
     <input type="submit"  value="submit" name="submit">
     </form>
    </div>
    <div class="col">
    <h3 class="text-start m-3">Event List</h3>
    <?php if($eventLists):?>
        <?php $orderNumber = 1; ?> 
 
    <table class="table table-striped">
    <tr>
      <!-- <th scope="col">#</th>
      <th scope="col">Event ID</th> -->
        <th scope="col">Event Name</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
         
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>

 
    <?php  echo '<tr>'; foreach( $eventLists as $eventLists):?>
<!--       
    <th scope="row"><?php echo $orderNumber . ".";  ?></th>
    <td ><?php echo htmlspecialchars($eventLists['event_id']);?></td> -->
    <td><?php echo htmlspecialchars($eventLists['eventName']);  ?></td>
    <td><?php echo htmlspecialchars($eventLists['eventStart']);  ?></td>
    <td><?php echo htmlspecialchars($eventLists['eventEnd']);  ?></td>
    
    <td><a class="btn btn-primary "href="attendance_List.php?id=<?php echo $eventLists['event_id'];  ?>"><i class="bi bi-eye"></i> List</a> </td>
    <td><a class="btn btn-primary" href="event_Details.php?id=<?php echo $eventLists['event_id']; ?>">
    <i class="bi bi-card-heading"> </i>Details</a></td>
    <?php $orderNumber++;?>
    <?php echo '<tr>';   endforeach;?>
    </table>
    <?php else: ?>
    <h1>No Data Found, Create Event</h1>

    <?php endif ?>
    </div>
 
  </div>
</div> 
     
    <br>  
 
    
 </div>


<?php include('template/footer.php')?>


<?php 
else:
header('Location: index.php');

endif;
?>