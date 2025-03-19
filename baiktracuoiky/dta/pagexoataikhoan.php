<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa tài khoản</title>
</head>
<body>

<?php
if (isset($_GET['sdt'])) {
    $sdt = $_GET['sdt'];

    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1','3307');
    if (!$conn) {
        die('Kết nối không thành công: ' . mysqli_connect_error());
    } else {
        // Chuẩn bị câu lệnh SQL DELETE
        $query = "DELETE FROM tbltaikhoan WHERE SĐT = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $sdt);
        
        // Thực thi câu lệnh DELETE
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('Tài khoản đã được xóa.');
                    window.location.href = 'pagequanlytaikhoan.php';
                  </script>";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }

        // Đóng kết nối và giải phóng tài nguyên
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
} else {
    echo "Không có Số điện thoại để xóa.";
}
?>

<a href="pagequanlytaikhoan.php">Quay lại</a>
</body>
</html>
