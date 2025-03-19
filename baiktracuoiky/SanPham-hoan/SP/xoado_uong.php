<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
if (isset($_GET['ID'])) {
    $masp = $_GET['ID'];

    // Kết nối cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1','3307');
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    // Truy xuất thông tin hình ảnh của sản phẩm
    $sql = "SELECT linkimg FROM tbl_douong WHERE maSP='$masp'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $relativeImagePath = $row['linkimg'];

        // Đường dẫn tuyệt đối đến thư mục chứa hình ảnh
        $absoluteImagePath = "C:/xampp/htdocs/baiktracuoiky/SanPham-hoan/SP/Do_uong/" . basename($relativeImagePath);

        // Xóa hình ảnh khỏi thư mục
        if (file_exists($absoluteImagePath)) {
            unlink($absoluteImagePath);
        }
    }

    // Xóa sản phẩm
    $sql = "DELETE FROM tbl_douong WHERE maSP='$masp'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Sản phẩm đã được xóa thành công'); window.location.href='do_uong.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($conn) . "'); window.location.href='do_uong.php';</script>";
    }

    mysqli_close($conn);
} else {
    echo "<script>alert('Không có ID sản phẩm để xóa'); window.location.href='do_uong.php';</script>";
}
?>
    
</body>
</html>
