<?php require ('config/Controller/login_controller.php'); ?>

<?php
if (isset($_SESSION['username']) && isset($_SESSION['password'])):
    header('Location: event_List.php');
else:
    ?>
    <!-- AUTH LOGGED IN -->

    <?php
    include ('template/header.php')
        ?>


    <!-- parent container -->
    <div class="d-flex justify-content-center align-items-center position-relative"
        style="height:100vh; background-image: linear-gradient(315deg, #ff0203 0%, #1850f5 50%, #04049a 75%);">

        <?php
        include ('config/database/db_connect.php');
        if (isset($_GET['error'])) {
            $error = mysqli_real_escape_string($conn, $_GET['error']);
            // this is a Alert for incorrect user info
            echo '<div class="alert alert-danger position-absolute top-0 end-0 m-3 " role="alert">';
            echo $error;
            echo ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';

        }
        ?>




        <!-- child container -->
        <form action="index.php" method="POST" class=" bg-light rounded-4 p-5">


            <!-- THIS IS AN INITIAL STAGE OF CSS -->
            <!-- TO DO:
            - Grid layout the design on login forms
            - Check for responsiveness of the elements
            - check for states in the input elements  -->


            <!-- logo and title -->
            <div class="d-flex align-items-center justify-content-center">
                <!-- lipat yung inline css sa external css later -->
                <img src="storage/logo2.png" alt="gx-i logo" style="height: 65px; width: 55px; margin-right:5px">
                <h3 class="text-primary fw-semibold fs-2">Login</h3>
            </div>

            <!-- forms params -->
            <div class="d-flex flex-column align-items-center justify-content-center p-2">
                <input type="text" placeholder="Username" name="username"
                    class="my-2 border-0 border-bottom border-2 border-primary-subtle">
                <input type="password" placeholder="Password" name="password"
                    class="mb-2 border-0 border-bottom border-2 border-primary-subtle">
                <div>
                    <input type="checkbox" id="remember_me" name="remember_me">
                    <label for="remember_me">Remember Me</label>
                </div>
                <input type="submit" value="Login" name="submit" class="btn btn-primary mt-2">
            </div>
        </form>

    </div>



    <?php include ('template/footer.php') ?>
<?php endif; ?>