<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleindexnv.css">
    <style>
      .function-item {
            padding: 10px 20px;
            background-color: black;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
      .btn-quaylai {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: green;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-quaylai:hover {
            background-color: #0056b3;
          }


          .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .footer p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php
echo'<ul class="function-item">';
echo '<div><a href="/baiktracuoiky/QLnv-dung/indexnv.php" class="function-item">Quản lý nhân viên</a></div>';
echo '<div><a href="/baiktracuoiky/SanPham-hoan/SP/index.php" class="function-item">Quản lý sản phẩm</a></div>';
echo '<div><a href="/baiktracuoiky/Qldonhang-doanhthu-chien/qldh.php" class="function-item">Quản lý đơn hàng</a></div>';
echo '<div><a href="/baiktracuoiky/Qldonhang-doanhthu-chien/lsdh.php" class="function-item">Lịch sử đơn hàng</a></div>';
echo '<a href="/baiktracuoiky/Baitaplon-long/pagequanlykhachhang.php" class="function-item">Quản lý khách hàng</a>';
echo '<a href="/baiktracuoiky/Qldonhang-doanhthu-chien/doanhthu.php" class="function-item">Doanh thu</a>';
echo '<div><a href="/baiktracuoiky/QLncc-dung/indexncc.php" class="function-item">Quản lý nhà cung cấp</a></div>';
echo '<a href="pagequanlytaikhoan.php" class="function-item">Quản lý tài khoản</a>';         
echo '</ul>';

?>

    <form action="" method="post">
        <div class="search">
            <input type="text" id="search" name="search" class="search-input" placeholder="Nhập tên tìm kiếm">
            <button  name="btnsearch" class="btnsearch"> Tìm kiếm</button>
        </div>
    </form>
    <h2>Danh sách nhân viên</h2>
    <?php
    require ('connectnv.php');
    if(!$conn){
      echo 'kết nối ko thành công. Lỗi ';
    }
    else{
      $query="SELECT * FROM tbl_nhanvien";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) > 0){
        echo '<table id="customers" >
                 <thead>
                    <th>Mã nhân viên</th>
                    <th>Tên nhân viên</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Địa chỉ</th>
                    <th>SĐT</th>
                    <th>Ghi chú</th>
                    <th>Chức năng</th>
                  </thead>
                <tbody>';
        
        while($row = mysqli_fetch_assoc($result)){
            $date = date('d-m-Y', strtotime($row["NgaySinh"]));
          echo ' <tr>
                    
                    <td>'.$row["MaNV"].'</td>
                    <td>'.$row["TenNV"].'</td>
                    <td>'.$row["GioiTinh"].'</td>
                    <td>'.$date.'</td>
                    <td>'.$row["DiaChi"].'</td>
                    <td>'.$row["SĐT"].'</td>
                    <td>'.$row["GhiChu"].'</td>
                    <td>
                      <button class="button" id="click">
                         <a class="note"  href=" editnv.php?MaNV=' . $row["MaNV"] . '" >Sửa</a>
                      </button>
                     <button class= "button" id="click">
                         <a class="note" onclick  = "return confirm(\'Bạn có muốn xóa\');" href="deletenv.php?MaNV=' . $row["MaNV"] . '">Xóa </a>
                      </button>
                    </td>
                  </tr>';
        }
          echo '</tbody></table>';
      }
    }
    ?>
    <button class="btnThem" ><a href="createnv.php" class="note">Thêm nhân viên</a></button>
    <button class="btnThem" ><a href="indexnv.php" class="note">Reset</a></button>
    <?php
      require ('connectnv.php');

      if(isset($_POST['btnsearch'])){
        $keySearch =$_POST['search'];
        if(!$conn){
          echo 'ket noi khong thanh cong. Loi ';
        }
        else{
          echo '<script>
                  var table =document.getElementById("customers");
                  table.style.display ="none";
                </script>';
          $query="SELECT * FROM tbl_nhanvien Where TenNV LIKE N'%".$keySearch."%'" ;
          $result = mysqli_query($conn, $query);
          if(mysqli_num_rows($result) > 0){
            echo '<table id="customers">
                     <thead>
                     
                        <th>Mã nhân viên</th>
                        <th>Tên nhân viên</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Địa Chỉ</th>
                        <th>SĐT</th>
                        <th>Ghi chú</th>
                        <th>Chức năng</th>
                      </thead>
                    <tbody>';
            while($row = mysqli_fetch_assoc($result)){
                  $date = date('d-m-Y', strtotime($row["NgaySinh"]));
              echo ' <tr>
               
                    <td>'.$row["MaNV"].'</td>
                    <td>'.$row["TenNV"].'</td>
                    <td>'.$row["GioiTinh"].'</td>
                    <td>'.$date.'</td>
                    <td>'.$row["DiaChi"].'</td>
                    <td>'.$row["SĐT"].'</td>
                    <td>'.$row["GhiChu"].'</td>
                    <td> <button class="button" id="click">
                         <a class="note"  href=" editnv.php?MaNV=' . $row["MaNV"] . '" >Sửa</a>
                      </button>
                     <button class= "button" id="click">
                         <a class="note" onclick  = "return confirm(\'Bạn có muốn xóa\');" href="deletenv.php?MaNV=' . $row["MaNV"] . '">Xóa </a>
                      </button></td>
                  </tr>';

            }
              echo '</tbody></table>';
          }
        }
      }
    ?>
<p></p>
<a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>
<footer class="footer">
    <p>&copy; 2024 The Coffee House. All rights reserved.</p>
    <p>Hotline: 0564 860 804</p>
</footer>
</body>
</html>