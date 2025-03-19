
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sản phẩm</title>
    <style>
        .logo {
            margin-top: 10px;
            font-size: 30px;
            color: green;
            list-style: none;
            display: flex;
            gap: 10px;
        }
        .menu {
            display: flex;
            margin-top: 30px;
            margin-left: 20px;
            gap: 20px;
        }
        .menu-column {
            flex: 1;
            font-size: 20px;
            list-style: none;
            padding: 0;
        }
        .menu-column ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .menu-column li {
            padding: 10px;
            width: 100%;
            margin: 0;
            text-align: center;
        }
        .menu-food {
            background-color: lightblue;
        }
        .menu-drinks {
            background-color: lightcoral;
        }
        .menu-column a {
            text-decoration: none; 
            color: inherit;
        }
        .content {
            margin-top: 20px;
            margin-left: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table th, table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #FF6984;
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
        <li>Trang chủ</li>
        <li>Quản lý thông tin sản phẩm</li>
    </ul>
    <div class="menu">
        <div class="menu-column menu-food">
            <ul>
                <li><a href="do_an.php">Đồ ăn</a></li> <!-- Gán link cho Đồ ăn -->
            </ul>
        </div>
        <div class="menu-column menu-drinks">
            <ul>
                <li><a href="do_uong.php">Đồ uống</a></li> <!-- Gán link cho Đồ uống -->
            </ul>
        </div>
    </div>
    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>
</body>
</html>