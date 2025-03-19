<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
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
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .return{
            margin-top: 10px;
            text-align: left; 
        }
        .return a {
            text-decoration: none;
            color: #007bff;
        }

        .return a:hover {
            text-decoration: underline;
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
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div>
        <div class="container">
        <h1>Đăng ký tài khoản</h1>
        <div id="message" class="error" style="display: none;"></div>
        <form id="signup-form" method="POST" action="">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required>
            <br>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="confirm_password">Nhập lại mật khẩu:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <input type="hidden" name="loaiquyen" value="1">
            <button type="submit">Đăng ký</button>
        </form>
        </div>
             <div class="return"><a href="trangchu.php">Quay lại</a></div>
     </div>
   <script>
        document.getElementById("signup-form").onsubmit = function() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (password !== confirm_password) {
                var messageElement = document.getElementById("message");
                messageElement.innerHTML = '<div class="error">Mật khẩu và nhập lại mật khẩu không khớp.</div>';
                messageElement.style.display = "block";
                return false; // Ngăn form submit nếu mật khẩu không khớp
            }
        };
    </script>

    <?php
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

    // Xử lý khi form được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $loaiquyen = $_POST['loaiquyen'];

        // Kiểm tra số điện thoại có đúng 10 số và là số
        if (strlen($phone) == 10 && is_numeric($phone)) {
            // Kiểm tra mật khẩu và mật khẩu nhập lại có khớp nhau không
            if ($password !== $confirm_password) {
                echo '<div class="error">Mật khẩu và nhập lại mật khẩu không khớp.</div>';
            } else {
                // Kiểm tra số điện thoại đã tồn tại trong cơ sở dữ liệu hay chưa
                $check_query = "SELECT * FROM tbltaikhoan WHERE SĐT = ?";
                $stmt = $conn->prepare($check_query);
                $stmt->bind_param("s", $phone);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<script>
                    alert('Số điện thoại đã tồn tại trong cơ sở dữ liệu.');
                    </script>";                 
                } else {
                    // Thêm dữ liệu vào cơ sở dữ liệu
                    $insert_query = "INSERT INTO tbltaikhoan (SĐT, matkhau, loaiquyen) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($insert_query);
                    $stmt->bind_param("sss", $phone, $password, $loaiquyen);

                    if ($stmt->execute()) {
                        echo "<script>
                        alert('Thông tin sinh viên đã được thêm.');
                                 </script>";;
                    } else {
                        echo '<div class="error">Đã xảy ra lỗi khi đăng ký.</div>';
                    }
                }

                $stmt->close();
            }
        } else {
            echo "<script>
            alert('Số điện thoại không hợp lệ. Vui lòng nhập đúng 10 số.');
          </script>";           
        }
    }

    // Đóng kết nối đến cơ sở dữ liệu
    $conn->close();
    ?>

</body>
</html>
