<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tài Khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        a {
            text-decoration: none;
            color: #1e90ff;
            font-size: 14px;
            display: block;
            margin-top: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1', '3307');
    if (!$conn) {
        die('Kết nối không thành công: ' . mysqli_connect_error());
    }
    $message = "";
    $loaiquyen = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sdt']) && isset($_POST['matkhau']) && isset($_POST['loaiquyen'])) {
        $sdt = $_POST["sdt"];
        $matkhau = $_POST["matkhau"];
        $loaiquyen = $_POST["loaiquyen"];

        // Kiểm tra xem số điện thoại đã tồn tại chưa
        $check_query = "SELECT * FROM tbltaikhoan WHERE SĐT = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $sdt);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = "Số điện thoại đã tồn tại. Vui lòng nhập số điện thoại khác.";
        } else {
            // Chèn dữ liệu vào bảng
            $insert_query = "INSERT INTO tbltaikhoan (SĐT, matkhau, loaiquyen) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sss", $sdt, $matkhau, $loaiquyen);
            if ($stmt->execute()) {
                echo "<script>
                alert('Thông tin tài khoản đã được thêm.');
                window.location.href = 'pagequanlytaikhoan.php';
                </script>";
            } else {
                echo 'Lỗi khi thêm tài khoản: ' . mysqli_error($conn);
            }
        }

        $stmt->close();
        mysqli_close($conn);
    }
    ?>

    <h1>Thêm Tài Khoản Mới</h1>

    <?php if (!empty($message)) : ?>
        <p class="error-message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="sdt">Số điện thoại:</label>
        <input type="text" id="sdt" name="sdt" required>

        <label for="matkhau">Mật khẩu:</label>
        <input type="password" id="matkhau" name="matkhau" required>

        <label for="loaiquyen">Loại quyền:</label>
        <select id="loaiquyen" name="loaiquyen" required>
            <option value="1" <?php if ($loaiquyen == '1') echo 'selected'; ?>>1</option>
            <option value="2" <?php if ($loaiquyen == '2') echo 'selected'; ?>>2</option>
            <option value="3" <?php if ($loaiquyen == '3') echo 'selected'; ?>>3</option>
        </select>

        <button type="submit">Thêm Tài Khoản</button>
    </form>

    <a href="pagequanlytaikhoan.php">Quay lại</a>
</div>

</body>
</html>
