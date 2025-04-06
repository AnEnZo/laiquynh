<?php
$host = "localhost"; // Địa chỉ máy chủ
$username = "root";
$password = "";
$database = "qldsv";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($host, $username, $password, $database,"3307");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Thiết lập charset để hỗ trợ tiếng Việt
$conn->set_charset("utf8");
?>
