<?php
    $dblink = new mysqli('localhost', 'root', '', 'newstrack') or die('There was a problem connecting to the database');  
    if(mysqli_connect_errno()) {
        echo "Connection Failed: " . mysqli_connect_errno();
        exit();
   }
?>