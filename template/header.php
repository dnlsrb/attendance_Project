<!DOCTYPE html>
<html lang="en" >
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
 

<body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="js//bootstrapjs/bootstrap.min.js"></script>
 

    <?php if (isset($_SESSION['username']) && isset($_SESSION['password'])): ?>

        <nav>
            <div class="container-fluid" style="<?php echo $header ?? "background-color: #001658;  ";?>">
                <div class="d-flex justify-content-between flex-row d-flex align-items-center py-5 px-2">
                    <div class="d-flex align-items-center">
                        <div>
                        <a class="navbar-brand" href="#">
                        <img src="storage/logo1.png" alt="GXII" width="30"   >
                        </a>             
                        </div>
                    </div>
                <div> 
            </div>
            
            <div  class=" d-flex  
            <?php  if ( $desired_url  == "attendance_List.php") {
                echo "d-none";
            }  ?>
            ">
            
            <div class="dropdown">
            <button class="btn btn-secondary   dropdown-toggle "  data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-circle-user"></i></button>
            <ul class="dropdown-menu">
            <li  class="d-flex justify-content-center ">
                <a href="#"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
            <li><hr class="dropdown-divider "></li>
            <li class="d-flex justify-content-center">
                <a href="./logout.php" class=" dropdown-item p-2 ">
                    <i class="fa-solid fa-right-from-bracket"></i> Log out
                </a>
            </li>
             </ul>
         </div>
 
            
                    </div>  
                </div>
            </div>
        </nav>
         
       
        <nav id="hidden-class-2" class="bg-secondary px-3    <?php  if ( $desired_url  == "attendance_List.php"): echo 'd-none'; else:  endif; ?>  "> 

            <?php if( $_SESSION['role'] == 1   ): if($desired_url != "attendance_List.php"):?>

            <a href="event_list.php" class="   btn btn-secondary text-dark rounded-0 border-0 border <?php  if($desired_url == "event_list.php" || $desired_url == "event_Details.php" || $desired_url == "view_list.php"): echo 'btn-light'; else: echo 'text-white'; endif;?>   ">Events</a>
            <a href="user_management.php" class="    btn btn-secondary text-dark rounded-0 border-0 border <?php  if($desired_url == "user_management.php"): echo 'btn-light'; else: echo 'text-white'; endif;?> ">User Management</a>
            <a href="archive_list.php" class="   btn btn-secondary text-dark rounded-0 border-0 border  <?php  if($desired_url == "archive_list.php"): echo 'btn-light';  else: echo 'text-white'; endif;?>  ">Archive</a>
                       
            <?php  endif; endif; ?>



                 <?php if ( $desired_url  == "attendance_List.php"): ?>
                       <a href="event_list.php" class="px-1 link-light   link-opacity-75-hover">Back</a>
                <?php   endif;?>
        </nav>
        
 

 
  
        <?php else: endif;?>