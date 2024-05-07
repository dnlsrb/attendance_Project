<?php include('config/auth/auth_all.php'); ?>
<?php include('config/auth/auth_admin.php');?>
<?php require('config/Controller/user_management_controller.php'); ?>

<?php $title = "User Management";?>
<?php include('template/header.php'); ?>




<div class="container-fluid  ">
<h3 class="mt-3">User</h3>
  <div class="row d-flex align-items-start justify-content-center  ">
    <div class="col-md-3 col-12  my-auto ">
      <div class="card rounded-0  ">
        <div class="card-header">
          <div class="card-title">Create User</div>
        </div>
        <div class="card-body">
          <form action="user_management.php" method="POST">
            <span class="text-danger"><?php echo htmlspecialchars($errors['user_name'] ?? ''); ?></span><br>
            <input type="text" class="form-control" name="user_name" placeholder="username" value="<?php echo $userData['user_name'] ?? '' ?>"><br>
            <span class="text-danger"><?php echo htmlspecialchars($errors['user_password']  ?? ''); ?></span>
            <input type="password" class="form-control" name="user_password" placeholder="password"><br>
            <input type="password" class="form-control" name="confirm_password" placeholder="confirm password">
            <br>


            <span class="text-danger"><?php echo htmlspecialchars($errors['user_remark']  ?? ''); ?></span>
            <div class="form-floating">
              <textarea class="form-control" id="user_remark" type="text" name="user_remark"><?php echo htmlspecialchars($userData['user_remark']  ?? '') ?></textarea>
              <label for="floatingTextarea">Remarks (optional)</label>
            </div>

            <br>
            <input type="submit" class="  form-control" name="createSubmit" value="Confirm">
          </form>
        </div>
      </div>


    </div>
    <?php if ($userList) : ?>
    <div class="col mt-2    ">

    
        <form action="user_management.php" method="POST">
          <div class="d-flex  ">
            <input type="submit" name="editSubmit" value="Save" class="btn btn-primary mb-3 rounded-0  ">
          </div>

          <div class="overflow-x-auto">
            <table class="table border border-1   rounded ">
              <tr>
                <th>Username</th>
                <th class="text-center">Remarks</th>
                <th class="text-center">Role</th>
                <th class="text-center">Archive</th>
              </tr>
              <?php foreach ($userList as $user) : ?>
                <tr>
                  <td><?php echo htmlspecialchars($user['user_name']); ?></td>
        
                  <td class="text-center">
                    <textarea class="form-control" name="user_remark[]"><?php echo htmlspecialchars($user['user_remark'] ?? ''); ?></textarea>
                  </td>
                  <td class="text-center">
                    <select class="form-control" name="user_role[]">
                      <option <?php if ($user['user_role'] == 0) echo 'selected'; ?> value="0">User</option>
                      <option <?php if ($user['user_role'] == 1) echo 'selected'; ?> value="1">Admin</option>

                    </select> 
                  </td>

                  <td class="text-center"> 
             
                  <input type="checkbox" name="isArchive[]"    value="<?php echo $user['user_id']; ?>"> 
                    
                  </td>

                  <input type="hidden" name="user_id[]" value="<?php echo $user['user_id']; ?>"  >
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
    </div>
    </form>
  <?php else : ?>
  
    <div class=" text-center order-1 my-5">
          
            <h class="display-6">No User Found</h>
        
      </div>
  <?php endif; ?>
  </div>
</div>


</div>







<?php include('template/footer.php'); ?>