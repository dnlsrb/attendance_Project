<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- BOOTSTRAP CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <!-- BOOTSTRAP JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

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

        <!-- nav for tabs -->

        <ul class="nav nav-pills align-items-center">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="event_list.php">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user_management.php">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="archive_list.php">Link</a>
            </li>
        </ul>

        <!-- test navbar -->
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
                <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" disabled>Disabled</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0" href="user_management.php">
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <div href="event_list.php"></div>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">...
            </div>
            <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...
            </div>
        </div>


    <?php endif; ?>

    <!-- Dan's Navbar -->
    <!-- 
        <div>
            <a href="./config/Controller/logout.php">Logout</a>
            <a href="event_List.php">Event List</a>
            <?php if ($_SESSION['role'] = 'admin'): ?> <a href="./user_management.php">User Management</a>
            <?php endif; ?>
        </div>
        <span>Hello!
            <?php echo htmlspecialchars($_SESSION['username']) ?>
        </span>
     -->

    <!-- 1st Navbar -->