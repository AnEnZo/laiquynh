<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
      require 'connectncc.php';
      $MaNCC=$_GET['MaNCC'];
        if(!$conn){
          echo 'Ket loi khong thanh cong';
        }
        else{
          $query ="DELETE FROM tbl_nhacungcap WHERE MaNCC='$MaNCC'";
          if(mysqli_query($conn, $query)){
            echo '<script>
            alert("Xóa thành công");
            window.location.href ="indexncc.php";
            </script>';
          }
          else{
            echo 'that bai';
          }
        }
      
    ?>
</body>
</html>