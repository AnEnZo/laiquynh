<?php
// Kết nối tới cơ sở dữ liệu
$conn = mysqli_connect("localhost", "root", "", "quanlyquancafe1","3307");

// Kiểm tra kết nối
if(!$conn){
    die('Kết nối không thành công, lỗi: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['madh']) && isset($_POST['trangthai'])) {
    $madh = $_POST['madh'];
    $trangthai = $_POST['trangthai'];

    // Cập nhật trạng thái đơn hàng
    $query = "UPDATE tbldonhang SET trangthai = '$trangthai' WHERE madh = '$madh'";
    if (mysqli_query($conn, $query)) {
        // Nếu trạng thái là 'giao thành công', chèn dữ liệu vào bảng doanhthu
        if ($trangthai == 'giao thành công') {
            // Lấy thông tin của đơn hàng
            $order_query = "SELECT thoigiandathang, tongtien FROM tbldonhang WHERE madh = '$madh'";
            $order_result = mysqli_query($conn, $order_query);
            if ($order_result && mysqli_num_rows($order_result) > 0) {
                $order_data = mysqli_fetch_assoc($order_result);
                $ngay = $order_data['thoigiandathang'];
                $tongtienngay = $order_data['tongtien'];

                // Chèn dữ liệu vào bảng doanhthu
                $insert_query = "INSERT INTO doanhthu (ngay, tongtienngay) VALUES ('$ngay', '$tongtienngay')";
                mysqli_query($conn, $insert_query);
            }
        }
    }
}

mysqli_close($conn);

// Chuyển hướng trở lại trang trước
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>
