<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
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
        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-form input[type=text] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 70%;
            max-width: 300px;
        }
        .search-form input[type=submit] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .search-form input[type=submit]:hover {
            background-color: #45a049;
        }
        .actions a {
            text-decoration: none;
            padding: 8px 12px;
            margin: 0 5px;
            border-radius: 4px;
            color: white;
        }
        .actions .edit {
            background-color: #4CAF50;
        }
        .actions .edit:hover {
            background-color: #45a049;
        }
        .actions .delete {
            background-color: #f44336;
        }
        .actions .delete:hover {
            background-color: #da190b;
        }
        .actions a:hover {
            opacity: 0.8;
        }
        .add-account, .back {
            display: inline-block;
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .add-account:hover, .back:hover {
            background-color: #1976D2;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            width: 100%;
            position: absolute;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản lý tài khoản</h1>

        <?php
        $search = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $search = isset($_POST['search']) ? $_POST['search'] : '';
        }
        ?>

        <form method="POST" action="" class="search-form">
            <input type="text" name="search" placeholder="Tìm kiếm theo SDT" value="<?php echo htmlspecialchars($search); ?>">
            <input type="submit" value="Tìm kiếm">
        </form>

        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1','3307');
        if (!$conn) {
            die('Kết nối không thành công: ' . mysqli_connect_error());
        }

        $query = "SELECT * FROM tbltaikhoan WHERE SĐT LIKE '%$search%'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>
            <thead>
            <tr>
                <th>SĐT</th>
                <th>Mật khẩu</th>
                <th>Loại quyền</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $row["SĐT"] . "</td>
                    <td>" . $row["matkhau"] . "</td>
                    <td>" . $row["loaiquyen"] . "</td>
                    <td class='actions'>
                        <a href='pagesuataikhoan.php?sdt=" . $row["SĐT"] . "' class='edit'>Sửa</a>
                        <a href='pagexoataikhoan.php?sdt=" . $row["SĐT"] . "' class='delete' onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\">Xóa</a>
                    </td>
                </tr>";
            }
            echo "</tbody>
            </table>";
        } else {
            echo "<p>Không có kết quả nào được tìm thấy.</p>";
        }

        mysqli_close($conn);
        ?>

        <a href="pagethemtaikhoan.php" class="add-account">Thêm Tài Khoản Mới</a>
        <a href="trangchu.php" class="back">Quay lại</a>
    </div>
    <div class="footer">© 2024 Quản lý tài khoản Cafe</div>
</body>
</html>
