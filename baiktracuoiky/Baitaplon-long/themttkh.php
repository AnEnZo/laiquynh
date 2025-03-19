<?php 
session_start();
$customer_phone = $_SESSION['phone'];
session_write_close();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="/baiktracuoiky/Baitaplon-long/themttkh.css">
    <style>
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            position: fixed;
            bottom: 20px;
            left: 20px;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
        ///^[^\s@]+@[^\s@]+\.[^\s@]+$/
        // Kết nối đến cơ sở dữ liệu
        $conn = mysqli_connect("localhost", "root", "", "quanlyquancafe1", "3307");
        if (!$conn) {
            die("Kết nối không thành công, lỗi: " . mysqli_connect_error());
        }

        function generateUniqueCustomerId($conn) {
            $prefix = 'KH';
            do {
                $uniqueId = $prefix . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                $query_check = "SELECT * FROM quanlykhachhang WHERE maKH = ?";
                $stmt_check = $conn->prepare($query_check);
                $stmt_check->bind_param("s", $uniqueId);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();
            } while ($result_check->num_rows > 0);
            return $uniqueId;
        }

        $editMode = isset($_GET['edit']) ? true : false;
        $updateSuccess = false;

        // Xử lý khi form được gửi
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $maKH = $_POST['txtmaKH'];
            $hoTen = $_POST['txthoTen'];
            $ngaySinh = $_POST['dtpngaySinh'];
            $diaChi = $_POST['txtdiaChi'];
            $gioiTinh = $_POST['gioiTinh'];
            $Email = $_POST['txtEmail'];
            $Sdt = $_POST['txtSdt'];

            // Kiểm tra xem mã khách hàng đã tồn tại hay chưa
            $query_check = "SELECT * FROM quanlykhachhang WHERE maKH = ?";
            $stmt_check = $conn->prepare($query_check);
            $stmt_check->bind_param("s", $maKH);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                // Mã khách hàng đã tồn tại, cập nhật thông tin
                $query_update = "UPDATE quanlykhachhang SET hoTen=?, ngaySinh=?, diaChi=?, gioiTinh=?, Email=?, SĐT=? WHERE maKH=?";
                $stmt_update = $conn->prepare($query_update);
                $stmt_update->bind_param("sssssss", $hoTen, $ngaySinh, $diaChi, $gioiTinh, $Email, $Sdt, $maKH);
                if ($stmt_update->execute()) {
                    $updateSuccess = true;
                } else {
                    echo "Lỗi cập nhật: " . $stmt_update->error;
                }
            } else {
                // Mã khách hàng chưa tồn tại, chèn mới
                $query_insert = "INSERT INTO quanlykhachhang (maKH, hoTen, ngaySinh, diaChi, gioiTinh, Email, SĐT) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($query_insert);
                $stmt_insert->bind_param("sssssss", $maKH, $hoTen, $ngaySinh, $diaChi, $gioiTinh, $Email, $Sdt);
                if ($stmt_insert->execute()) {
                    $updateSuccess = true;
                } else {
                    echo "Lỗi chèn mới: " . $stmt_insert->error;
                }
            }
        }

        // Kiểm tra xem số điện thoại của khách hàng có trong cơ sở dữ liệu không
        $query_select = "SELECT * FROM quanlykhachhang WHERE SĐT = ?";
        $stmt_select = $conn->prepare($query_select);
        $stmt_select->bind_param("s", $customer_phone);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($editMode) {
                // Hiển thị form với dữ liệu hiện tại để chỉnh sửa
                echo '<form method="POST">
                        <h2>Chỉnh sửa thông tin cá nhân</h2>
                        <table>
                            <tr>
                                <td>Mã khách hàng:</td>
                                <td><input type="text" name="txtmaKH" value="' . $row['maKH'] . '" readonly></td>
                            </tr>
                            <tr>
                                <td>Họ tên:</td>
                                <td><input type="text" name="txthoTen" value="' . $row['hoTen'] . '" required></td>
                            </tr>
                            <tr>
                                <td>Ngày sinh:</td>
                                <td><input type="date" name="dtpngaySinh" value="' . $row['ngaySinh'] . '" required></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ:</td>
                                <td><input type="text" name="txtdiaChi" value="' . $row['diaChi'] . '" required></td>
                            </tr>
                            <tr>
                                <td>Giới tính:</td>
                                <td>
                                    <input type="radio" name="gioiTinh" value="1" ' . ($row['gioiTinh'] == 1 ? 'checked' : '') . '> Nam
                                    <input type="radio" name="gioiTinh" value="0" ' . ($row['gioiTinh'] == 0 ? 'checked' : '') . '> Nữ
                                </td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td><input type="email" name="txtEmail" value="' . $row['Email'] . '" required></td>
                            </tr>
                            <tr>
                                <td>Sdt:</td>
                                <td><input type="tel" name="txtSdt" value="' . $customer_phone . '" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    <input type="submit" name="btnSave" value="Lưu thay đổi">
                                </td>
                            </tr>
                        </table>
                        <a href="/baiktracuoiky/dta/trangchu.php" class="btn-exit">Thoát</a>
                    </form>';
            } else {
                // Hiển thị thông tin cá nhân
                echo '<div class="info-box">
                        <h2>Thông tin cá nhân</h2>
                        <table>
                            <tr><td>Mã khách hàng:</td><td>' . $row['maKH'] . '</td></tr>
                            <tr><td>Họ tên:</td><td>' . $row['hoTen'] . '</td></tr>
                            <tr><td>Ngày sinh:</td><td>' . $row['ngaySinh'] . '</td></tr>
                            <tr><td>Địa chỉ:</td><td>' . $row['diaChi'] . '</td></tr>
                            <tr><td>Giới tính:</td><td>' . ($row['gioiTinh'] ? 'Nam' : 'Nữ') . '</td></tr>
                            <tr><td>Email:</td><td>' . $row['Email'] . '</td></tr>
                            <tr><td>SĐT:</td><td>' . $customer_phone . '</td></tr>
                        </table>
                        <a href="?edit=true" class="btn-exit">Chỉnh sửa</a>
                        <a href="/baiktracuoiky/dta/trangchu.php" class="btn-exit">Thoát</a>
                    </div>';
            }
        } else {
            // Hiển thị form nhập thông tin mới
            $maKH = generateUniqueCustomerId($conn);
            echo '<form method="POST">
                    <h2>Nhập thông tin cá nhân</h2>
                    <table>
                        <tr>
                            <td>Mã khách hàng:</td>
                            <td><input type="text" name="txtmaKH" value="' . $maKH . '" readonly></td>
                        </tr>
                        <tr>
                            <td>Họ tên:</td>
                            <td><input type="text" name="txthoTen" required></td>
                        </tr>
                        <tr>
                            <td>Ngày sinh:</td>
                            <td><input type="date" name="dtpngaySinh" required></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ:</td>
                            <td><input type="text" name="txtdiaChi" required></td>
                        </tr>
                        <tr>
                            <td>Giới tính:</td>
                            <td>
                                <input type="radio" name="gioiTinh" value="1" checked> Nam
                                <input type="radio" name="gioiTinh" value="0"> Nữ
                            </td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="email" name="txtEmail" required></td>
                        </tr>
                        <tr>
                            <td>Sdt:</td>
                            <td><input type="tel" name="txtSdt" value="' . $customer_phone . '" readonly></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input type="submit" name="btnSave" value="Lưu thông tin">
                            </td>
                        </tr>
                    </table>
                    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-exit">Thoát</a>
                </form>';
        }

        if ($updateSuccess) {
            echo '<script>alert("Cập nhật thông tin thành công!");</script>';
        }

        // Đóng kết nối cơ sở dữ liệu
        $conn->close();
    ?>
</body>
</html>
