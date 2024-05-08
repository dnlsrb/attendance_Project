
<?php
session_start();
include('../database/db_connect.php');
if(isset($_SESSION['username'])  && isset($_SESSION['password'])):
    // $user = $_SESSION['username'];
 
    setcookie('remember_me', '', time() - 3600, '/');
    session_unset();
    session_destroy();
 

         
 
        // $sql = "UPDATE user SET remember_token = '' WHERE user_name = $user";
        // if(mysqli_query( $conn, $sql)){
        //     mysqli_close( $conn);
        //     header("Location: ../../index.php");    
        //     exit();
        // }else{
        //     echo 'query error: ' . mysqli_error($conn);
        // }
    header('Location:index.php');   
else:
    header('Location:index.php');

endif;
?>