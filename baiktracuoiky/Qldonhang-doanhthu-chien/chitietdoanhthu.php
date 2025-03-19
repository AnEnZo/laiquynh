<?php
// Kết nối tới cơ sở dữ liệu MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlyquancafe1";

// Tạo kết nối
$conn = mysqli_connect($servername, $username, $password, $dbname,"3307");

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu từ MySQL
$sql = "SELECT ngay AS ngay, SUM(tongtienngay) AS tongtienngay FROM doanhthu GROUP BY ngay";
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Đóng kết nối
mysqli_close($conn);

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
