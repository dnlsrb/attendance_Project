<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- BOOTSTRAP CSS  -->
    <link rel="stylesheet" href="css/bootstrapcss/bootstrap.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/fontawesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/brands.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/regular.css" rel="stylesheet">
</head>
<script>
    window.addEventListener('unload', function () {
        document.documentElement.innerHTML = '';
    });
</script>

<body>
    <!-- BOOTSTRAP JS-->
    <script src="js//bootstrapjs/bootstrap.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script> -->

    <?php if (isset($_SESSION['username']) && isset($_SESSION['password'])): ?>

        <!-- Header Navbar -->
        <nav>
            <!-- container div -->
            <div class="container-fluid" style="background-color: #001658;  ">
                <!-- parent div -->
                <div class="d-flex justify-content-between flex-row d-flex align-items-center p-1">
                    <div class="d-flex align-items-center">
                        <!-- logo -->
                        <div>
                            <img src="storage/logo2.png" class="m-1" alt="gx-i logo" width="26" height="32">
                        </div>
                        <!-- brand name -->


                        <span class="text-light fs-5">Hello!
                            <?php echo htmlspecialchars($_SESSION['username']) ?>
                        </span>


                    </div>
                    <!-- logout button -->

                    <a href="./config/Controller/logout.php" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>

                </div>
            </div>
        </nav>
 

    <?php endif; ?>

 
        <!-- <div>
            <a href="./config/Controller/logout.php">Logout</a>
            <a href="event_List.php">Event List</a>
            <?php if ($_SESSION['role'] = 'admin'): ?> <a href="./user_management.php">User Management</a>
            <?php endif; ?>
        </div>
        <span>Hello!
            <?php echo htmlspecialchars($_SESSION['username']) ?>
        </span> -->
  