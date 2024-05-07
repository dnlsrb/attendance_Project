<?php if(isset($_SESSION['username'])):?>
<?php else:
    header("Location: ../../index.php");
    exit(); // Stop further execution
endif;?>