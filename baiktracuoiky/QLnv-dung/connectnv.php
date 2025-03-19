<?php
     $host ="localhost";
     $username = "root";
     $password = "";
     $dbname = "quanlyquancafe1";
     $conn =new mysqli($host, $username, $password, $dbname,"3307");
 
     if($conn->connect_error){
        echo "LOI".$conn->connect_error;
        exit();
     }
    ?>