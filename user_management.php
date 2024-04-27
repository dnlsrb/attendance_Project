<?php include ('config/auth/auth_all.php'); ?>
<?php require ('config/Controller/user_management_controller.php'); ?>


<?php include ('template/header.php'); ?>

 
 
 
<div class="container-fluid bg-light mt-5">
<div class="row d-flex align-items-start  ">
<div class="col-md-3 col-12  my-auto ">
  <div class="card rounded-0">
    <div class="card-header">
      <div class="card-title">Create User</div>
    </div>
    <div class="card-body">
    <form action="user_management.php" method="POST">
        <span class="text-danger"><?php echo htmlspecialchars($errors['user_name'] ?? ''  ); ?></span><br>
        <input type="text"  class="form-control" name="user_name" placeholder="username" value="<?php echo $userData['user_name'] ?? '' ?>"><br>
        <span class="text-danger"><?php echo htmlspecialchars($errors['user_password']  ?? '' ); ?></span> 
        <input type="password"  class="form-control" name="user_password" placeholder="password"><br>
        <input type="password"  class="form-control" name="confirm_password" placeholder="confirm password"> 
        <br>
        Role:
        <select id="user_role" name="user_role">
          <option value="admin">admin</option>
          <option value="user">user</option>
        </select> 
        <br><br>
        <label for="user_remark">Remarks (optional)</label> 
        <span class="text-danger"><?php echo htmlspecialchars($errors['user_remark']  ?? '' ); ?></span><br>
        <textarea  class="form-control" id="user_remark" type="text"   name="user_remark"><?php echo $user_remark ?? '' ?></textarea> 
        <br>
        <input type="submit" class="  form-control" name="createSubmit" value="Create User "> 
      </form>
    </div>
  </div>
     
  
</div>
<div class="col mt-2    ">

  <?php if ($userList): ?>
    <div class="d-flex  ">
      <a href="event_List.php" class="btn btn-primary mb-3 rounded-0">Save</a>

    </div>
    <table class="table">
      <tr>
        <th>Username</th>
        <th  class="text-center">Remark</th>
        <th class="text-center">Admin</th>
        <th class="text-center">Archive</th> 
      </tr>
      <?php foreach ($userList as $user): ?>
        <tr>
          <td><?php echo htmlspecialchars($user['user_name']); ?></td>
          <!-- <td><?php echo htmlspecialchars($user['user_role']); ?></td> -->
          <td  class="text-center"><textarea><?php echo htmlspecialchars($user['user_remark'] ?? '' ); ?> </textarea></td>
          <td class="text-center"><input type="checkbox"  ></td>
          <td class="text-center">
         
          <!-- <form action="user_management.php"   method="POST">
              <input type="hidden" name="change_password_id" value="<?php echo htmlspecialchars($user['user_id']) ?>">
              <input type="submit"   name="change_password" value="change password">
            </form> -->
            <input type="checkbox"  >
              <!-- <form action="user_management.php" method="POST">
                <input type="hidden" name="delete_user_id" value="<?php echo htmlspecialchars($user['user_id']) ?>">
                <input type="submit" name="delete_user" value="archive">
              </form> -->
          
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
      
  <?php else: ?>
    <h2>No User Found</h2>
  <?php endif; ?>
</div>
</div>


</div>
 
 
 
 
 


<?php include ('template/footer.php'); ?>