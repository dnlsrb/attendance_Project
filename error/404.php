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
        window.location.href = '../index.php'; // Redirect to index.php
    }, 2000); // 2000 milliseconds = 2 seconds
});
</script>
<div class="  d-flex flex-column justify-content-center align-items-center  " style="height:100vh;"> 

<div> <p class="display-3">Error<span class="fw-bold">404 (Not Found) </span></p></div><br>
<div><p>Redirecting<span id="animation">....</span></p></div>
<style>
@keyframes upDown {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

#animation {
    animation: upDown 1s infinite;
}
</style>
</div>
</body>
</html>

 