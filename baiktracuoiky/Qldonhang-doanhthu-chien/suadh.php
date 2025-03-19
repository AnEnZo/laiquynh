<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa đơn hàng - Cafe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px 8px 0 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sửa đơn hàng</h1>
        </div>
        <?php
        // Kết nối tới cơ sở dữ liệu
        $conn = mysqli_connect("localhost", "root", "", "quanlyquancafe1","3307");

        // Kiểm tra kết nối
        if(!$conn){
            echo '<p style="color: red;">Kết nối không thành công, lỗi: ' . mysqli_connect_error() . '</p>';
        } else {
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $query = "SELECT * FROM tbldonhang WHERE madh = '$id'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $madh = $_POST['madh'];
                $tenkh = $_POST['tenkh'];
                $sdt = $_POST['sdt'];
                $dchi = $_POST['diachi'];
                $gia = $_POST['gia']; // Đổi từ $_POST['tongtien'] thành $_POST['gia']
                $mon = $_POST['mon'];

                $updateQuery = "UPDATE tbldonhang SET tenkh='$tenkh', sdt='$sdt', diachi='$dchi', tongtien='$gia', mon='$mon' WHERE madh='$madh'";
                if(mysqli_query($conn, $updateQuery)){
                    echo '<script>alert("Cập nhật thành công!"); window.location.href = "qldh.php";</script>';
                } else {
                    echo '<p style="color: red;">Cập nhật không thành công, lỗi: ' . mysqli_error($conn) . '</p>';
                }
            }
        }
        ?>
        <form method="POST" action="suadh.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="madh">Mã đơn hàng</label>
                <input type="text" id="madh" name="madh" value="<?php echo isset($row['madh']) ? $row['madh'] : ''; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="tenkh">Tên khách hàng</label>
                <input type="text" id="tenkh" name="tenkh" value="<?php echo isset($row['tenkh']) ? $row['tenkh'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="sdt">Số điện thoại</label>
                <input type="text" id="sdt" name="sdt" value="<?php echo isset($row['sdt']) ? $row['sdt'] : ''; ?>" pattern="[0-9]{10}" title="Số điện thoại phải là 10 số" required>
            </div>
            <div class="form-group">
                <label for="dchi">Địa chỉ</label>
                <input type="text" id="dchi" name="dchi" value="<?php echo isset($row['diachi']) ? $row['diachi'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="gia">Giá</label>
                <input type="text" id="gia" name="gia" value="<?php echo isset($row['tongtien']) ? $row['tongtien'] : ''; ?>" pattern="[0-9]*" title="Vui lòng nhập số nguyên dương">
            </div>
            <div class="form-group">
                <label for="mon">Món</label>
                <input type="text" id="mon" name="mon" value="<?php echo isset($row['mon']) ? $row['mon'] : ''; ?>">
            </div>
            <div class="form-group">
                <button type="submit">Cập nhật</button>
            </div>
        </form>
    </div>
    <script>
        function validateForm() {
            var sdt = document.getElementById('sdt').value;
            if (sdt.length !== 10) {
                alert('Số điện thoại phải gồm đúng 10 số');
                return false;
            }
            return true;
        }
    </script>
        <a href="/baiktracuoiky/Qldonhang-doanhthu-chien/qldh.php" class="btn-exit">Quay lại</a>
</body>
</html>
