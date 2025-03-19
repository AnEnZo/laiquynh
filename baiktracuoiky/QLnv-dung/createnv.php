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
            var TemBB='NV';
            if(!TenNV.match(TemBB)){
              alert("Tên nhân viên phải có chữ NV");
              return false;

            }
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
  margin: 10px 0;
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
  padding: 14px 20px ;
  margin: 8px 0;
  margin-bottom:20px;
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

<form action="" method="post" onsubmit="return ktra()">
        <h2>Thêm nhân viên</h2>
        <label for="">Mã nhân viên: </label>
        <input type="text" name="MaNV" id="MaNV" />
        <br />
        <label for="">Tên nhân viên: </label>
        <input type="text" name="TenNV" id="TenNV" />
        <br />
        <label for="">Giới tính: </label>
        </br>
        <input type="radio" name="GioiTinh" id="Nam" value="Nam"  checked /> Nam 
        <input type="radio" name="GioiTinh" id="Nu" value="Nữ" /> Nữ
        <br />
        <label for="">Ngày sinh: </label>
        <input type="date" name="NgaySinh" id="NgaySinh" />
        <br />
        <label for="">Địa chỉ: </label>
        <input type="text" name="DiaChi" id="DiaChi" />
        <br />
<label for="">SĐT</label>
        <input type="text" name="SĐT" id="SĐT" />
        <br />
        <label for="">Ghi chú: </label>
        <input type="text" name="GhiChu" id="GhiChu" />
        <br />
        <input type="submit" name="submit" value="Thêm nhân viên">
       
        <a href="indexnv.php"  >Trở về trang chủ</a>

      
    </form>

    <?php
      require 'connectnv.php';
      if(isset($_POST['submit'])){
        $MaNV =$_POST['MaNV'];
        $TenNV =$_POST['TenNV'];
        $GioiTinh =$_POST['GioiTinh'];
        $NgaySinh =$_POST['NgaySinh'];
        $DiaChi =$_POST['DiaChi'];
        $SĐT =$_POST['SĐT'];
        $GhiChu =$_POST['GhiChu'];
       

        if(!$conn){
          echo 'Ket loi khong thanh cong';
        } else {
          
          $check_query = "SELECT * FROM tbl_nhanvien WHERE MaNV = '$MaNV'";
          $check_result = mysqli_query($conn, $check_query);

          if (mysqli_num_rows($check_result) > 0) {
              echo '<script>alert("Mã nhân viên đã tồn tại. Vui lòng nhập mã khác.");</script>';
         
          }else{
          $query ="INSERT INTO `tbl_nhanvien` (`MaNV`,`TenNV`,`GioiTinh`,`NgaySinh`,`DiaChi`,`SĐT`,`GhiChu`) VALUE ('$MaNV',' $TenNV','$GioiTinh','$NgaySinh','$DiaChi','$SĐT','$GhiChu')";
          $result= mysqli_query($conn, $query);
          if($result>0){
            
            echo '<script>
            alert("Luu thanh cong");
           
            </script>';
          }
          else{
            echo 'that bai';
          }
        }
      }
    }
    ?>
</body>
</html>