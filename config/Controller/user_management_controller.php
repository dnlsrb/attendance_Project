
<?php 
include_once('config/database/db_connect.php');

$errors =  array('user_password' => '', 'user_name' => '');

// SUBMIT
if(isset($_POST['createSubmit'])){

  

    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);

    // VALIDATION
    
    // PASSWORD
    if(empty($_POST['user_password'])){ 
        $errors['user_password'] = "password is required!";
    }else{
   
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        if($confirm_password != $user_password){
            $errors['user_password'] = "password and confirmation password is not the same";
        }
        elseif(!preg_match('/^.{8,}$/',$user_password) ){
            $errors['user_password'] = "password must be at least 8 characters long.";  
        }
    }

    // USERNAME
    if(empty($_POST['user_name'])){
        $errors['user_name'] = " username is required!";
    }else{
        include('config/database/db_connect.php'); 
        $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
        $query =  "SELECT user_name FROM user WHERE user_name='".$user_name."'";
        $result_user = mysqli_query($conn, $query);
        mysqli_close($conn);
        if(mysqli_num_rows($result_user) != 0){
            $errors['user_name'] = "user already matched";
        }
    }

    if(!array_filter($errors)){
      
        include('config/database/db_connect.php');

            $hashedPassword = password_hash($user_password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(user_name, user_password, user_role) 
            VALUES('$user_name', '$hashedPassword', '$user_role')";
        
            if(mysqli_query($conn, $sql)){
                mysqli_close($conn);
                header('Location: user_management.php');
            }else{
                echo 'query error: ' . mysqli_error($conn);
                mysqli_close($conn);
            }
    }
    
   


}
include('config/database/db_connect.php');
$sqlDisplay = "SELECT * FROM user WHERE user_id > 1";
$result = mysqli_query($conn, $sqlDisplay);
$userList = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
mysqli_close($conn);
 
?>