<?php require('config/Controller/login_controller.php');?> 
 
<?php
if(isset($_SESSION['username'])  && isset($_SESSION['password'])):
    header('Location: event_List.php');
else:
?>


<?php 
include('template/header.php')
?>
 
<form action="index.php"  method="POST">
<span style="color:red;"><?php 
include('config/database/db_connect.php');
if(isset( $_GET['error'])){
$error = mysqli_real_escape_string($conn, $_GET['error']);
echo $error . "<br/>";
}
?>
</span>
<input type="text" name="username" placeholder="username">
<input type="password" name="password" placeholder="password">
<input type="submit"  value="Log in" name="submit">
</form>
 
 




<?php include('template/footer.php')?>
<?php endif; ?>

 