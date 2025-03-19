<?php 
session_start();
if(isset($_SESSION['phone'])){
    $customer_phone = $_SESSION['phone'];
}else{
    echo'chưa đăng nhập';
}

session_write_close();

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <style>
        .cart-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .cart-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 200px;
        }
        .cart-item img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .cart-item h2 {
            font-size: 18px;
            text-align: center;
        }
        .cart-item p {
            font-size: 16px;
            text-align: center;
        }
        .cart-item button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-top: 10px;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .quantity-controls button {
            background-color: #ddd;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin: 0 5px;
        }
        .order-section {
            margin-top: 20px;
            text-align: center;
        }
        .order-section input {
            padding: 10px;
            width: 300px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .order-section button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
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

    </style>
</head>
<body>
    <h1>Giỏ hàng của bạn</h1>
    <div id="cart-items" class="cart-container"></div>

    <form id="orderForm" action="pagethemdonhang.php" method="POST">
        <div class="order-section">
            <input type="text" id="madh" name="madh" placeholder="Mã đơn hàng" style="display: none;">
            <input type="text" id="customer-name" name="customer-name" placeholder="Nhập tên khách hàng">
            <input type="hidden" id="phone" name="phone" value="<?php echo $customer_phone; ?>">
            <input type="text" id="address" name="address" placeholder="Nhập địa chỉ của bạn">
            <input type="text" id="mon" name="mon" placeholder="Danh sách món" style="display: none;">
            <input type="text" id="tongtien" name="tongtien" placeholder="Tổng tiền" style="display: none;">
            <input type="text" id="trangthai" name="trangthai" value="bạn có đơn hàng mới" style="display: none;">
            <input type="hidden" id="thoigiandathang" name="thoigiandathang">
            <button type="button" onclick="placeOrder()">Đặt hàng</button>
        </div>
    </form>

    <script>
        


        let totalAmount = 0;
        let monAn = []; // Mảng để lưu tên món và số lượng

        function loadCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || {};
            let cartItemsContainer = document.getElementById('cart-items');
            cartItemsContainer.innerHTML = ''; // Clear previous items

            // Reset lại tổng số tiền và mảng món ăn
            totalAmount = 0;
            monAn = [];

            for (let masp in cart) {
                let item = cart[masp];
                let cartItemDiv = document.createElement('div');
                cartItemDiv.className = 'cart-item';

                // Tính tổng tiền cho từng sản phẩm
                let itemTotal = item.giaban * item.quantity;
                totalAmount += itemTotal; // Cộng vào tổng tiền
                
                // Thêm món vào mảng monAn nếu chưa tồn tại
                let existingItem = monAn.find(mon => mon.name === item.tensp);
                if (existingItem) {
                    existingItem.quantity += item.quantity;
                } else {
                    monAn.push({ name: item.tensp, quantity: item.quantity });
                }
                
                cartItemDiv.innerHTML = `
                    <img src="${item.linkimg}" alt="${item.tensp}">
                    <h2>${item.tensp}</h2>
                    <p>Giá: ${Number(item.giaban).toLocaleString('vi-VN')} .000 VND</p>
                    <div class="quantity-controls">
                        <button onclick="updateQuantity('${masp}', -1)">-</button>
                        <p>Số lượng: <span id="quantity-${masp}">${item.quantity}</span></p>
                        <button onclick="updateQuantity('${masp}', 1)">+</button>
                    </div>
                    <button onclick="removeFromCart('${masp}')">Xóa</button>
                `;

                cartItemsContainer.appendChild(cartItemDiv);
            }
        }

        function updateQuantity(masp, change) {
            let cart = JSON.parse(localStorage.getItem('cart')) || {};
            if (cart[masp]) {
                cart[masp].quantity += change;
                if (cart[masp].quantity <= 0) {
                    delete cart[masp];
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart();
            }
        }

        function removeFromCart(masp) {
            let cart = JSON.parse(localStorage.getItem('cart')) || {};
            if (cart[masp]) {
                delete cart[masp];
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart();
                alert('Sản phẩm đã được xóa khỏi giỏ hàng.');
            }
        }

        function generateOrderId() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let orderId = '';
            for (let i = 0; i < 6; i++) {
                orderId += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return orderId;
        }

        function isValidPhoneNumber(phone) {
            return /^\d{10}$/.test(phone); // Kiểm tra xem có đúng 10 số hay không
        }

        function placeOrder() {
            let cart = JSON.parse(localStorage.getItem('cart')) || {};
            let customerName = document.getElementById('customer-name').value;
            let phone = document.getElementById('phone').value;
            let address = document.getElementById('address').value;
            
            if (Object.keys(cart).length === 0) {
                alert('Giỏ hàng của bạn đang trống.');
                return;
            }
            if (!customerName) {
                alert('Vui lòng nhập tên khách hàng.');
                return;
            }
            if (!isValidPhoneNumber(phone)) {
                alert('Vui lòng nhập số điện thoại hợp lệ (10 số).');
                return;
            }
            if (!address) {
                alert('Vui lòng nhập địa chỉ của bạn.');
                return;
            }

            let orderTime = new Date().toLocaleString('vi-VN');
            let orderId = generateOrderId();
            let monAnJson = JSON.stringify(monAn);

            // Đưa các giá trị vào các input ẩn để submit
            document.getElementById('madh').value = orderId;
            document.getElementById('mon').value = monAnJson;
            document.getElementById('tongtien').value = totalAmount;
            document.getElementById('thoigiandathang').value = new Date().toISOString().slice(0, 19).replace('T', ' ');

            // Submit form
            document.getElementById('orderForm').submit();
        }

        // Load cart items when page loads
        window.onload = loadCart;
    </script>
    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>
</body>
</html>
