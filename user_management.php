<?php include('config/auth/auth_all.php');?>
<?php require('config/Controller/user_management_controller.php');?>


<?php include('template/header.php');?>


<!-- user_name user_password -->
 
<form action="user_management.php" method="POST">
<span style="color:red;"><?php echo htmlspecialchars($errors['user_name']); ?></span><br>
<input type="text" name="user_name" placeholder="username" value="<?php echo $user_name ?? ''?>"  ><br>
<span style="color:red;"><?php echo htmlspecialchars($errors['user_password']); ?></span><br>
<input type="password" name="user_password" placeholder="password"  ><br><br>
<input type="password" name="confirm_password" placeholder="confirm password"><br><br>
Role:
<select id="user_role" name="user_role">
  <option value="admin">admin</option>
  <option value="user">user</option>
</select><br><br>
<input type="submit" name="createSubmit" value="submit ">
</form>
<br>
<?php if($userList):?>
<table>
<tr>
<th>Username</th>
<!-- <th>Password</th> -->
</tr>

<?php foreach($userList as $user):?>
<tr>
<td><?php echo htmlspecialchars($user['user_name']);?></td>
<!-- <td><?php $count = strlen(htmlspecialchars($user['user_password']));
     for ($x = 0; $x <= $count; $x++) {
        echo "*";
        }
?>
</td> -->
</tr>
<?php endforeach; ?>
</table>
<?php endif;?>




    <?php include('template/footer.php');?>
 
