<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Banner</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* 100% chiều cao của viewport */
            margin: 0;
            background-color: #f2f2f2; /* Màu xám nhạt cho nền */
            font-family: Arial, sans-serif;
            flex-direction: column;
        }
        .addBanner{
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #c00000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #7f0000;
        }

        .back-button-container {
            background-color: #ccc; /* Màu xám cho nền */
            padding: 10px; /* Khoảng cách giữa nút và viền nền */
            border-radius: 4px; /* Góc bo tròn */
            margin-top: 15px; /* Khoảng cách giữa form và nút */
            text-align: center;
            cursor: pointer;
        }

        .back-button-container a {
            text-decoration: none; /* Loại bỏ gạch chân dưới đường link */
            color: #333; /* Màu văn bản đen */
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="addBanner">
<div class="tittle_addBanner">
    <h2>Nhập thông tin để thêm banner mới </h2>
</div>
<div class="content_addBanner">
<form action="addBanner.php" method="post" enctype="multipart/form-data">

    <label for="NameBanner">Tên của ảnh:</label>
    <input type="text" id="NameBanner" name="NameBanner" required>
    <label for="image">Ảnh:</label>
    <input type="file" id="image" name="image" accept="image/*"  required>
    
    <label for="hrefBanner">Link của ảnh:</label>
    <input type="text" id="hrefBanner" name="hrefBanner" required>

    <input type="submit" value="Thêm" name="add_Banner">
</form>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "webfastfood";
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
// Xử lý thêm Banner nếu có dữ liệu được gửi từ biểu mẫu
if (isset($_POST['add_Banner'])) {
    $hrefBanner = trim($_POST['hrefBanner']);
    $NameBanner = trim($_POST['NameBanner']);
    // Xử lý upload ảnh
    $imagePath = ''; // Đường dẫn tới thư mục lưu trữ ảnh
    if ($_FILES['image']['error'] == 0) {
        $imagePath = 'pic_banner/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }
    // Thực hiện thêm Banner vào cơ sở dữ liệu
    $sql = "INSERT INTO banners (Name_Banner,src_Banner, href_Banner) VALUES ('$NameBanner','$imagePath', '$hrefBanner')";
    $result = $conn->query($sql);

    if ($result) {
        echo '<script>alert("Thêm Banner thành công.");</script>';
    } else {
        echo '<script>alert("SLỗi khi thêm Banner: ' . $conn->error . '");</script>';
    }
}
?>

</div>


<div class="back-button-container">
    <a href="home_Admin.php?category=banners">Quay lại</a>
</div>

</div>
</body>
</html>
