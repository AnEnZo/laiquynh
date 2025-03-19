<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            background: #fff;
            padding: 40px; /* Tăng khoảng padding để form to hơn */
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px; /* Tăng độ dày của input */
            margin-bottom: 20px; /* Tăng khoảng cách giữa các input */
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px; /* Tăng kích cỡ chữ */
        }

        button {
            padding: 12px 20px; /* Tăng độ dày của button */
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px; /* Tăng kích cỡ chữ */
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .return {
            margin-top: 20px; /* Tăng khoảng cách giữa form và nút "Quay lại" */
            text-align: left;
            padding-left: 20px;
        }

        .return a {
            text-decoration: none;
            color: #007bff;
        }

        .return a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
 <div>
    <div class="container">    
        <h1>Đăng nhập</h1>
        <form id="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required>
            <br>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Đăng nhập</button>
        </form>      
        <?php
        session_start();

        // Xử lý khi form được submit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kết nối đến cơ sở dữ liệu MySQL
            $servername = "localhost";
            $username = "root"; // Thay bằng tên người dùng cơ sở dữ liệu của bạn
            $password = ""; // Thay bằng mật khẩu cơ sở dữ liệu của bạn
            $dbname = "quanlyquancafe1"; // Thay bằng tên cơ sở dữ liệu của bạn
            $port = "3307"; // Nếu cần, thay đổi cổng kết nối

            // Tạo kết nối đến cơ sở dữ liệu
            $conn = new mysqli($servername, $username, $password, $dbname, $port);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
            }

            // Lấy dữ liệu từ form đăng nhập
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            // Kiểm tra thông tin đăng nhập trong cơ sở dữ liệu
            $check_query = "SELECT * FROM tbltaikhoan WHERE SĐT = ? AND matkhau = ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param("ss", $phone, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                // Đăng nhập thành công
                $row = $result->fetch_assoc();
                $_SESSION['phone'] = $phone;
                $_SESSION['loaiquyen'] = $row['loaiquyen'];
                header("Location: trangchu.php"); // Chuyển hướng đến trang chủ
                exit();
            } else {
                // Đăng nhập không thành công
                echo '<div class="error">Số điện thoại hoặc mật khẩu không chính xác.</div>';
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
    <div class="return"><a href="trangchu.php">Quay lại</a></div>
 </div>
</body>
</html>
