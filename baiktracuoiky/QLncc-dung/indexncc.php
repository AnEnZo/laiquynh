<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleindexncc.css">
    <style>
                  #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 120%;
              }
            .search {
            margin-bottom: 5px;
            text-align: center;
            margin-top:40px ;
            }
            .search-input {
            width: 50%;
            height: 25px;
            border-radius: 5px;
            border: 1px solid #cac9c9;
            padding: 5px;
            margin-right: 10px;
            margin-top:40px;
            }
.function-item {
            padding: 10px 20px;
            background-color: black;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: -10px;          
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
        ul{
          position: fixed;
       
        }
 </style>
</head>
<body>
<?php
echo'<ul class="function-item">';
echo '<div><a href="/baiktracuoiky/dta/trangchu.php" class="function-item">Trang chủ</a></div>';
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
<input type="text" id="search" name="search" class="search-input" placeholder="Nhập tên nhà cung cấp cần tìm kiếm">
            <button  name="btnsearch" class="btnsearch"> Tìm kiếm</button>
        </div>
    </form>
    <h2>Danh sách nhà cung cấp</h2>
    <?php
    require ('connectncc.php');
    if(!$conn){
      echo 'kết nối ko thành công. Lỗi ';
    }
    else{
      $query="SELECT * FROM tbl_nhacungcap";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) > 0){
        echo '<table id="customers" >
                 <thead>
                
                    <th>Mã nhà cung cấp</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Cung cấp sản phẩm</th>
                    <th>Địa chỉ</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>Ghi chú</th>
                    <th>Chức năng</th>
                  </thead>
                <tbody>';
        
        while($row = mysqli_fetch_assoc($result)){
            
          echo ' <tr>
                    
                    <td>'.$row["MaNCC"].'</td>
                    <td>'.$row["TenNCC"].'</td>
                    <td>'.$row["LoaiNCC"].'</td>
                    <td>'.$row["DiaChi"].'</td>
                    <td>'.$row["SĐT"].'</td>
                    <td>'.$row["Email"].'</td>
                    <td>'.$row["GhiChu"].'</td>
                    <td>
                      <button class="button" id="click">
                         <a class="note"  href=" editncc.php?MaNCC=' . $row["MaNCC"] . '" >Sửa</a>
                      </button>
                     <button class= "button" id="click">
                         <a class="note" onclick  = "return confirm(\'Bạn có muốn xóa\');" href="deletencc.php?MaNCC=' . $row["MaNCC"] . '">Xóa </a>
                      </button>
                    </td>
                  </tr>';
        }
          echo '</tbody></table>';
      }
    }
    ?>
    <button class="btnThem" ><a href="createncc.php" class="note">Thêm nhà cung cấp</a></button>
    <button class="btnThem" ><a href="indexncc.php" class="note">Reset</a></button>
    <?php
      require ('connectncc.php');

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
          $query="SELECT * FROM tbl_nhacungcap Where TenNCC LIKE N'%".$keySearch."%'" ;
          $result = mysqli_query($conn, $query);
          if(mysqli_num_rows($result) > 0){
            echo '<table id="customers">
                     <thead>
                    
                    <th>Mã nhà cung cấp</th>
<th>Tên nhà cung cấp</th>
                    <th>Cung cấp sản phẩm</th>
                    <th>Địa chỉ</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>Ghi chú</th>
                    <th>Chức năng</th>
                       
                      </thead>
                    <tbody>';
            while($row = mysqli_fetch_assoc($result)){
    
              echo ' <tr>
               
                <td>'.$row["MaNCC"].'</td>
                <td>'.$row["TenNCC"].'</td>
                <td>'.$row["LoaiNCC"].'</td>
                <td>'.$row["DiaChi"].'</td>
                <td>'.$row["SĐT"].'</td>
                <td>'.$row["Email"].'</td>
                <td>'.$row["GhiChu"].'</td>
                    
                    <td> <button class="button" id="click">
                         <a class="note"  href=" editncc.php?MaNCC=' . $row["MaNCC"] . '" >Sửa</a>
                      </button>
                     <button class= "button" id="click">
                         <a class="note" onclick  = "return confirm(\'Bạn có muốn xóa\');" href="deletencc.php?MaNCC=' . $row["MaNCC"] . '">Xóa </a>
                      </button></td>
                  </tr>';

            }
              echo '</tbody></table>';
          }
        }
      }
    ?>
    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>

    
</body>
</html>