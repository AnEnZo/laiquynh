<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            text-align: left;
            color: #333;
        }
        input, select, button, a {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
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
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        a:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

<?php
$sdt = "";
$matkhau = "";
$loaiquyen = "";

$conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1','3307');

if (!$conn) {
    die('Kết nối không thành công: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['sdt'])) {
    $sdt = $_GET['sdt'];

    $query = "SELECT * FROM tbltaikhoan WHERE SĐT = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $sdt);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $matkhau = $row["matkhau"];
        $loaiquyen = $row["loaiquyen"];
    } else {
        echo "Không tìm thấy tài khoản.";
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit();
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sdt = $_POST['sdt'];
    $matkhau = $_POST['matkhau'];
    $loaiquyen = $_POST['loaiquyen'];

    $query = "UPDATE tbltaikhoan SET matkhau = ?, loaiquyen = ? WHERE SĐT = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iss', $matkhau, $loaiquyen, $sdt);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Thông tin tài khoản đã được cập nhật.');
                window.location.href = 'pagequanlytaikhoan.php';
              </script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<div class="container">
    <h1>Sửa thông tin tài khoản</h1>
    <form action="" method="post">
        <label for="sdt">Số điện thoại:</label>
        <input type="text" id="sdt" name="sdt" value="<?php echo htmlspecialchars($sdt); ?>" readonly>
        
        <label for="matkhau">Mật khẩu:</label>
        <input type="password" id="matkhau" name="matkhau" value="<?php echo htmlspecialchars($matkhau); ?>" required>
        
        <label for="loaiquyen">Loại quyền:</label>
        <select id="loaiquyen" name="loaiquyen" required>
            <option value="1" <?php if ($loaiquyen == '1') echo 'selected'; ?>>1</option>
            <option value="2" <?php if ($loaiquyen == '2') echo 'selected'; ?>>2</option>
            <option value="3" <?php if ($loaiquyen == '3') echo 'selected'; ?>>3</option>
        </select>
        
        <button type="submit">Lưu thay đổi</button>
    </form>
    <a href="pagequanlytaikhoan.php">Quay lại</a>
</div>

</body>
</html>
