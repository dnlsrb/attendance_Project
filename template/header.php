<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- BOOTSTRAP CSS  -->
    <link rel="stylesheet" href="css/bootstrapcss/bootstrap.min.css">
 
    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/fontawesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/brands.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/regular.css" rel="stylesheet">
</head>
<!-- <script>
    window.addEventListener('unload', function () {
        document.documentElement.innerHTML = '';
    });
</script> -->

<body>
    <script src="js//bootstrapjs/bootstrap.min.js"></script>
 

    <?php if (isset($_SESSION['username']) && isset($_SESSION['password'])): ?>

        <nav >
            <div class="container-fluid" style="background-color: #001658;  ">
                <div class="d-flex justify-content-between flex-row d-flex align-items-center p-3">
                    <div class="d-flex align-items-center">
                        <div>
                        <a class="navbar-brand" href="#">
                        <img src="storage/logo2.png" alt="Bootstrap" width="30"   >
                        </a>             
                        </div>
                    </div>
                <div> 
            </div>
            
            <div>
            <span class="text-light fs-8 m-2">Logged in:
                <?php echo htmlspecialchars($_SESSION['username']) ?>
            </span> 
                    <a href="./config/Controller/logout.php" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                    </div>  
                </div>
            </div>
        </nav>

        <nav class="bg-secondary px-3">
        <?php if ($_SESSION['role'] = 'admin'): ?>
            <a href="event_List.php" class="px-1 link-light   link-opacity-75-hover ">Events</a>
                        <a href="user_management.php" class="px-1 link-light   link-opacity-75-hover "> User Management</a>
                       <a href="user_management.php" class="px-1 link-light   link-opacity-75-hover">Archived</a>
                       <?php endif; ?>
        </nav>

    <?php endif; ?>

 
  
  