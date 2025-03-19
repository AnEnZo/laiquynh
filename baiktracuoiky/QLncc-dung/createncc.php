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
        <h2>Thêm nhà cung cấp</h2>
        <label for="">Mã nhà cung cấp: </label>
        <input type="text" name="MaNCC" id="MaNCC" />
        <br />
        <label for="">Tên nhà cung cấp: </label>
        <input type="text" name="TenNCC" id="TenNCC" />
        <br />
        <label for="">Cung cấp sản phẩm: </label>
        </br>
        <input type="text" name="LoaiNCC" id="LoaiNCC" />
        <br />
        <label for="">Địa chỉ: </label>
        <input type="text" name="DiaChi" id="DiaChi" />
        <br />
        <label for="">SĐT:</label>
        <input type="text" name="SĐT" id="SĐT" />
        <br />
        <label for="">Email: </label>
        <input type="text" name="Email" id="Email" />
        <br />
        <label for="">Ghi chú: </label>
        <input type="text" name="GhiChu" id="GhiChu" />
        <br />
        <input type="submit" name="submit" value="Thêm nhà cung cấp">
        <a href="indexncc.php"  >Trở về trang chủ</a>

      
    </form>

    <?php
      require 'connectncc.php';
      if(isset($_POST['submit'])){
        $MaNCC =$_POST['MaNCC'];
        $TenNCC =$_POST['TenNCC'];
        $LoaiNCC =$_POST['LoaiNCC'];
        $DiaChi =$_POST['DiaChi'];
        $SĐT =$_POST['SĐT'];
        $Email =$_POST['Email'];
        $GhiChu =$_POST['GhiChu'];
       

        if(!$conn){
          echo 'Ket loi khong thanh cong';
        }
        else{
          $query ="INSERT INTO `tbl_nhacungcap` (`MaNCC`,`TenNCC`,`LoaiNCC`,`DiaChi`,`SĐT`,`Email`,`GhiChu`) VALUE ('$MaNCC',' $TenNCC','$LoaiNCC','$DiaChi','$SĐT','$Email','$GhiChu')";
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
    ?>
</body>
</html>