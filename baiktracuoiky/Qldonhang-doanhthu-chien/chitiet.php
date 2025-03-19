<?php
session_start();
$loaiquyen = $_SESSION['loaiquyen'];
session_write_close();

// Kiểm tra nếu không có mã đơn hàng được truyền vào, điều hướng người dùng về trang chủ hoặc thông báo lỗi
if (!isset($_GET['id'])) {
    header("Location: /baiktracuoiky/dta/trangchu.php");
    exit;
}

// Lấy mã đơn hàng từ tham số GET
$madh = $_GET['id'];

// Kết nối tới cơ sở dữ liệu
$conn = mysqli_connect("localhost", "root", "", "quanlyquancafe1", "3307");

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}

// Truy vấn chi tiết đơn hàng
$query = "SELECT * FROM tbldonhang WHERE madh = '$madh'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng - Cafe</title>
    <link rel="stylesheet" href="/baiktracuoiky/Qldonhang-doanhthu-chien/qldh.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Chi tiết đơn hàng</h1>
        </div>
        <div class="details">
            <p><strong>Mã đơn hàng:</strong> <?php echo $row['madh']; ?></p>
            <p><strong>Tên khách hàng:</strong> <?php echo $row['tenkh']; ?></p>
            <p><strong>Số ĐT:</strong> <?php echo $row['sdt']; ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo $row['diachi']; ?></p>
            <p><strong>Thời gian đặt hàng:</strong> <?php echo $row['thoigiandathang']; ?></p>
            <p><strong>Trạng thái:</strong> <?php echo $row['trangthai']; ?></p>
            <h3>Danh sách sản phẩm:</h3>
            <?php
            // Truy vấn chi tiết sản phẩm của đơn hàng
            $query_sp = "SELECT * FROM tbldonhang WHERE madh = '$madh'";
            $result_sp = mysqli_query($conn, $query_sp);

            if (mysqli_num_rows($result_sp) > 0) {
                echo '<ul>';
                while ($row_sp = mysqli_fetch_assoc($result_sp)) {
                    echo '<li>'.$row_sp['mon'].' - Số lượng: '.$row_sp['soluong'].'</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Không có sản phẩm nào trong đơn hàng này.</p>';
            }
            ?>
        </div>
    </div>
    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>
    <div class="footer">
        <p>&copy; 2024 Cafe Management</p>
    </div>
</body>
</html>
<?php
} else {
    echo '<p>Không tìm thấy thông tin đơn hàng.</p>';
}

// Đóng kết nối
mysqli_close($conn);
?>
