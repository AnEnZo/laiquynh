<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách hàng</title>
    <link rel="stylesheet" href="/baiktracuoiky/Baitaplon-long/quanlykhachhang.css">
</head>
<body>
    <form method="POST">
        <div class="Timkiem">
            <input type="text" name="txtTimkiem" id="txtTimkiem" placeholder="Nhập tên khách hàng...">
            <input type="submit" value="Tìm kiếm" id="btnTimkiem" name="btnTimkiem">
        </div>
    </form>
    <?php
        $conn = mysqli_connect("localhost","root","","quanlyquancafe1","3307");
        if(!$conn){
            echo 'Kết nối không thành công, lỗi'; mysqli_connect_error();
        }
        else{
            $query = "SELECT * FROM quanlykhachhang";
            $result = mysqli_query($conn,$query);
            $num = 1;
            if(mysqli_num_rows($result) >0){
                echo'
                    <table id="tblMain">
                        <thead>
                            <th>STT</th>
                            <th>Mã khách hàng</th>
                            <th>Họ tên</th>
                            <th>Ngày sinh</th>
                            <th>Địa chỉ</th>
                            <th>Giới tính</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Thao tác</th>
                        </thead>
                        <tbody>
                ';
                while($row = mysqli_fetch_assoc($result)){
                    echo'
                        <tr>
                            <td>'.($num++).'</td>
                            <td>'.$row["maKH"].'</td>
                            <td>'.$row["hoTen"].'</td>
                            <td>'.$row["ngaySinh"].'</td>
                            <td>'.$row["diaChi"].'</td>
                            <td>'.($row["gioiTinh"] ? 'Nam' : 'Nữ').'</td>
                            <td>'.$row["Email"].'</td>
                            <td>'.$row["SĐT"].'</td>
                            <td>
                                <a class="btn-delete" onclick="return confirm(\'Bạn có chắc chắn muốn xóa ?\');" href="xoattkh.php?maKH='.$row["maKH"].'">Xóa</a>
                            </td>
                        </tr>
                    ';
                }
                echo'</tbody></table>';
            }
            else{
                echo'Không có dữ liệu!';
            }
        }
    ?>
    <?php
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btnTimkiem']))
        {
            $conn = mysqli_connect("localhost","root","","quanlyquancafe1");
            $KeySearch = $_POST['txtTimkiem'];
            if(!$conn){
                echo 'Kết nối không thành công, lỗi:' . mysqli_connect_error();
            }
            else{
                echo '<script type="text/javascript">
                    var table = document.getElementById("tblMain");
                    table.style.display = "none";
                </script>';
                
                $query = "SELECT * FROM quanlykhachhang WHERE hoTen LIKE N'%".$KeySearch."%'";
                $result = mysqli_query($conn ,$query );
                $num = 1;
                if(mysqli_num_rows($result) > 0){
                    echo '<table>
                                <thead>
                                    <th>STT</th>
                                    <th>Mã khách hàng</th>
                                    <th>Họ tên</th>
                                    <th>Ngày sinh</th>
                                    <th>Địa chỉ</th>
                                    <th>Giới tính</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Thao tác</th>
                                </thead>
                            <tbody>';
                    while($row = mysqli_fetch_assoc($result)){
                        echo'<tr>
                                <td>'.($num++).'</td>
                                <td>'.$row["maKH"].'</td>
                                <td>'.$row["hoTen"].'</td>
                                <td>'.$row["ngaySinh"].'</td>
                                <td>'.$row["diaChi"].'</td>
                                <td>'.($row["gioiTinh"] ? 'Nam' : 'Nữ').'</td>
                                <td>'.$row["Email"].'</td>
                                <td>'.$row["SĐT"].'</td>
                                <td>
                                    <a class="btn-delete" onclick="return confirm(\'Bạn có chắc chắn muốn xóa ?\');" href="xoattkh.php?ID='.$row["maKH"].'">Xóa</a>
                                </td>
                            </tr>';
                    }
                    echo'</tbody></table>';
                }
                else{
                    echo'Không tìm thấy dữ liệu!';
                }
            }
        }
    ?>
    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>
</body>
</html>
