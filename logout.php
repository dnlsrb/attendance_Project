
<?php
session_start();
if($_SESSION['role'] === 'admin' && isset($_SESSION['username'])  && isset($_SESSION['password'])):
?>
<?php 
session_start();

session_unset();
session_destroy();

header("Location: index.php");
?>



<?php 
else:
header('Location: index.php');

endif;
?>