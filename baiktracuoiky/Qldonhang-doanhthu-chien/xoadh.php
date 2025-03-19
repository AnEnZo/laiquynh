<?php
// Kết nối tới cơ sở dữ liệu
$conn = mysqli_connect("localhost", "root", "", "quanlyquancafe1","3307");

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}

// Lấy mã đơn hàng từ URL
if (isset($_GET['id'])) {
    $madh = $_GET['id'];

    // Lấy thông tin đơn hàng từ ttdh
    $query = "SELECT * FROM tbldonhang WHERE madh = '$madh'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Lưu thông tin đơn hàng vào tbl_lsdh trước khi xóa
        $row = mysqli_fetch_assoc($result);

        $insert_query = "INSERT INTO tbl_lsdh (madh, tenkh, sdt, diachi, tongtien, mon, thoigiandathang, trangthai) VALUES ('" . $row['madh'] . "', '" . $row['tenkh'] . "', '" . $row['sdt'] . "', '" . $row['diachi'] . "', '" . $row['tongtien'] . "', '" . $row['mon'] . "', '" . $row['thoigiandathang'] . "', '" . $row['trangthai'] . "')";
        mysqli_query($conn, $insert_query);

        // Xóa đơn hàng từ ttdh
        $delete_query = "DELETE FROM tbldonhang WHERE madh = '$madh'";
        mysqli_query($conn, $delete_query);

        // Hiển thị thông báo bằng JavaScript và chuyển hướng
        echo "<script>
            alert('Đơn hàng đã được xóa và lưu vào lịch sử.');
            window.location.href = 'qldh.php';
        </script>";
    } else {
        echo "<script>
            alert('Không tìm thấy đơn hàng.');
            window.location.href = 'qldh.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Mã đơn hàng không hợp lệ.');
        window.location.href = 'qldh.php';
    </script>";
}

// Đóng kết nối
mysqli_close($conn);
?>
