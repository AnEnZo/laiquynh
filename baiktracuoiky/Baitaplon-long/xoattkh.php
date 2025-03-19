<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa dữ liệu</title>
</head>
<body>
    <?php
        $maKH = $_GET['maKH'];
        $conn = mysqli_connect("localhost","root","","quanlyquancafe1","3307");
        if(!$conn){
            echo 'Ket noi khong thanh cong, loi' . mysqli_connect_error();
        }
        else{
            $query = "DELETE FROM quanlykhachhang WHERE maKH='".$maKH."'";
            $result = mysqli_query($conn,$query);
            if($result >0){
                echo '<script>
                alert("Xóa dữ liệu thành công!");
                window.location.href = "pagequanlykhachhang.php";
            </script>
                ';
            }
            else{
                echo 'Lỗi xóa dữ liệu';
            }
        }
    ?>
</body>
</html>