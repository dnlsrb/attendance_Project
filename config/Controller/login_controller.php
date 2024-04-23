<?php
session_start();
include_once('config/database/db_connect.php');

 if(isset($_POST['submit'])){

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);


    $login_query = "SELECT * FROM user WHERE user_name = '$username' &&  archived = 0";
    $login_result = mysqli_query($conn, $login_query);
    $row = mysqli_fetch_assoc($login_result);

//  mysqli_num_rows($login_result) === 1
if(password_verify($password, $row['user_password'])){
 
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['password'] = $row['user_password'];
            $_SESSION['role'] = $row['user_role'];
            mysqli_free_result($login_result);
             
            mysqli_close($conn);
            header("Location: event_List.php" );
            exit();
    
}else{
     
    mysqli_free_result($login_result);
 
    mysqli_close($conn);
    header("Location: index.php?error=User not found");
}
 
}
 


?>