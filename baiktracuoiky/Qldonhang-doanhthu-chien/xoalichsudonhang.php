<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa lịch sử đơn hàng</title>
</head>
<body>
    <?php
    $id = $_GET['id'];
    $conn =  mysqli_connect("localhost", "root", "", "quanlyquancafe1","3307");

    if (!$conn) {
        echo 'Kết nối không thành công, lỗi: ' . mysqli_connect_error();
    } else {
        $query = "DELETE FROM tbl_lsdh WHERE madh ='$id'";

        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<script>
                    alert("Hủy đơn hàng thành công");
                    window.location.href="lsdh.php";
                    </script>';
        } else {
            echo "Lỗi xóa đơn hàng: " . mysqli_error($conn);
        }
    }
    ?>
</body>
</html>
