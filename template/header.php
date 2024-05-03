<!DOCTYPE html>
<html lang="en">
<?php

        $url = $_SERVER['REQUEST_URI'];

        // Now you can use $url in your condition
        
        $desired_url = basename(parse_url($url, PHP_URL_PATH));

        ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Attendance System';?></title>
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
 

<body class=" bg-light">
    <script src="js//bootstrapjs/bootstrap.min.js"></script>
 

    <?php if (isset($_SESSION['username']) && isset($_SESSION['password'])): ?>

        <nav  >
            <div class="container-fluid" style="<?php echo $header ?? "background-color: #001658;  ";?>">
                <div class="d-flex justify-content-between flex-row d-flex align-items-center p-5">
                    <div class="d-flex align-items-center">
                        <div>
                        <a class="navbar-brand" href="#">
                        <img src="storage/logo2.png" alt="GXII" width="30"   >
                        </a>             
                        </div>
                    </div>
                <div> 
            </div>
            
            <div  class="
            <?php  if ( $desired_url  == "attendance_List.php") {
                echo "d-none";
            }  ?>
            ">
            <span class="text-light fs-8 m-2">Logged in:
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </span> 
                    <a href="./config/Controller/logout.php" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                    </div>  
                </div>
            </div>
        </nav>
         
       
        <nav id="hidden-class-2" class="bg-secondary px-3  <?php  if ( $desired_url  == "attendance_List.php"): echo 'd-none'; else:  endif; ?>  "> 
        
            <?php if(isset($_SESSION['role']) == '1' && $desired_url != "attendance_List.php"): ?>
            <a href="event_List.php" class="px-1 link-light   link-opacity-75-hover ">Events</a>
                        <a href="user_management.php" class="px-1 link-light   link-opacity-75-hover "> User Management</a>
                       <a href="archive_list.php" class="px-1 link-light   link-opacity-75-hover">Archived</a>
                 <?php else: endif; ?>



                 <?php if ( $desired_url  == "attendance_List.php"): ?>
                       <a href="event_list.php" class="px-1 link-light   link-opacity-75-hover">Back</a>
                <?php else: endif;?>
        </nav>
        
 

 
  
        <?php else: endif;?>