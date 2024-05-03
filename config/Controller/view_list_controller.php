<?php

class ViewController{

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function validator($event_id){
    
        if(isset($event_id) && preg_match('/^\d+$/', $event_id)){
           
            $validated = "SELECT archived FROM event_list WHERE event_id = $event_id" ;
            $result = mysqli_query($this->conn, $validated);
            
            if(mysqli_num_rows($result) === 0){
                 
                mysqli_free_result($result);
                header('Location: error/404.php');
            }
        
            $archived = mysqli_fetch_assoc($result);
            $validating = $archived['archived'];
        
            if($validating == 1){
               
                mysqli_free_result($result);
                header('Location: error/404.php');
            }
            else{
               
                mysqli_free_result($result);
            }
    
        }else{
       
            header('Location: error/404.php');
        }
        }


        public function closeConnection() {
            mysqli_close($this->conn);
        }
}

$ViewManagement = new ViewController($conn);
$ViewManagement->validator($_GET['id']);
$ViewManagement->closeConnection();
?>
