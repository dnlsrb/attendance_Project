<?php include('config/auth/auth_all.php');?>
<?php require('config/Controller/event_list_controller.php');?>


<?php include('template/header.php')?>
 


 
<!--  -->
    <h3  >Create Event</h3>

    <form action="event_List.php"   method="POST" enctype="multipart/form-data">
     
    <p style="color:red;"> <?php echo $errors['eventName'] ?? '' ;?><p>
     Event Name: <input type="text" name="eventName" value="<?php echo $eventName ?? ''?>"><br>
     Background image: <input type="file" name="eventBackgroundImage" accept=".jpg, .png, .jpeg, .gif," > <br>
     Header Image: <input type="file" name="eventHeaderImage" accept=".jpg, .png, .jpeg, .gif,"> <br>
     <p style="color:red;"> <?php echo  $errors['eventStart'] ?? '' ;?> </p> 
     Event Start: <input type="date" name="eventStart" min="<?php echo date('Y-m-d'); ?>"><br>
     <p style="color:red;"><?php echo  $errors['eventEnd'] ?? '' ;?></p>
     Event End <input type="date" name="eventEnd" min="<?php echo date('Y-m-d'); ?>">
     <br>
     <input type="submit"  value="submit" name="submit">
     </form>
 
    <h3 >Event List</h3>
    <?php if($eventLists):?>
        <?php $orderNumber = 1; ?> 
 
    <table>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Event ID</th>
        <th>Event Name</th>
        <th>Start Date</th>
        <th>End Date</th>
         
        <th></th>
        <th></th>
    </tr>

 
    <?php  echo '<tr>'; foreach( $eventLists as $eventLists):?>
      
    <th scope="row"><?php echo $orderNumber . ".";  ?></th>
    <td ><?php echo htmlspecialchars($eventLists['event_id']);?></td>
    <td><?php echo htmlspecialchars($eventLists['eventName']);  ?></td>
    <td><?php echo htmlspecialchars($eventLists['eventStart']);  ?></td>
    <td><?php echo htmlspecialchars($eventLists['eventEnd']);  ?></td>
    
    <td><a href="attendance_List.php?id=<?php echo $eventLists['event_id'];  ?>"><i class="bi bi-eye"></i> List</a> </td>
    <td><a href="event_Details.php?id=<?php echo $eventLists['event_id']; ?>">
    <i > </i>Details</a></td>
    <?php $orderNumber++;?>
    <?php echo '<tr>';   endforeach;?>
    </table>
    <?php else: ?>
    <h1>No Data Found, Create Event</h1>

    <?php endif ?>
<!--  -->

      


<?php include('template/footer.php')?>

 