<?php
session_start();
if(isset($_SESSION['username'])  && isset($_SESSION['password'])):
    header('Location: event_List.php');
else:
?>
<?php include('template/header.php')?>

 

 
<div  class="container-fluid  justify-content-center align-items-center d-flex  " >
<div   > 
<form action="login.php" class="card p-3"  method="POST">


<input type="text" class="form-control mb-3" name="username" placeholder="username">
<input type="password" class="form-control mb-3" name="password" placeholder="password">
<input type="submit" class="btn btn-primary mb-3"  value="Log in" >

</form>
 
</div>
</div>




<?php include('template/footer.php')?>
<?php endif; ?>

 