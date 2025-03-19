<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();
session_unset(); // Hủy tất cả các biến session
session_destroy(); // Hủy session
header("Location: trangchu.php"); 
exit();
?>
</body>
</html>