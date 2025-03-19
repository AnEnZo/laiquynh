<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slideshow</title>
    <style>
        * {box-sizing: border-box}
        body {font-family: Verdana, sans-serif; margin:0}
        .slideshow-container {
            position: relative;
            margin: auto;
            overflow: hidden; /* Đảm bảo chỉ hiển thị một slide tại một thời điểm */
        }
        .mySlides {
            display: none;
            transition: opacity 1s ease; /* Hiệu ứng transition cho chuyển tiếp */
        }
        .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 1.5s;
            animation-name: fade;
            animation-duration: 1.5s;
        }
        @-webkit-keyframes fade {
            from {opacity: .4} 
            to {opacity: 1}
        }
        @keyframes fade {
            from {opacity: .4} 
            to {opacity: 1}
        }
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }
        .prev:hover, .next:hover {
            background-color: rgba(0,0,0,0.8);
        }
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }
        .active, .dot:hover {
            background-color: #717171;
        }
    </style>
</head>
<body>

<div class="slideshow-container">
    <?php
    // Kết nối tới cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "quanlyquancafe1","3307");

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Thực hiện truy vấn
    $sql = "SELECT url FROM tblimgslideshow";
    $result = $conn->query($sql);

    // Hiển thị ảnh
    if ($result->num_rows > 0) {
        $index = 1;
        while ($row = $result->fetch_assoc()) {
            echo '<div class="mySlides fade">';
            echo '<img src="' . htmlspecialchars($row["url"]) . '" style="width:100%">';
            echo '</div>';
            $index++;
        }
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>

    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
    <?php
    // Kết nối lại để lấy số lượng ảnh
    $conn = new mysqli("localhost", "root", "", "quanlyquancafe1","3307");

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Thực hiện truy vấn
    $sql = "SELECT COUNT(*) as count FROM tblimgslideshow";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        for ($i = 1; $i <= $count; $i++) {
            echo '<span class="dot" onclick="currentSlide(' . $i . ')"></span> ';
        }
    }

    $conn->close();
    ?>
</div>

<script>
let slideIndex = 0;
showSlides();

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");

  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }

  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }

  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}

// Pause slideshow when hovering over
let slideshowContainer = document.querySelector('.slideshow-container');

slideshowContainer.addEventListener('mouseenter', function() {
  clearInterval(interval);
});

slideshowContainer.addEventListener('mouseleave', function() {
  interval = setInterval(showSlides, 2000);
});

// Start slideshow
let interval = setInterval(showSlides, 2000);
</script>

</body>
</html>
