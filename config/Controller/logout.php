
<?php
session_start();

if(isset($_SESSION['username'])  && isset($_SESSION['password'])):
    setcookie('remember_me', '', time() - 3600, '/');
    session_start();
    session_unset();
    session_destroy();

    header("Location: ../../index.php");
else:
    header('Location:../../index.php');

endif;
?>