<?php
 if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
   
    
  
} else {
    header("Location: error/404.php");
    exit(); // Stop further execution
}
?> 