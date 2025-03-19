<?php
// Kết nối tới cơ sở dữ liệu
$conn = mysqli_connect("localhost", "root", "", "quanlyquancafe1", "3307");

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}

// Kiểm tra nếu có yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy ID đơn hàng từ yêu cầu POST
    if (isset($_POST['id'])) {
        $orderId = intval($_POST['id']);
        
        // Chuẩn bị và thực hiện câu truy vấn để xóa đơn hàng
        $query = "DELETE FROM tbldonhang WHERE madh = ?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $orderId);
            if (mysqli_stmt_execute($stmt)) {
                echo "Đơn hàng đã được xóa thành công.";
                echo "<script>
                window.location.href = 'donhangkhach.php';
            </script>";
            } else {
                echo "Có lỗi xảy ra khi xóa đơn hàng: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Không có ID đơn hàng được cung cấp.";
    }
}

// Đóng kết nối
mysqli_close($conn);
?>
