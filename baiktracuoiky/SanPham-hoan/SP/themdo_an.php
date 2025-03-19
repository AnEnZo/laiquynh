<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm đồ ăn mới </title>
    <link rel="stylesheet" href="../css/them.css">

</head>

<body>

    <form method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <h2>Thêm đồ ăn mới</h2>
                </td>
                <td>Mã sản phẩm:</td>
                <td>
                    <?php
                    function generateRandomNumber()
                    {
                        $characters = '123456';
                        $randomString = '';
                        for ($i = 0; $i < 6; $i++) {
                            $randomString .= $characters[rand(0, strlen($characters) - 1)];
                        }
                        return $randomString;
                    }
                    $masp = generateRandomNumber();
                    ?>
                    <input type="text" name="masp" value="<?php echo $masp; ?>" readonly><br><br>
                </td>
            </tr>
            <tr>
                <td>Tên sản phẩm:</td>
                <td>
                    <input type="text" name="tensp" required><br><br>
                </td>
            </tr>
            <tr>
                <td>Nhà cung cấp:</td>
                <td>
                    <input type="text" name="ncc" required><br><br>
                </td>
            </tr>
            <tr>
                <td>Hình ảnh:</td>
                <td>
                    <input type="file" name="linkimg" required><br><br>
                </td>
            </tr>
            <tr>
                <td>Giá bán:</td>
                <td>
                    <input type="number" name="giaban" step="0.01" required><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Tải lên" name="submit">
                </td>
            </tr>
        </table>
        <a href="/baiktracuoiky/dta/trangchu.php" class="btn-exit">Quay lại</a>
    </form>
    <?php
    if (isset($_POST["submit"])) {
        $target_dir = "C:/xampp/htdocs/baiktracuoiky/SanPham-hoan/SP/Do_an/";
        $target_file = $target_dir . basename($_FILES["linkimg"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "<script>alert('Xin lỗi, tệp đã tồn tại.');</script>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["linkimg"]["size"] > 500000) {
            echo "<script>alert('Xin lỗi, tệp của bạn quá lớn.');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>alert('Xin lỗi, chỉ các tệp JPG, JPEG, PNG & GIF được cho phép.');</script>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>alert('Xin lỗi, tệp của bạn không được tải lên.');</script>";
        } else {
            // Create directory if it doesn't exist
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true); // Create directory if it doesn't exist
            }

            if (move_uploaded_file($_FILES["linkimg"]["tmp_name"], $target_file)) {
                echo "<script>alert('Tệp " . basename($_FILES["linkimg"]["name"]) . " đã được tải lên.');</script>";

                // Connect to database and save product information
                $conn = mysqli_connect('localhost', 'root', '', 'quanlyquancafe1','3307');
                if (!$conn) {
                    die("Kết nối thất bại: " . mysqli_connect_error());
                }

                $masp = mysqli_real_escape_string($conn, $_POST['masp']);
                $tensp = mysqli_real_escape_string($conn, $_POST['tensp']);
                $ncc = mysqli_real_escape_string($conn, $_POST['ncc']);
                $giaban = mysqli_real_escape_string($conn, $_POST['giaban']);
                $linkimg = "/baiktracuoiky/SanPham-hoan/SP/Do_an/" . basename($target_file); // Use full path here

                $sql = "INSERT INTO tbl_doan (masp, tensp, ncc, giaban, linkimg)
                VALUES ('$masp','$tensp','$ncc', '$giaban', '$linkimg')";

                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Sản phẩm mới đã được thêm thành công'); window.location.href='do_an.php';</script>";
                } else {
                    echo "<script>alert('Lỗi: " . $sql . "<br>" . mysqli_error($conn) . "');</script>";
                }

                mysqli_close($conn);
            } else {
                echo "<script>alert('Xin lỗi, đã xảy ra lỗi khi tải lên tệp của bạn.');</script>";
            }
        }
    }
    ?>

</body>

</html>