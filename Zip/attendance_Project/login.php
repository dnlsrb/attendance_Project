<?php
session_start();
include_once('config/db_connect.php');

 

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$login_query = "SELECT * FROM user WHERE user_name = '$username' AND user_password = '$password'";
$login_result = mysqli_query($conn, $login_query);
 
if(mysqli_num_rows($login_result) === 1){
    $row = mysqli_fetch_assoc($login_result);
 
     
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['password'] = $row['user_password'];
            $_SESSION['role'] = $row['user_role'];
            header("Location: event_List.php");
            mysqli_free_result($login_result);
            mysqli_close($conn);
            exit();
        
       
    
}else{
     
    mysqli_free_result($login_result);
    mysqli_close($conn);
    header("Location: index.php?error=Wrong Input!");
}

 
 
 


?>