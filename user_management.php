<?php include ('config/auth/auth_all.php'); ?>
<?php require ('config/Controller/user_management_controller.php'); ?>


<?php include ('template/header.php'); ?>


<!-- user_name user_password -->

<form action="user_management.php" method="POST">
  <span style="color:red;"><?php echo htmlspecialchars($errors['user_name']); ?></span><br>
  <input type="text" name="user_name" placeholder="username" value="<?php echo $user_name ?? '' ?>"><br>
  <span style="color:red;"><?php echo htmlspecialchars($errors['user_password']); ?></span><br>
  <input type="password" name="user_password" placeholder="password"><br><br>
  <input type="password" name="confirm_password" placeholder="confirm password"><br><br>
  Role:
  <select id="user_role" name="user_role">
    <option value="admin">admin</option>
    <option value="user">user</option>
  </select><br><br>
  <label for="user_remark">Remarks (optional)</label><br>  
  <input id="user_remark" type="text" name="remark"><br><br>
  <input type="submit" name="createSubmit" value="submit ">
</form>
<br>
<?php if ($userList): ?>
  <table>
    <tr>
      <th>Username</th>
      <th>Role</th>
      <th></th> 
    </tr>

    <?php foreach ($userList as $user): ?>
      <tr>
        <td><?php echo htmlspecialchars($user['user_name']); ?></td>
        <td><?php echo htmlspecialchars($user['user_role']); ?></td>
        <td class="d-flex">
        <form action="user_management.php" method="POST">
            <input type="hidden" name="change_password_id" value="<?php echo htmlspecialchars($user['user_id']) ?>">
            <input type="submit" class="mx-3" name="change_password" value="change password">
          </form>
          <form action="user_management.php" method="POST">
            <input type="hidden" name="delete_user_id" value="<?php echo htmlspecialchars($user['user_id']) ?>">
            <input type="submit" name="delete_user" value="delete">
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <h2>No User Found</h2>
<?php endif; ?>




<?php include ('template/footer.php'); ?>