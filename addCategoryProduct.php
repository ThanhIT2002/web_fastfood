<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Danh Mục</title>
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
        .addCategory {
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
        }

        .back-button-container a {
            text-decoration: none; /* Loại bỏ gạch chân dưới đường link */
            color: #333; /* Màu văn bản đen */
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="addCategory">
    <div class="tittle_addCategory">
        <h2>Nhập thông tin để thêm danh mục mới </h2>
    </div>
    <div class="content_addCategory">
        <form action="addCategoryProduct.php" method="post" enctype="multipart/form-data">
            <label for="nameCP">Tên Danh Mục:</label>
            <input type="text" id="nameCP" name="nameCP" required><br>

            <label for="srcCP">Ảnh danh mục:</label>
            <input type="file" id="srcCP" name="srcCP" accept="image/*"><br>

            <label for="srcButton">Đường dẫn của danh mục:</label>
            <input type="text" id="srcButton" name="srcButton" required><br>

            <input type="submit" value="Thêm" name="addCategory">
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

        // Xử lý thêm danh mục nếu có dữ liệu được gửi từ biểu mẫu
        if (isset($_POST['addCategory'])) {
            $nameCP = $_POST['nameCP'];

            // Xử lý upload ảnh cho Src Danh Mục
            $srcCPPath = '';
            if ($_FILES['srcCP']['error'] == 0) {
                $srcCPPath = 'pic_category/' . $_FILES['srcCP']['name'];
                move_uploaded_file($_FILES['srcCP']['tmp_name'], $srcCPPath);
            }

            $srcButton = $_POST['srcButton'];

            // Tạo ID tự động dạng CP_
            $sqlGetMaxID = "SELECT MAX(CAST(SUBSTRING(ID_CP, 4) AS SIGNED)) as maxID FROM category_product";
            $resultMaxID = $conn->query($sqlGetMaxID);
            $rowMaxID = $resultMaxID->fetch_assoc();
            $maxID = $rowMaxID['maxID'];
            $currentID = $maxID + 1;
            $newID = "CP_" . $currentID;
            // Thực hiện thêm danh mục vào cơ sở dữ liệu
            $sql = "INSERT INTO category_product (ID_CP, Name_CP, Src_CP, Src_button) VALUES ('$newID', '$nameCP', '$srcCPPath', '$srcButton')";
            $result = $conn->query($sql);

            if ($result) {
                echo '<p style="color: green; text-align: center;">Thêm Danh Mục thành công.</p>';
            } else {
                echo '<p style="color: red; text-align: center;">Lỗi khi thêm Danh Mục: ' . $conn->error . '</p>';
            }
        }
        ?>
    </div>

    <div class="back-button-container">
        <a href="home_Admin.php?category=category_product">Quay lại</a>
    </div>
</div>
</body>
</html>
