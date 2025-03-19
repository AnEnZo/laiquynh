<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function ktra() {
            var tenNV = document.getElementById("TenNV").value;
            var SĐT = document.getElementById("SĐT").value;
            var tenPattern = /^[A-Za-z\sà-ỹ]+$/;

            if (tenNV.trim() === "") {
                alert("Tên nhân viên không được bỏ trống");
                return false;
            }

            if (!tenNV.match(tenPattern)) {
                alert("Tên nhân viên chỉ được nhập chữ cái");
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
   input[type=date],select{
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
  background-color:#ffff;
  padding: 20px;
  width:50%;
  
  
  
}
h2{
    text-align: center;
}
a{
    
    text-decoration: none;
}
    
    </style>
</head>
<body>
<?php
require 'connectnv.php';
$MaNV =$_GET['MaNV'];
$TenNV = "";
$GioiTinh = "";
$NgaySinh = "";
$DiaChi = "";
$SĐT = "";
$GhiChu = "";

if (!$conn) {
    echo 'Kết nối không thành công';
} else {
    if ($MaNV !== '') {
        $query = "SELECT * FROM tbl_nhanvien WHERE MaNV='$MaNV'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $TenNV = $row['TenNV'];
            $GioiTinh = $row['GioiTinh'];
            $NgaySinh = $row['NgaySinh'];
            $DiaChi = $row['DiaChi'];
            $SĐT = $row['SĐT'];
            $GhiChu = $row['GhiChu'];
        }
    }
}
?> 
<form action="" method="post" onsubmit="return ktra()">
    <h2>Sửa nhân viên</h2>
    <div>
        <label for="MaNV">Mã nhân viên: </label>
        <input type="text" name="MaNV" id="MaNV" value="<?php echo $MaNV; ?>" readonly />
        <br />
    </div>
    <div>
        <label for="TenNV">Tên nhân viên: </label>
        <input type="text" name="TenNV" id="TenNV" value="<?php echo $TenNV; ?>" />
        <br />
    </div>
    <div>
        <label for="GioiTinh">Giới tính: </label>
        <input type="radio" name="GioiTinh" id="Nam" value="Nam" <?php echo ($GioiTinh == 'Nam') ? 'checked' : ''; ?> /> Nam
        <input type="radio" name="GioiTinh" id="Nu" value="Nữ" <?php echo ($GioiTinh == 'Nữ') ? 'checked' : ''; ?> /> Nữ
        <br />
    </div>
    <div>
        <label for="NgaySinh">Ngày sinh: </label>
        <input type="date" name="NgaySinh" id="NgaySinh" value="<?php echo $NgaySinh ?>" />
        <br />
    </div>
    <div>
        <label for="DiaChi">Địa chỉ: </label>
        <input type="text" name="DiaChi" id="DiaChi" value="<?php echo $DiaChi ?>" />
        <br />
    </div>
    <div>
        <label for="SĐT">SĐT: </label>
        <input type="text" name="SĐT" id="SĐT" value="<?php echo $SĐT; ?>" />
        <br />
    </div>
    <div>
        <label for="GhiChu">Ghi chú: </label>
        <input type="text" name="GhiChu" id="GhiChu" value="<?php echo $GhiChu; ?>" />
        <br />
    </div>
    <input type="submit" name="btn" value="Sửa nhân viên">
       
    <a href="indexnv.php" >Trở về trang chủ</a>
</form>

<?php
if (isset($_POST['btn'])) {
    $TenNV = $_POST['TenNV'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $DiaChi = $_POST['DiaChi'];
    $SĐT = $_POST['SĐT'];
    $GhiChu = $_POST['GhiChu'];

    if (!$conn) {
        echo 'Kết nối không thành công';
    } else {
        $query = "UPDATE tbl_nhanvien SET TenNV='$TenNV', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', DiaChi='$DiaChi', SĐT='$SĐT', GhiChu='$GhiChu' WHERE MaNV='$MaNV'";
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
