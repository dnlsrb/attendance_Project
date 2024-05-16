<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="../css/bootstrapcss/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="  crossorigin="anonymous"></script>
</head>
<body class="d-flex justify-content-center align-items-center ">

<script>
$(document).ready(function() {
    // Wait for 2 seconds before redirecting
    setTimeout(function() {
        window.location.href = '<?php echo $loc; ?>'; // Redirect to index.php
    }, 3000);  
});
</script>
<div class="  d-flex flex-column justify-content-center align-items-center  " style="height:100vh;"> 

<div> <p class="display-3">Error<span class="fw-bold"><?php echo $error_code ?></span></p></div><br>
<div><p><?php echo $message ?>.</p></div><br>
<div><p>Redirecting<span id="animation">....</span></p></div>
 
</div>
</body>
</html>

 