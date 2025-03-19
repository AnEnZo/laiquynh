<?php 
session_start();
// Lấy số điện thoại từ session
$loaiquyen = $_SESSION['loaiquyen'];
session_write_close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí đơn hàng - Cafe</title>
    <link rel="stylesheet" href="/baiktracuoiky/Qldonhang-doanhthu-chien/qldh.css">
    <div id="totalOrders">Tổng số đơn hàng: 0</div>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Quản lí đơn hàng - Cafe</h1>
        </div>
        <form method="POST" class="Search">
            <input type="text" name="txtSearch" id="txtSearch" placeholder="Nhập tên khách hàng...">
            <select name="sltStatus" id="sltStatus">
                <option value="">-- Chọn trạng thái --</option>
                <option value="bạn có đơn hàng mới">Bạn có đơn hàng mới</option>
                <option value="xác nhận đơn hàng">Xác nhận đơn hàng</option>
                <option value="đang giao">Đang giao, hãy chú ý điện thoại</option>
                <option value="giao thành công">Giao thành công</option>
                <option value="giao thất bại">Giao thất bại</option>
            </select>
            <input type="submit" value="Tìm kiếm" id="btnSearch" name="btnSearch">
        </form>
        <?php 
        // Kết nối tới cơ sở dữ liệu
        $conn = mysqli_connect("localhost", "root", "", "quanlyquancafe1","3307");

        // Kiểm tra kết nối
        if(!$conn){
            echo '<p style="color: red;">Kết nối không thành công, lỗi: ' . mysqli_connect_error() . '</p>';
        } else {
            // Xác định query ban đầu
            $query = "SELECT * FROM tbldonhang ";
            // Nếu là POST request và có giá trị tìm kiếm, sửa đổi query
            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btnSearch'])){
                $KeySearch = $_POST['txtSearch'];
                $Status = $_POST['sltStatus'];

                $conditions = array();
                if (!empty($KeySearch)) {
                    $conditions[] = "tenkh LIKE N'%".$KeySearch."%'";
                }
                if (!empty($Status)) {
                    $conditions[] = "trangthai = '".$Status."'";
                }

                if (!empty($conditions)) {
                    $query .= " WHERE " . implode(" AND ", $conditions);
                }
            }
            
            $result = mysqli_query($conn, $query);

            // Kiểm tra xem có dữ liệu trả về không
            if(mysqli_num_rows($result) > 0){
                echo '<table>
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Số ĐT</th>
                        <th>Địa chỉ</th>
                        <th>Món</th>
                        <th>Tổng Tiền</th>                                               
                        <th>Thời gian đặt hàng</th> <!-- Thêm cột thời gian đặt hàng -->
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                        <th>Chi tiết</th> <!-- Thêm cột cho nút Chi tiết -->
                    </tr>
                </thead>
                <tbody>';
                // Lặp qua từng hàng dữ liệu và hiển thị
                while($row = mysqli_fetch_assoc($result)){
                    echo '<tr>
                            <td>' . $row["madh"] . '</td>
                            <td>' . $row["tenkh"] . '</td>
                            <td>' . $row["sdt"] . '</td>
                            <td>' . $row["diachi"] . '</td>
                            <td>' . $row["mon"] . '</td> 
                            <td>' . number_format($row["tongtien"]) . ' VNĐ</td>                          
                            <td>' . $row["thoigiandathang"] . '</td> <!-- Hiển thị thời gian đặt hàng -->                       
                            <td>
                                <form method="POST" action="trang_thai.php">
                                    <input type="hidden" name="madh" value="'.$row["madh"].'">
                                    <select name="trangthai" onchange="this.form.submit()">';
                                        
                                        if ($row["trangthai"] == "bạn có đơn hàng mới") {
                                            echo '<option value="bạn có đơn hàng mới" selected>Bạn có đơn hàng mới</option>
                                                  <option value="xác nhận đơn hàng">Xác nhận đơn hàng</option>';
                                        } elseif ($row["trangthai"] == "xác nhận đơn hàng") {
                                            echo '<option value="xác nhận đơn hàng" selected>Xác nhận đơn hàng</option>
                                                  <option value="đang giao">Đang giao, hãy chú ý điện thoại</option>';
                                        } elseif ($row["trangthai"] == "đang giao") {
                                            echo '<option value="đang giao" selected>Đang giao, hãy chú ý điện thoại</option>
                                                  <option value="giao thành công">Giao thành công</option>
                                                  <option value="giao thất bại">Giao thất bại</option>';
                                        } else {
                                            echo '<option value="'.$row["trangthai"].'" selected>'.$row["trangthai"].'</option>';
                                        }

                                    echo '</select>
                                </form>
                            </td>            
                            <td>';
                               
                        if ($loaiquyen == 3) {
                            echo '<a class="btn" href="suadh.php?id='.$row["madh"].'">Sửa</a>
                                  <a class="btn btn-delete" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không?\');" href="xoadh.php?id='.$row["madh"].'">Xóa</a>';
                        } elseif ($loaiquyen == 2) {
                            echo '<a class="btn btn-delete" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không?\');" href="xoadh.php?id='.$row["madh"].'">Xóa</a>';
                        }

                    echo '</td>
                        <td><a class="btn" href="chitiet.php?id='.$row["madh"].'">Chi tiết</a></td> <!-- Thêm nút Chi tiết -->
                        </tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p>Không có dữ liệu</p>';
            }
        }
        ?>
    </div>
    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>
    <div class="footer">
        <p>&copy; 2024 Cafe Management</p>
    </div>
</body>
</html>
