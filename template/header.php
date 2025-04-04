 <!DOCTYPE html>
 <html lang="en">
 <?php
    $url = $_SERVER['REQUEST_URI'];
    $base = basename(parse_url($url, PHP_URL_PATH));
    $desired_url = strtolower($base);

    ?>

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?php echo $title ?? 'Attendance System'; ?></title>
     <link href="css/style.css" rel="stylesheet">
     <!-- BOOTSTRAP CSS  -->
     <link rel="stylesheet" href="css/bootstrapcss/bootstrap.min.css">



     <!-- FONTAWESOME -->
     <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/fontawesome.css" rel="stylesheet">
     <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/brands.css" rel="stylesheet">
     <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/solid.css" rel="stylesheet">
     <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/regular.css" rel="stylesheet">
 </head>

 <?php if ($desired_url != 'index') : include('time.php'); else : endif; ?>

 <body>
     <script src="js/popper.min.js"></script>
     <script src="js/bootstrapjs/bootstrap.min.js"></script>



     <?php if (isset($_SESSION['username']) && isset($_SESSION['password'])) : ?>

         <nav>
             <div class="container-fluid " style="<?php echo $header ?? "background-color: #001658;  "; ?>">

                 <div class="d-flex align-items-center <?php if ($desired_url != "attendance_list") : echo "justify-content-end";else : echo "justify-content-end";
                                                        endif; ?>  py-3 px-1  ">

                     <a class="navbar-brand p-0 m-0" href="event_list    ">
                         <img src="storage/logo1.png" alt="GXII" width="30">
                     </a>



                     <div>
                         <button type="button" id="button" class="btn z-3   <?php if ($desired_url != "attendance_list  ") : echo "d-md-none";
                                                                            else : echo "d-none";
                                                                            endif; ?> d-block text-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#Menu" aria-controls="Menu">
                             <i id="icon" class="fa-solid fa-bars"></i>
                         </button>




                         <div class="offcanvas offcanvas-start  <?php if ($desired_url != "attendance_list") : echo " ";
                                                                else : echo "d-none";
                                                                endif; ?> " data-bs-scroll="true" style="width: 4.5rem; " id="Menu" aria-labelledby="MenuLabel">
                             <div class="offcanvas-header d-block ">
                                 <img src="storage/logo1.png" alt="GXII" width="30">
                             </div>
                             <div class="offcanvas-body p-0 m-0  ">

                                 <ul class="nav nav-pills nav-flush flex-column mb-auto text-center   ">

                                     <li class="nav-item">
                                         <a href="event_list" class="nav-link rounded-0   py-3 border-bottom
                            <?php if ($desired_url == "event_list") : echo 'active text-light';
                            else : echo 'text-primary';
                            endif; ?>   ">
                                             <i class="fa-regular fa-calendar-days "></i>
                                         </a>
                                     </li>
                                     <?php if ($_SESSION['role'] == 1) : ?>
                                         <li>
                                             <a href="user_management" class="nav-link rounded-0 py-3 border-bottom
                        <?php if ($desired_url == "user_management") : echo 'active text-light';
                                            else : echo 'text-primary';
                                            endif; ?> ">
                                                 <i class="fa-solid fa-users"></i>
                                             </a>
                                         </li>
                                         <li>
                                             <a href="archive_list" class="nav-link rounded-0 py-3 border-bottom
                            <?php if ($desired_url == "archive_list") : echo 'active text-light';
                                            else : echo 'text-primary';
                                            endif; ?>  ">
                                                 <i class="fa-solid fa-file-zipper"></i>
                                             </a>
                                         </li>
                                     <?php endif; ?>
                                     <li>
                                         <a href="account" class="nav-link rounded-0 py-3 border-bottom
                            <?php if ($desired_url == "account") : echo 'active text-light';
                            else : echo 'text-primary';
                            endif; ?>  ">
                                             <i class="fa-solid fa-circle-user  "></i>
                                         </a>
                                     </li>
                                     <li>
                                         <a href="./logout  " class="nav-link rounded-0 py-3 border-bottom text-danger">
                                             <i class="fa-solid fa-right-from-bracket"></i>
                                         </a>
                                     </li>
                                 </ul>



                             </div>
                         </div>


                     </div>
         </nav>
         <script>
             document.addEventListener('DOMContentLoaded', function() {
                 const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                 tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                     new bootstrap.Tooltip(tooltipTriggerEl);
                 });
             });
         </script>
         <?php if ($desired_url != "attendance_list") : ?>
             <nav class=" <?php if ($desired_url != "attendance_list") : echo " d-md-block d-none";
                            else : echo "d-none";
                            endif; ?>   border-bottom bg-white ">
                 <ul class="nav nav-pills nav-flush list-group list-group-horizontal border-0   text-center  ">

                     <li class="nav-item">
                         <a href="event_list " class="nav-link rounded-0   
                            <?php if ($desired_url == "event_list") : echo 'active text-light';
                            else : echo 'text-primary';
                            endif; ?>" active>
                             <i class="fa-regular fa-calendar-days "></i>
                         </a>
                     </li>
                     <?php if ($_SESSION['role'] == 1) : ?>
                         <li>
                             <a href="user_management    " class="nav-link rounded-0 
                        <?php if ($desired_url == "user_management") : echo 'active text-light';
                            else : echo 'text-primary';
                            endif; ?> ">
                                 <i class="fa-solid fa-users"></i>
                             </a>
                         </li>
                         <li>
                             <a href="archive_list   " class="nav-link rounded-0 
                            <?php if ($desired_url == "archive_list") : echo 'active text-light';
                            else : echo 'text-primary';
                            endif; ?>  ">
                                 <i class="fa-solid fa-file-zipper"></i>
                             </a>
                         </li>
                     <?php endif; ?>
                     <li>
                         <a href="account" class="nav-link rounded-0 
                            <?php if ($desired_url == "account") : echo 'active text-light';
                            else : echo 'text-primary';
                            endif; ?>  ">
                             <i class="fa-solid fa-circle-user  "></i>
                         </a>
                     </li>

                     <li>
                         <a href="./logout" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Log out" class="nav-link rounded-0  text-danger">

                             <i class="fa-solid fa-right-from-bracket"></i>
                         </a>
                     </li>
                 </ul>
             </nav>
         <?php endif; ?>


     <?php endif; ?>