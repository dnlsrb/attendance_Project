<?php include('config/auth/auth_all.php'); ?>
<?php include('config/auth/auth_admin.php');?>
<?php require('config/Controller/user_management_controller.php'); ?>

<?php $title = "User Management";?>
<?php include('template/header.php'); ?>




<div class="container-fluid ">
 
  <div class="row mt-2  ">
  <div class=" d-flex align-items-center justify-content-between   "> 
  <h2 class="p-0 m-0">User Management</h2>
  <a type="button" class="btn btn-primary"
        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" data-bs-toggle="modal" data-bs-target="#createNewUser">Create New User</a>
  </div>
  <!-- Modal -->
<div class="modal " id="createNewUser" tabindex="-1" aria-labelledby="createNewUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createNewUserLabel">Create User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="user_management.php" id="user" method="POST"  autocomplete="off" >
             
            <input type="text" class="form-control border-secondary" name="user_name" placeholder="username" value="<?php echo $userData['user_name'] ?? '' ?>"> 
            <?php if (isset($errors['user_name'])):?>
            <div class="alert alert-danger p-0 m-0 rounded-0 w-100" role="alert"><i class="fa-solid fa-circle-exclamation me-1"></i><?php echo htmlspecialchars($errors['user_name'] ?? ''); ?></div> 
            <?php endif;?>
            <br>
            
            <input type="password" class="form-control border-secondary" name="user_password" placeholder="password"> 
            <?php if (isset($errors['user_password'])):?>
            <div class="alert alert-danger p-0 m-0 rounded-0 w-100" role="alert"><i class="fa-solid fa-circle-exclamation me-1"></i><?php echo htmlspecialchars($errors['user_password']  ?? ''); ?></div> 
            <?php endif;?>
             <br>
            <input type="password" class="form-control border-secondary" name="confirm_password" placeholder="confirm password">
            <br>


 
            <div class="form-floating ">
              <textarea class="form-control border-secondary" id="user_remark" type="text" name="user_remark"><?php echo htmlspecialchars($userData['user_remark']  ?? '') ?></textarea>
              <label for="floatingTextarea">Remarks (optional)</label>
            </div>
            <?php if (isset($errors['user_remark'])):?>
            <div class="alert alert-danger p-0 m-0 rounded-0 w-100" role="alert"><i class="fa-solid fa-circle-exclamation me-1"></i><?php echo htmlspecialchars($errors['user_remark']  ?? ''); ?></div>
            <?php endif;?>
            <br>
            <input type="submit" class="btn btn-primary border-secondary form-control" name="createSubmit" value="Confirm">
        
      </form>
      </div>
 
    </div>
  </div>
</div>

<?php if (isset($errors)):
            echo "<script>
             // This script can be removed if you want to open the modal only using Bootstrap data attributes
             var myModal = new bootstrap.Modal(document.getElementById('createNewUser'));
             myModal.show();
         </script>";
        
            unset($errors['eventName']);
        endif; ?>

    <?php if ($userList) : ?>
    <div class="col    ">

        <form action="user_management.php" id="userform" method="POST">
          <div class="d-flex justify-content-between align-items-center py-3">
            <input type="submit"  class="btn btn-primary"
        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" name="editSubmit" value="Save" class="btn btn-primary mb-3 rounded-0  "> 
            <div> 
             
            </div>
          </div>

          <div class="overflow-x-auto   rounded">
            <table class="table  table-borderless  rounded ">
              <tr class="table-secondary">
                <th>Username</th>
                <th class="text-center">Remarks</th>
                <th class="text-center">Role</th>
                <th class="text-center">Archive</th>
              </tr>
              <?php foreach ($userList as $user) : ?>
                <tr>
                  <td class="text-truncate d-inline-block" style="max-width:150px;"><?php echo htmlspecialchars($user['user_name']); ?></td>
        
                  <td class="text-center" style="min-width:150px;">
                    <textarea class="form-control border rounded-0 bg-body-secondary" name="user_remark[]"><?php echo htmlspecialchars($user['user_remark'] ?? ''); ?></textarea>
                  </td>
                  <td class="text-center" style="min-width:90px;">
                    <select class="form-control border bg-body-secondary" name="user_role[]">
                      <option class="rounded-0" <?php if ($user['user_role'] == 0) echo 'selected'; ?> value="0">User</option>
                      <option  class="rounded-0" <?php if ($user['user_role'] == 1) echo 'selected'; ?> value="1">Admin</option>

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
  
    <div class=" text-center order-1 my-5 ">
          
            <h class="display-6">No User Found</h>
        
      </div>
  <?php endif; ?>
  </div>
</div>


</div>







<?php include('template/footer.php'); ?>