<?php
session_start();
 
if(isset($_SESSION['username'])  && isset($_SESSION['password'])):
    include('config/database/db_connect.php');
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $password = mysqli_real_escape_string($conn, $_SESSION['password']);
    
    
        $login_query = "SELECT * FROM user WHERE user_name = '$username' &&  archived = 0";
        $login_result = mysqli_query($conn, $login_query);
        $row = mysqli_fetch_assoc($login_result);
    
    //  mysqli_num_rows($login_result) === 1
    if($password == htmlspecialchars($row['user_password']) && $username == htmlspecialchars($row['user_name'])){
     
    }else{
        header("Location: config/Controller/logout.php");
    }
else:
header("Location:  index.php");

endif;
?>