<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "webfastfood";
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Thông Tin Sản Phẩm</title>
    <style>
        /* Style for the form */
        .addInfoProduct {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            flex-direction: column;
        }

        .addInfoProduct form {
            max-width: 400px;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .addInfoProduct label {
            display: block;
            margin-bottom: 8px;
            margin-top: 8px;
        }

        .addInfoProduct input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .addInfoProduct input[type="file"] {
            margin-bottom: 15px;
        }

        .addInfoProduct input[type="submit"] {
            background-color: #c00000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 100%;
        }

        .addInfoProduct input[type="submit"]:hover {
            background-color: #7f0000;
        }

        /* Style for messages */
        .addInfoProduct p {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        /* Style for the back button */
        .addInfoProduct .back-button-container {
            background-color: #ccc;
            padding: 10px;
            border-radius: 4px;
            margin-top: 15px;
            text-align: center;
            cursor: pointer;
        }

        .addInfoProduct .back-button-container a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="addInfoProduct">
    <form action="addProductInfo.php" method="post" enctype="multipart/form-data">

        <label for="nameIP">Tên Sản Phẩm:</label>
        <input type="text" id="nameIP" name="nameIP" required>

        <label for="descriptionIP">Mô Tả Sản Phẩm:</label>
        <textarea id="descriptionIP" name="descriptionIP" required></textarea>

        <label for="priceIP">Giá Sản Phẩm:</label>
        <input type="text" id="priceIP" name="priceIP" required>
        <label for="dateIP">Ngày Thêm:</label>
        <input type="datetime-local" id="dateIP" name="dateIP" required>
        <label for="idCP">Danh Mục:</label>
        <select id="idCP" name="idCP" required>
    <?php
    // Truy vấn danh sách danh mục từ bảng category_product
    $sqlCategories = "SELECT ID_CP, Name_CP FROM category_product";
    $resultCategories = $conn->query($sqlCategories);

    // Hiển thị danh sách danh mục trong dropdown
    while ($rowCategory = $resultCategories->fetch_assoc()) {
        echo '<option value="' . $rowCategory['ID_CP'] . '">' . $rowCategory['Name_CP'] . '</option>';
    }
    ?>
</select>

        <label for="srcIP">Ảnh sản phẩm:</label>
        <input type="file" id="srcIP" name="srcIP" accept="image/*" required>

        <input type="submit" value="Thêm" name="add_InfoProduct">
    </form>

    <?php
    // Xử lý thêm thông tin sản phẩm nếu có dữ liệu được gửi từ biểu mẫu
    if (isset($_POST['add_InfoProduct'])) {
        $nameIP = $_POST['nameIP'];
        $descriptionIP = $_POST['descriptionIP'];
        $priceIP = $_POST['priceIP'];
        $idCP = $_POST['idCP'];
        $dateIP = $_POST['dateIP'];
        // Xử lý upload ảnh cho Src Sản Phẩm
        $srcIPPath = '';
        if ($_FILES['srcIP']['error'] == 0) {
            $srcIPPath = 'pic_product/' . $_FILES['srcIP']['name'];
            move_uploaded_file($_FILES['srcIP']['tmp_name'], $srcIPPath);
        }

        // Tạo ID tự động dạng IP_
        $sqlGetMaxID = "SELECT MAX(CAST(SUBSTRING(ID_IP, 3) AS SIGNED)) as maxID FROM infor_product";
        $resultMaxID = $conn->query($sqlGetMaxID);
        $rowMaxID = $resultMaxID->fetch_assoc();
        $maxID = $rowMaxID['maxID'];
        $currentID = $maxID + 1;
        $newID = "IP" . $currentID;

        // Thực hiện thêm thông tin sản phẩm vào cơ sở dữ liệu
        $sql = "INSERT INTO infor_product (ID_IP, Name_IP, Description_IP, Price_IP, ID_CP, src_IP, Date_IP) VALUES ('$newID', '$nameIP', '$descriptionIP', '$priceIP', '$idCP', '$srcIPPath', '$dateIP')";
        $result = $conn->query($sql);

        if ($result) {
            echo '<p>Thêm Thông Tin Sản Phẩm thành công.</p>';
        } else {
            echo '<p style="color: red; text-align: center;">Lỗi khi thêm Thông Tin Sản Phẩm: ' . $conn->error . '</p>';
        }
    }
    ?>

    <div class="back-button-container">
        <a href="menu_Admin.php?category=product_info">Quay lại</a>
    </div>
</div>
</body>
</html>
