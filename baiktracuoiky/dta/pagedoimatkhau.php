<?php
// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1', '3307');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form
    $sdt = isset($_POST['sdt']) ? $_POST['sdt'] : '';
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Kiểm tra và xử lý dữ liệu
    if (!empty($sdt) && !empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        // Kiểm tra xem có tồn tại người dùng với số điện thoại đã nhập hay không
        $sql_check_user = "SELECT * FROM tbltaikhoan WHERE SĐT = '$sdt'";
        $result_check_user = $conn->query($sql_check_user);

        if ($result_check_user->num_rows > 0) {
            // Lấy thông tin tài khoản từ cơ sở dữ liệu
            $row = $result_check_user->fetch_assoc();
            $stored_password = $row['matkhau'];

            // Kiểm tra mật khẩu hiện tại
            if ($current_password === $stored_password) {
                if ($new_password === $confirm_password) {
                    // Cập nhật mật khẩu mới vào cơ sở dữ liệu
                    $update_sql = "UPDATE tbltaikhoan SET matkhau = '$new_password' WHERE SĐT = '$sdt'";
                    if ($conn->query($update_sql) === TRUE) {
                        $message = "Mật khẩu đã được đổi thành công.";
                    } else {
                        $message = "Có lỗi xảy ra khi đổi mật khẩu. Vui lòng thử lại.";
                    }
                } else {
                    $message = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
                }
            } else {
                $message = "Mật khẩu hiện tại không chính xác.";
            }
        } else {
            $message = "Không tìm thấy người dùng với số điện thoại này.";
        }
    } else {
        $message = "Vui lòng điền đầy đủ thông tin.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .change-password-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .change-password-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .change-password-container form {
            display: flex;
            flex-direction: column;
        }
        .change-password-container input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .change-password-container button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .change-password-container button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
        .back-to-home {
            margin-top: 20px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .back-to-home:hover {
            background-color: #0056b3;
        }
        .container-footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/ -->
<div class="change-password-container">
        <h1>Đổi Mật Khẩu</h1>
        <form method="post">
            <input type="text" name="sdt" placeholder="Số điện thoại" required>
            <input type="password" name="current_password" placeholder="Mật khẩu hiện tại" required>
            <input type="password" name="new_password" placeholder="Mật khẩu mới" required>
            <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
            <button type="submit">Đổi mật khẩu</button>
        </form>
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="container-footer">
            <a href="trangchu.php" class="back-to-home">Quay lại trang chủ</a>
        </div>
    </div>
</body>
</html>
