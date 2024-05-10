<?php require ('config/Controller/login_controller.php'); ?>

<?php
if (isset($_SESSION['username']) && isset($_SESSION['password'])):
    header('Location: event_List.php');
else:
    ?>
    

    <?php
    $title = "Login";
    include ('template/header.php')
        ?>


  
    <div class="d-flex justify-content-center align-items-center position-relative"
        style="height:100vh; background-image: repeating-linear-gradient(135deg, rgba(0,0,0,0.04) 0px, rgba(0,0,0,0.04) 2px,transparent 2px, transparent 4px),linear-gradient(135deg, rgb(165, 230, 235),rgb(29, 32, 232)); ">
 
         
        <?php
        include ('config/database/db_connect.php');
        if (isset($_GET['error'])) {
            $error = mysqli_real_escape_string($conn, $_GET['error']);
 
            echo '<div class="alert alert-danger position-absolute top-0 end-0 m-3 " role="alert">';
            echo $error;
            echo ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';

        }
        ?>




 
        <form action="index.php" method="POST" class="bg-light p-5">
    
            <div class="d-flex align-items-center justify-content-center">
                <img src="storage/logo1.png" alt="gx-i logo"   style=" width: 55px;  ">
            </div>
 
            <div class="d-flex flex-column align-items-start justify-content-center p-2">
                <input type="text" placeholder="Username" name="username" 
                    class="my-2 form-control border-0 border-bottom rounded-0 border-2 border-primary-subtle">
                <input type="password" placeholder="Password"  name="password"
                    class="mb-2 form-control border-0 border-bottom rounded-0 border-2 border-primary-subtle">
                <div >
                    <input type="checkbox" id="remember_me" name="remember_me" checked>
                    <label for="remember_me">Remember Me</label>
                </div>
               
               
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Login" name="submit" class="btn btn-primary mt-2">
            </div>
        </form>

    </div>

</body>
</html>
<?php endif; ?>