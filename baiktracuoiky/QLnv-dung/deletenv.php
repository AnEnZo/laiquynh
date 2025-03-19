<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
      require 'connectnv.php';
      $MaNV=$_GET['MaNV'];
        if(!$conn){
          echo 'Ket loi khong thanh cong';
        }
        else{
          $query ="DELETE FROM tbl_nhanvien WHERE MaNV='$MaNV'";
          if(mysqli_query($conn, $query)){
            echo '<script>
            alert("Xóa thành công");
            window.location.href ="indexnv.php";
            </script>';
          }
          else{
            echo 'that bai';
          }
        }
      
    ?>
</body>
</html>