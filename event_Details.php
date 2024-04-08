A<?php include('config/auth/auth_all.php');?>
<?php require('config/Controller/event_details_controller.php');?>


<?php include('template/header.php');?>
        <h4>Edit Event</h4>
<form action="event_Details.php" method="POST"> 

    <label for="eventName">Event Name</label><br>
    <input name="eventName"  value="<?php echo  htmlspecialchars($eventList['eventName']); ?> " type="text"><br> 
    Background image: <input type="file" name="eventBackgroundImage" accept=".jpg, .png, .jpeg, .gif," > <br>
     Header Image: <input type="file" name="eventHeaderImage" accept=".jpg, .png, .jpeg, .gif,"> <br>
     <p style="color:red;"> <?php echo  $errors['eventStart'] ?? '' ;?> </p> 
     Event Start: <input type="date" name="eventStart" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($eventList['eventStart']); ?> " ><br>
     <p style="color:red;"><?php echo  $errors['eventEnd'] ?? '' ;?></p>
     Event End <input type="date" name="eventEnd" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($eventList['eventEnd']); ?> " >
     <br>       
    <input type="hidden" name="event_id"  value="<?php echo htmlspecialchars($eventList['event_id']); ?>">
    <input type="submit"   value="submit" name="submit">

 
</form>
<form action="event_Details.php" method="POST">
 
<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eventList['event_id']);?>">
<input type="submit" name="delete" value="delete" >  
</form>

<a href="event_List.php">BACK</a>
 

<?php include('template/footer.php');?>
 
 