 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- BOOTSTRAP CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- BOOTSTRAP CDN -->
    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--  -->
</head>
<script>
window.addEventListener('unload', function () {
    document.documentElement.innerHTML = '';
});
</script>
<body>
<?php if(isset($_SESSION['username'])  && isset($_SESSION['password'])): ?>
    
<nav>
<div>  
    <a href="./config/Controller/logout.php">Logout</a>
    <a href="./event_List.php">Event List</a>
   <?php if($_SESSION['role'] = 'admin'):?> <a href="./user_management.php">User Management</a> <?php endif;?>
</div>
 <span>Username: <?php echo htmlspecialchars($_SESSION['username'])?> </span>
 
</nav>
 
<?php endif;?>