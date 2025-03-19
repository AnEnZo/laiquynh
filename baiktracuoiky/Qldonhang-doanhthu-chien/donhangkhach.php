<?php 
session_start();
// Lấy số điện thoại từ session
$customer_phone = $_SESSION['phone'];
session_write_close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi - Cafe</title>
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
            margin-top: 20px;
            border-radius: 0 0 8px 8px;
        }
        .search {
            margin-bottom: 12px;
            text-align: center; /* căn giữa nút tìm kiếm */
        }
        .search input[type=text] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 8px; /* Khoảng cách giữa input và button */
            width: 200px;
        }
        .search input[type=submit] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search input[type=submit]:hover {
            background-color: #45a049;
        }
        .cancel-btn, .edit-btn {
            padding: 6px 12px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .cancel-btn {
            background-color: #f44336;
        }
        .cancel-btn:hover {
            background-color: #d32f2f;
        }
        .edit-btn {
            background-color: #2196F3;
        }
        .edit-btn:hover {
            background-color: #1976D2;
        }
        .btn-quaylai {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: green;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-quaylai:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
<div class="container">
        <div class="header">
            <h1>Đơn hàng của tôi - Cafe</h1>
        </div>
        <form method="POST" class="search">
            <input type="text" name="txtSearch" id="txtSearch" placeholder="Nhập tên khách hàng...">
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
            $query = "SELECT * FROM tbldonhang WHERE sdt = ?";
            
            if($stmt = mysqli_prepare($conn, $query)){
                mysqli_stmt_bind_param($stmt, "s", $customer_phone);
                if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btnSearch'])){
                    $KeySearch = $_POST['txtSearch'];
                    $query .= " AND tenkh LIKE ?";
                    $stmt = mysqli_prepare($conn, $query);
                    $searchParam = "%".$KeySearch."%";
                    mysqli_stmt_bind_param($stmt, "ss", $customer_phone, $searchParam);
                }
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

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
                            <th>Hành động</th> <!-- Thêm cột hành động -->
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
                                <td>' . $row["trangthai"] . '</td>';

                        if ($row["trangthai"] == "bạn có đơn hàng mới") {
                            echo '<td>
                                    <form method="POST" action="xoadhk.php" style="display: none;" id="formDelete_' . $row["madh"] . '">
                                        <input type="hidden" name="id" value="' . $row["madh"] . '">
                                    </form>
                                    <button class="cancel-btn" onclick="submitForm(\'' . $row["madh"] . '\')">Xóa</button>
                                  </td>';
                        } else {
                            echo '<td></td>'; // Nếu không phải trạng thái "new_order", để cột trống
                        }

                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p>Không có đơn hàng nào.</p>';
                }
                mysqli_stmt_close($stmt);
            }
        }
       echo '<a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>';
        ?>
    </div>
    
    <div class="footer">
        <p>&copy; 2024 Cafe Management</p>
        hotline:0564860804
    </div>

    <script>
    function submitForm(orderId) {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
            // Tìm form với id tương ứng
            var form = document.getElementById('formDelete_' + orderId);
            // Submit form
            form.submit();
            
        }
    }
    </script>
    
</body>
</html>
