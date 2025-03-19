<?php
// Bắt đầu session ngay từ đầu
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Coffee House Clone</title>
    
    <style>
        /* Reset một số thiết lập mặc định */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f8f8f8;
        }

        header {
            background-color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header .logo img {
            height: 40px;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin-left: auto;
        }

        header nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 4px;
            background-color: black;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        .container-img-sdt {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .img-sdt {
            text-align: right;
            padding-right: 20px;
            padding: 10px;
            display: flex;
            align-items: center;
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
        }

        .features {
            position: relative;
            max-width: 100%;
            margin: 50px auto;
            overflow: hidden;
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .feature {
            min-width: 100%;
            box-sizing: border-box;
        }

        .feature img {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .feature h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
            text-align: center;
        }

        .feature p {
            font-size: 1em;
            color: #777;
            text-align: center;
        }

        .controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .control-btn {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .displayproduct {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin: 20px 0;
        }

        .product {
            width: calc(33.333% - 20px);
            background-color: #f8f8f8;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .product img {
            max-width: 100%;
            height: auto;
            max-height: 200px;
            margin-bottom: 10px;
        }

        .product h2 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .product p {
            font-size: 1em;
            color: #333;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
           
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <img src="Ảnh chụp màn hình 2024-06-18 180437.png" alt="The Coffee House Logo">
    </div>
    <nav>      
        <?php          
        if(isset($_SESSION['phone'])) {  
            if ($_SESSION['loaiquyen'] == 1 ) {
                echo '<div>';
                include 'pagedropbuton.php';
                echo '<a href="/baiktracuoiky/Baitaplon-long/themttkh.php" class="function-item">Thông tin cá nhân</a>';
                echo '<div><a href="/baiktracuoiky/Qldonhang-doanhthu-chien/donhangkhach.php" class="function-item">Đơn hàng của tôi</a></div>';                           
            }
            if ($_SESSION['loaiquyen'] == 2 ) {
                echo '<div>';
                include 'pagedropbuton.php';
                echo'</div>';
                echo'<ul class="function-item">';                           
                echo '<div><a href="/baiktracuoiky/Qldonhang-doanhthu-chien/qldh.php" class="function-item">Quản lý đơn hàng</a></div>';           
                echo '</ul>';             
            }
            if ($_SESSION['loaiquyen'] == 3) {
                echo '<div>';
                include 'pagedropbuton.php';
                echo'</div>';
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
            }   
            echo'<div class="img-sdt">';              
            echo '<div class="container-img-sdt">';
            echo '<img src="Ảnh chụp màn hình 2024-06-19 003642.png" class="user-avatar">';
            echo '<span class="user-phone">' . $_SESSION['phone'] . '</span>';
            echo '</div>';
            echo '<a href="pagedangxuat.php" class="logout-button">Đăng xuất</a>';
            echo'</div>';         
        } else {
            echo '<div>';
            include 'pagedropbuton.php';
            echo'</div>';              
            echo '<div class="img-sdt">';
            echo '<div class="container-img-sdt">';
            echo '<a href="pagedangnhap.php" class="login-button">Đăng nhập</a>';
            echo '<a href="pagedangky.php" class="signup-button">Đăng ký</a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </nav>
</header>

<div class="features">
    <?php include 'pageslideshow.php'; ?>
</div>

<div class="displayproduct">
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1', '3307');
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $sql = "SELECT masp, tensp, giaban, linkimg FROM tbl_doan UNION ALL SELECT masp, tensp, giaban, linkimg FROM tbl_douong";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="product">';
            echo '<img src="' . $row["linkimg"] . '" alt="' . $row["tensp"] . '">';
            echo '<h2>' . $row["tensp"] . '</h2>';
            echo '<p>' . number_format($row["giaban"], 0, ',', '.') . '.000 VND</p>';
            echo '<button type="button" class="add-to-cart" data-masp="' . $row["masp"] . '" data-tensp="' . $row["tensp"] . '" data-giaban="' . $row["giaban"] . '" data-linkimg="' . $row["linkimg"] . '">Thêm vào giỏ hàng</button>';
            echo '</div>';
        }
    } else {
        echo "Không có sản phẩm nào.";
    }

    // Đóng kết nối
    $conn->close();
    ?>
</div>

<script>
// Hàm để thêm sản phẩm vào giỏ hàng
function addToCart(product) {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};
    if (cart[product.masp]) {
        cart[product.masp].quantity += 1;
    } else {
        cart[product.masp] = product;
        cart[product.masp].quantity = 1;
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    alert('Đã thêm sản phẩm vào giỏ hàng.');
}

// Lắng nghe sự kiện click trên các nút "Thêm vào giỏ hàng"
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
        const product = {
            masp: button.getAttribute('data-masp'),
            tensp: button.getAttribute('data-tensp'),
            giaban: button.getAttribute('data-giaban'),
            linkimg: button.getAttribute('data-linkimg')
        };
        addToCart(product);
    });
});s
</script>

<footer>
    <p>&copy; 2024 The Coffee House. All rights reserved.</p>
    hotline:0564860804
</footer>

</body>
</html>