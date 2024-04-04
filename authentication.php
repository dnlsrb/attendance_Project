<?php
session_start();
 
if(isset($_SESSION['username'])  && isset($_SESSION['password'])):
 
else:
header('Location: index.php');

endif;
?>