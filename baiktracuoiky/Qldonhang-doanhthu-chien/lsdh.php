<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng - Cafe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            max-width: 100%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .Search {
            margin-bottom: 12px;
            text-align: center;
        }
        .Search input[type=text] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .Search input[type=submit] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 8px;
        }
        .Search input[type=submit]:hover {
            background-color: #45a049;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            margin-top: 10px;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-delete:hover {
            background-color: #da190b;
        }
        .btn-exit {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            margin: 20px auto;
            font-size: 14px;
            width: 150px;
        }
        .btn-exit:hover {
            background-color: #1976D2;
        }
        .header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px 8px 0 0;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Lịch sử đơn hàng - Cafe</h1>
        </div>
        <form method="POST" class="Search">
            <input type="text" name="txtSearch" id="txtSearch" placeholder="Nhập tên khách hàng hoặc số điện thoại...">
            <input type="submit" value="Tìm kiếm" id="btnSearch" name="btnSearch">
        </form>
        <?php 
        // Kết nối tới cơ sở dữ liệu
        $conn = mysqli_connect("localhost", "root", "", "quanlyquancafe1", "3307");

        // Kiểm tra kết nối
        if(!$conn){
            echo '<p style="color: red;">Kết nối không thành công, lỗi: ' . mysqli_connect_error() . '</p>';
        } else {
            // Xác định query ban đầu
            $query = "SELECT * FROM tbl_lsdh";
            // Nếu là POST request và có giá trị tìm kiếm, sửa đổi query
            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btnSearch'])){
                $KeySearch = $_POST['txtSearch'];
                $query .= " WHERE tenkh LIKE N'%".$KeySearch."%' OR sdt LIKE '%".$KeySearch."%'";
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
                        <th>Tổng Tiền</th>
                        <th>Món</th>
                        <th>Thời gian đặt hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
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
                            <td>' . $row["thoigiandathang"] . '</td>
                            <td>' . $row["trangthai"] . '</td>
                            <td>
                                <form method="POST" action="trang_thai.php">
                                    <input type="hidden" name="madh" value="'.$row["madh"].'">
                                </form>
                                <a class="btn btn-delete" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không?\');" href="xoalichsudonhang.php?id='.$row["madh"].'">Xóa</a>
                            </td>
                        </tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p>Không có dữ liệu</p>';
            }
        }
        ?>
    </div>
    <div class="footer">
        <a href="/baiktracuoiky/dta/trangchu.php" class="btn-exit">Quay lại</a>
    </div>
</body>
</html>
