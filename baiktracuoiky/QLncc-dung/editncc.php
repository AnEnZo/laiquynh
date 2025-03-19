<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function ktra() {
            var tenNCC = document.getElementById("TenNCC").value;
            var SĐT = document.getElementById("SĐT").value;
            var tenPattern = /^[A-Za-z\sà-ỹ]+$/;

            if (tenNCC.trim() === "") {
                alert("Tên nhà cung cấp không được bỏ trống");
                return false;
            }

            if (!tenNCC.match(tenPattern)) {
                alert("Tên nhà cung cấp chỉ được nhập chữ cái");
                return false;
            }

            if (SĐT.trim() === "") {
                alert("Số điện thoại không được bỏ trống");
                return false;
            }

            if (!/^\d+$/.test(SĐT)) {
                alert("Số điện thoại chỉ được nhập số");
                return false;
            }

            return true;
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=date], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        input[type=radio] {
            width: 10%;
            margin: 20px;
        }
        form {
            border-radius: 10px;
            background-color: #fff;
            padding: 20px;
            width: 50%;
        }
        h2 {
            text-align: center;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<?php
require 'connectncc.php';
$MaNCC = $_GET['MaNCC'];
$TenNCC = "";
$LoaiNCC = "";
$DiaChi = "";
$SĐT = "";
$Email = "";
$GhiChu = "";

if (!$conn) {
    echo 'Kết nối không thành công';
} else {
    if ($MaNCC !== '') {
        $query = "SELECT * FROM tbl_nhacungcap WHERE MaNCC='$MaNCC'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $TenNCC = $row['TenNCC'];
            $LoaiNCC = $row['LoaiNCC'];
            $DiaChi = $row['DiaChi'];
            $SĐT = $row['SĐT'];
            $Email = $row['Email'];
            $GhiChu = $row['GhiChu'];
        }
    }
}
?> 
<form action="" method="post" onsubmit="return ktra()">
    <h2>Sửa nhà cung cấp</h2>
    <div>
        <label for="MaNCC">Mã nhà cung cấp: </label>
        <input type="text" name="MaNCC" id="MaNCC" value="<?php echo $MaNCC; ?>" />
        <br />
    </div>
    <div>
        <label for="TenNCC">Tên nhà cung cấp: </label>
        <input type="text" name="TenNCC" id="TenNCC" value="<?php echo $TenNCC; ?>" />
        <br />
    </div>
    <div>
        <label for="LoaiNCC">Cung cấp sản phẩm: </label>
        <input type="text" name="LoaiNCC" id="LoaiNCC" value="<?php echo $LoaiNCC; ?>" />
        <br />
    </div>
    <div>
        <label for="DiaChi">Địa chỉ: </label>
        <input type="text" name="DiaChi" id="DiaChi" value="<?php echo $DiaChi; ?>" />
        <br />
    </div>
    <div>
        <label for="SĐT">SĐT: </label>
        <input type="text" name="SĐT" id="SĐT" value="<?php echo $SĐT; ?>" />
        <br />
    </div>
    <div>
        <label for="Email">Email: </label>
        <input type="text" name="Email" id="Email" value="<?php echo $Email; ?>" />
        <br />
    </div>
    <div>
        <label for="GhiChu">Ghi chú: </label>
        <input type="text" name="GhiChu" id="GhiChu" value="<?php echo $GhiChu; ?>" />
        <br />
    </div>
    <input type="submit" name="btn" value="Sửa nhà cung cấp">
    <a href="indexncc.php">Trở về trang chủ</a>
</form>

<?php
if (isset($_POST['btn'])) {
    $TenNCC = $_POST['TenNCC'];
    $LoaiNCC = $_POST['LoaiNCC'];
    $DiaChi = $_POST['DiaChi'];
    $SĐT = $_POST['SĐT'];
    $Email = $_POST['Email'];
    $GhiChu = $_POST['GhiChu'];

    if (!$conn) {
        echo 'Kết nối không thành công';
    } else {
        $query = "UPDATE tbl_nhacungcap SET TenNCC='$TenNCC', LoaiNCC='$LoaiNCC', DiaChi='$DiaChi', SĐT='$SĐT', Email='$Email', GhiChu='$GhiChu' WHERE MaNCC='$MaNCC'";
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Sửa thành công");</script>';
        } else {
            echo 'Cập nhật thất bại';
        }
    }
}
?>
</body>
</html>
