<?php include('config/auth/auth_all.php'); ?>
<?php require('config/Controller/account_controller.php'); ?>

<?php $title = "Account" ?>
<?php include('template/header.php') ?>

<div class="container-fluid py-2  ">
  <h2>Account</h2>
  <div class="d-flex justify-content-center ">
    <div class="card border-0 rounded-0 p-0 m-0" style="max-width:20em;">
      <form action="account.php" method="POST" autocomplete="off">
        <div class="card-body  ">
          <div class="mb-3 row">
            <label for="staticEmail" class="col-3 col-form-label ">User:</label>
            <div class="col-5">
              <input type="text" readonly class="form-control-plaintext fw-bold" id="staticEmail" value="<?php echo $_SESSION['username']; ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="old_password" class="col-sm-12 col-form-label ">Old Password</label>
            <div class="col-sm-12">

              <input type="password" id="old_password" class="form-control w-100 bg-body-secondary " name="old_password">

              <?php if (isset($errors['old_password'])) : ?>
                <div class="alert alert-danger p-0 m-0 rounded-0 w-100  " role="alert">
                  <i class="fa-solid fa-circle-exclamation me-1"></i><?php echo htmlspecialchars($errors['old_password'] ?? ''); ?>
                </div>
              <?php endif; ?>


            </div>
          </div>
          <div class="mb-3 row">
            <label for="new_password" class="col-sm-12 col-form-label ">New Password</label>
            <div class="col-sm-12">

              <input type="password" id="new_password" class="form-control w-100 bg-body-secondary " name="new_password">


              <?php if (isset($errors['new_password'])) : ?>
                <div class="alert alert-danger p-0 m-0 rounded-0 w-100" role="alert">
                  <i class="fa-solid fa-circle-exclamation me-1"></i><?php echo htmlspecialchars($errors['new_password'] ?? ''); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="confirm_password" class="col-sm-12 col-form-label ">Confirm Password</label>
            <div class="col-sm-12">
              <input type="password" id="confirm_password" class="form-control w-100 bg-body-secondary " name="confirm_password">
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-end">
            <input type="submit" class="btn btn-primary" name="updateUser" value="submit">
          </div>

        </div>
    </div>
    </form>
  </div>
</div>


<?php include('template/footer.php') ?>