<?php
session_start();
if(isset($_SESSION['username'])  && isset($_SESSION['password'])):
    header('Location: event_List.php');
else:
?>
<?php include('template/header.php')?>



 
 
<form action="login.php"   method="POST">
<?php 
include('config/db_connect.php');
if(isset( $_GET['error'])){
$error = mysqli_real_escape_string($conn, $_GET['error']);
echo $error . "<br/>";
}
?>
<input type="text" name="username" placeholder="username">
<input type="password" name="password" placeholder="password">
<input type="submit"  value="Log in" >
</form>
 
 




<?php include('template/footer.php')?>
<?php endif; ?>

 