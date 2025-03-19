<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa đổi đồ ăn</title>
    <link rel="stylesheet" href="../css/sua.css">
</head>

<body>

    <?php
    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1','3307');
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    // Lấy mã sản phẩm từ URL
    if (isset($_GET['ID'])) {
        $masp = mysqli_real_escape_string($conn, $_GET['ID']);

        // Truy vấn để lấy thông tin sản phẩm cần sửa
        $sql = "SELECT * FROM tbl_douong WHERE masp = '$masp'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    ?>

            <form method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <h2>Sửa đổi đồ uống</h2>
                        <td>Mã sản phẩm:</td>
                        <td>
                            <input type="text" name="masp" value="<?php echo $row['masp']; ?>" readonly><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>Tên sản phẩm:</td>
                        <td>
                            <input type="text" name="tensp" value="<?php echo $row['tensp']; ?>" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>Nhà cung cấp:</td>
                        <td>
                            <input type="text" name="ncc" value="<?php echo $row['ncc']; ?>" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>Hình ảnh hiện tại:</td>
                        <td>
                            <img src="<?php echo $row['linkimg']; ?>" width="100"><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>Hình ảnh mới:</td>
                        <td>
                            <input type="file" name="linkimg"><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>Giá bán:</td>
                        <td>
                            <input type="number" name="giaban" step="0.01" value="<?php echo $row['giaban']; ?>" required><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Cập nhật" name="update">
                        </td>
                    </tr>
                </table>
                <a href="/baiktracuoiky/dta/trangchu.php" class="btn-exit">Quay lại</a>
            </form>

    <?php
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
    }

    // Xử lý khi người dùng nhấn nút Cập nhật
    if (isset($_POST["update"])) {
        $masp = mysqli_real_escape_string($conn, $_POST['masp']);
        $tensp = mysqli_real_escape_string($conn, $_POST['tensp']);
        $ncc = mysqli_real_escape_string($conn, $_POST['ncc']);
        $giaban = mysqli_real_escape_string($conn, $_POST['giaban']);

        // Xử lý hình ảnh mới nếu có
        if ($_FILES["linkimg"]["size"] > 0) {
            $target_dir = "/baiktracuoiky/SanPham-hoan/SP/Do_uong/"; // Đường dẫn tương đối
            $target_file = $target_dir . basename($_FILES["linkimg"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Kiểm tra và xử lý hình ảnh
            $check = getimagesize($_FILES["linkimg"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "<script>alert('File không phải là hình ảnh.');</script>";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["linkimg"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                    $linkimg = mysqli_real_escape_string($conn, $target_file);

                    // Xóa hình ảnh cũ
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $row['linkimg'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . $row['linkimg']);
                    }
                } else {
                    echo "<script>alert('Xin lỗi, đã xảy ra lỗi khi tải lên hình ảnh mới.');</script>";
                    $linkimg = $row['linkimg']; // Giữ nguyên link hình ảnh cũ nếu không tải lên được mới
                }
            } else {
                $linkimg = $row['linkimg']; // Giữ nguyên link hình ảnh cũ nếu không tải lên được mới
            }
        } else {
            $linkimg = $row['linkimg']; // Giữ nguyên link hình ảnh cũ nếu không có hình mới
        }

        // Cập nhật thông tin sản phẩm vào cơ sở dữ liệu
        $sql_update = "UPDATE tbl_douong SET tensp='$tensp', ncc='$ncc', giaban='$giaban', linkimg='$linkimg' WHERE masp='$masp'";

        if (mysqli_query($conn, $sql_update)) {
            echo "<script>alert('Sản phẩm đã được cập nhật thành công'); window.location.href='do_uong.php';</script>";
        } else {
            echo "<script>alert('Lỗi: " . $sql_update . "<br>" . mysqli_error($conn) . "');</script>";
        }
    }

    mysqli_close($conn);
    ?>
</body>

</html>
