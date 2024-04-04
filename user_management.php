<?php include('authentication.php');?>

<?php 
include_once('config/db_connect.php');

$errors =  array('user_input' => '');
// SUBMIT
if(isset($_POST['createSubmit'])){

    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);


    if(empty($user_name) OR empty($user_password)){
        $errors['user_input'] = "username and password is required!";


    } else{

        if(preg_match('/^.{8,}$/',$user_password) ){
            $sql = "INSERT INTO user(user_name, user_password, user_role) 
            VALUES('$user_name', '$user_password', '$user_role')";
        
            if(mysqli_query($conn, $sql)){
                mysqli_close($conn);
                header('Location: user_management.php');
            }else{
                echo 'query error: ' . mysqli_error($conn);
                mysqli_close($conn);
            }
            
        }
        else{ 
            $errors['user_input'] = "password must be at least 8 characters long.";
    }
    }
    
   


}
// DISPLAY
include_once('config/db_connect.php');

    $sqlDisplay = "SELECT * FROM user WHERE user_id > 1";
    $result = mysqli_query($conn, $sqlDisplay);
    $userList = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($conn);

?>

<?php include('template/header.php');?>


<!-- user_name user_password -->
<span style="color:red;"><?php echo htmlspecialchars($errors['user_input']); ?></span>
<form action="user_management.php" method="POST">
<input type="text" name="user_name" value="<?php if(isset($user_name)): echo $user_name; endif;?>">
<input type="password" name="user_password">
<select id="user_role" name="user_role">
  <option value="admin">admin</option>
  <option value="user">user</option>
</select>
<input type="submit" name="createSubmit" value="submit ">
</form>
<br>
<?php if($userList):?>
<table>
<tr>
<th>Username</th>
<th>Password</th>
</tr>

<?php foreach($userList as $user):?>
<tr>
<td><?php echo htmlspecialchars($user['user_name']);?></td>
<td><?php $count = strlen(htmlspecialchars($user['user_password']));
     for ($x = 0; $x <= $count; $x++) {
        echo "*";
        }
?>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif;?>




    <?php include('template/footer.php');?>
 
