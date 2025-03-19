<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sản phẩm</title>
    <link rel="stylesheet" href="../css/do_an.css">
    <style>
        footer {
            text-align: center;
            background-color: #f5f5f5;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        footer p {
            margin-bottom: 10 px;
            color: #07e241;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        form {
            margin-top: 20px;
            text-align: left;
            /* Để căn trái */
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            margin-left: 20px;
            /* Cách lề trái 20px */
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 20px;

        }

        a {
            text-decoration: none;
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
    <ul class="logo">
        <li><a href="/baiktracuoiky/dta/trangchu.php">Trang Chủ</a></li>
        <li>Quản lý thông tin sản phẩm</li>
        <li>Đồ ăn</li>
    </ul>
    <div class="menu">
        <div class="menu-column menu-food">
            <ul>
                <li><a href="do_an.php">Đồ ăn</a></li>
            </ul>
        </div>
        <div class="menu-column menu-drinks">
            <ul>
                <li><a href="do_uong.php">Đồ uống</a></li>
            </ul>
        </div>
    </div>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Nhập tên đồ ăn">
        <button type="submit">Tìm kiếm</button>
    </form>
    <div class="content">
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1','3307');
        if (!$conn) {
            die("Kết nối thất bại: " . mysqli_connect_error());
        }

        $searchTerm = isset($_GET['search']) ? $_GET['search'] : ''; // Kiểm tra xem 'search' có được đặt không
        $sql = "SELECT * FROM tbl_doan";
        if (!empty($searchTerm)) {
            $sql .= " WHERE tensp LIKE '%$searchTerm%'";
        }

        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo '<table>
                   <thead>
                       <tr>
                           <th>Mã sản phẩm</th>
                           <th>Tên sản phẩm</th>
                           <th>Nhà cung cấp</th>
                           <th>Hình ảnh</th>
                           <th>Giá bán</th>
                           <th>Thao tác</th>
                       </tr>
                   </thead>
                   <tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                           <td>' . $row["masp"] . '</td>
                           <td>' . $row["tensp"] . '</td>
                           <td>' . $row["ncc"] . '</td>
                           <td><img class="product-img" src="' . $row["linkimg"] . '" alt="Hình ảnh sản phẩm"></td>
                           <td>' . $row["giaban"] . '</td>
                           
                           <td class="actions">
                               <a href="suado_an.php?ID=' . $row["masp"] . '">Sửa</a> |
                               <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\');" href="xoado_an.php?ID=' . $row["masp"] . '">Xóa</a>
                           </td>
                       </tr>';
                }
                echo '</tbody></table>';
            } else {
                echo "<p>Không có thông tin sản phẩm.</p>";
            }
        } else {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
        }

        mysqli_close($conn);
        ?>
    </div>
    <div class="button">
        <a href="themdo_an.php">Thêm</a>
    </div>
    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>
    <footer>
        <p>&copy; 2024 Quản lý quán cafe. All rights reserved.</p>
    </footer>

</body>

</html>
