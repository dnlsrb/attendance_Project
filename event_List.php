
  
 <?php
// $a = 4;
// if($a == 5):
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
 

  $total = "SELECT COUNT(*) as count FROM event_list WHERE LAST_DAY(CURDATE()) >= created_At AND DAYOFMONTH(CURDATE()) <= created_At";
  $submit_result = mysqli_query($conn, $total);
  $count = mysqli_fetch_assoc($submit_result)['count'];
  $currentDateTime = date('my');
  $event_id = $currentDateTime . $event_id  . $count + 1;

      $sql = "INSERT INTO event_list(eventName, eventHeaderImage, eventBackgroundImage, eventStart, eventEnd, event_id) 
      VALUES ('$eventName', '$eventHeaderImage','$eventBackgroundImage','$eventStart','$eventEnd','$event_id')";

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
  $sql = 'SELECT * FROM event_list ORDER BY created_At';
  $result = mysqli_query($conn, $sql);
  $eventLists= mysqli_fetch_all($result, MYSQLI_ASSOC);

  mysqli_free_result($result);
  mysqli_close($conn);


?>

<?php include('template/header.php')?>
 
    
    <form action="event_List.php" method="POST">
     <p>Create Event</p>
    Event Name: <input type="text" name="eventName"><br>
    Background image: <input type="file" name="eventBackgroundImage" ><br>
    Header Image: <input type="file" name="eventHeaderImage" ><br>
    Event Start: <input type="date" name="eventStart" ><br>
    Event End <input type="date" name="eventEnd" >
    <br>
    <input type="submit"  value="submit" name="submit">
    </form>
    <br>  
    <?php if($eventLists):?>
        <?php $orderNumber = 1; ?> 
      <h>Event List</h>
    <table>
    <tr>
      <th>#</th>
      <th>Event ID</th>
        <th>Event Name</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
   
    <?php  echo '<tr>'; foreach( $eventLists as $events):?>
      
    <td><?php echo $orderNumber . ".";  ?></td>
    <td><?php echo htmlspecialchars($events['event_id']);  ?></td>
    <td><?php echo htmlspecialchars($events['eventName']);  ?></td>
    <td><?php echo htmlspecialchars($events['eventStart']);  ?></td>
    <td><?php echo htmlspecialchars($events['eventEnd']);  ?></td>
    <td><a href="attendance_List.php?id=<?php echo $events['event_id'];  ?>">List of Attendees</a></td>
    <td><a href="event_Details.php?id=<?php echo $events['event_id']; ?>">Event Details</a></td>
    <?php $orderNumber++;?>
    <?php echo '<tr>';   endforeach;?>
    </table>
    <?php else: ?>
    <h1>No Data Found, Create Event</h1>

    <?php endif ?>
    <a href="index.php">go back</a>

<?php 
// else:
//  header('Location: index.php');

// endif;
?>
 
    


<?php include('template/footer.php')?>

