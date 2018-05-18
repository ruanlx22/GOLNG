<?php
session_start();
if (isset($_SESSION['user'])){
    $_SESSION['user']=null;
    header("Refresh:3;url=map.php");
    echo "Logging out successfully!";
}
else{
    header("Refresh:0;url=map.php");
}
?>
