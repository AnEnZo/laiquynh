<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Xử lý khi form đặt hàng được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy các giá trị từ form
    $madh = $_POST['madh'];
    $customerName = $_POST['customer-name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $monAnJson = $_POST['mon']; // Chuỗi JSON chứa danh sách món ăn
    $tongtien = $_POST['tongtien'];
    $trangthai = $_POST['trangthai'];
    $thoigiandathang = $_POST['thoigiandathang'];

    // Kết nối đến cơ sở dữ liệu (thay đổi thông tin kết nối theo cấu hình của bạn)
    $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1','3307');

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng đơn hàng
    $sql = "INSERT INTO tbldonhang (madh, tenkh, sdt, diachi, mon, tongtien, trangthai, thoigiandathang)
            VALUES ('$madh', '$customerName', '$phone', '$address', '$monAnJson', '$tongtien', '$trangthai', '$thoigiandathang')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Đơn hàng của bạn đã được đặt thành công!');
            localStorage.removeItem('cart'); // Xóa giỏ hàng
            window.location.href = 'trangchu.php';</script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
} else {
    echo "Yêu cầu không hợp lệ!";
}
?>

</body>
</html>