<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .dropdown-container {
            background-color: black;
            padding: 10px;
            border-radius: 5px;
            display: block;
        }
        .dropdown {
            position: relative;
            display: inline-block;
            margin-right: 20px;
        }
        .dropbtn {
            background-color: transparent;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .mySlides img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<?php
// Tạo kết nối
$conn = new mysqli("localhost", "root", "", "quanlyquancafe1", "3307");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Thực hiện truy vấn
$sql = "SELECT name, type, link FROM tblmenu";
$result = $conn->query($sql);

$dropbuttons = array();
$dropcontents = array();
if ($result->num_rows > 0) {
    // Lấy dữ liệu từ mỗi hàng
    while($row = $result->fetch_assoc()) {
        if ($row["type"] == -1) {
            $dropbuttons[] = array("name" => $row["name"], "link" => $row["link"]);
        } else {
            $dropcontents[$row["type"]][] = array("name" => $row["name"], "link" => $row["link"]);
        }
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<div class="dropdown-container">
    <?php foreach($dropbuttons as $button): ?>
        <div class="dropdown">
            <a class="dropbtn" href="<?php echo htmlspecialchars($button["link"]); ?>"><?php echo htmlspecialchars($button["name"]); ?></a>
            <div class="dropdown-content">
                <?php if (isset($dropcontents[$button["name"]])): ?>
                    <?php foreach($dropcontents[$button["name"]] as $content): ?>
                        <a href="<?php echo htmlspecialchars($content["link"]); ?>"><?php echo htmlspecialchars($content["name"]); ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
