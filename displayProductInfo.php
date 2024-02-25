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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addProductInfo'])) {
    echo"<script>window.location.href='addProductInfo.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển thị Thông tin Sản phẩm</title>
    <style>
        /* Style for the table */
        .display_product_info table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .display_product_info table,
        th,
        td {
            border: 1px solid #ddd;
        }

        .display_product_info th,
        td {
            padding: 10px;
            text-align: left;
        }

        .display_product_info th {
            background-color: #f2f2f2;
        }

        /* Style for form inputs and buttons */
        .display_product_info form input[type="text"] {
            width: 100%;
            height: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
            overflow-wrap: break-word;
            white-space: normal;
            writing-mode: horizontal-tb;
        }

        .display_product_info form input[type="submit"] {
            background-color: #c00000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
            width: 115px;
        }
        .display_product_info form textarea {
            width: 100%;
            height: 100px; 
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow-wrap: break-word;
            white-space: normal;
            writing-mode: horizontal-tb;
        }
        .display_product_info form input[type="submit"]:hover {
            background-color: #7f0000;
        }
        .display_product_info td input[type="text"] {
            white-space: pre-line;
        }
        .display_product_info select {
            width:140px;
        }
        .display_product_info form .img-preview {
            max-width: 100px; /* Đặt chiều rộng tối đa của ảnh */
            height: auto; /* Để giữ tỷ lệ khung hình */
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="display_product_info">
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'editProductInfo_') === 0) {
                    $idIP = substr($key, strlen('editProductInfo_'));
                    $nameIP = $_POST['name_ip_' . $idIP];
                    $descriptionIP = $_POST['description_ip_' . $idIP];
                    $priceIP = $_POST['price_ip_' . $idIP];
                    $idCP = $_POST['id_cp_' . $idIP];
                    $dateIP = date('Y-m-d H:i:s', strtotime($_POST['date_ip_' . $idIP]));
                    $result_src = "";
                    if ($_FILES['ChangePicture_' . $idIP]['size'] > 0) {
                        $target_dir = "pic_banner/";
                        $target_file = $target_dir . basename($_FILES["ChangePicture_" . $idIP]["name"]);
        
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                            move_uploaded_file($_FILES["ChangePicture_" . $idIP]["tmp_name"], $target_file);
                            $srcIP = $target_file; // Cập nhật đường dẫn ảnh mới
                        } else {
                            echo '<p>Chỉ chấp nhận file ảnh có định dạng JPG, JPEG, PNG, GIF.</p>';
                        }
                        $sql_src = "UPDATE infor_product SET src_IP='$srcIP' WHERE ID_IP='$idIP'";
                        $result_src = $conn->query($sql_src);
                    }


                    // Thực hiện sửa thông tin sản phẩm trong cơ sở dữ liệu
                    $sql = "UPDATE infor_product SET Name_IP='$nameIP',Date_IP='$dateIP', Description_IP='$descriptionIP', Price_IP='$priceIP', ID_CP='$idCP' WHERE ID_IP='$idIP'";
                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<p>Sửa thông tin sản phẩm thành công.</p>';
                    } else {
                        echo '<p>Lỗi khi sửa thông tin sản phẩm: ' . $conn->error . '</p>';
                    }
                } elseif (strpos($key, 'deleteProductInfo_') === 0) {
                    $idIP = substr($key, strlen('deleteProductInfo_'));

                    $sql = "DELETE FROM infor_product WHERE ID_IP='$idIP'";
                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<p>Xóa thông tin sản phẩm thành công.</p>';
                    } else {
                        echo '<p>Lỗi khi xóa thông tin sản phẩm: ' . $conn->error . '</p>';
                    }
                }
            }
        }

        // Lấy dữ liệu từ bảng infor_product
        $sql = "SELECT * FROM infor_product";
        $result = $conn->query($sql);

        echo '<form method="post" enctype="multipart/form-data">';
        echo '<input type="submit" name="addProductInfo" value="Thêm">';
        echo '<table>';
        echo '<tr><th>ID</th><th>Tên sản phẩm</th><th>Mô tả</th><th>Giá </th><th>Danh mục</th><th>Ngày thêm</th><th>Ảnh sản phẩm </th><th>Thao tác</th></tr>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Truy vấn SQL để lấy tên từ bảng category_product
                $categoryResult = $conn->query("SELECT ID_CP, Name_CP FROM category_product");
                $categories = $categoryResult->fetch_all(MYSQLI_ASSOC);
        
                echo '<tr>';
                echo '<td> <input type="text" name="id_ip_' . $row['ID_IP'] . '" value="' . $row['ID_IP'] . '" size="2px"></td>';
                echo '<td> <input type="text" name="name_ip_' . $row['ID_IP'] . '" value="' . $row['Name_IP'] . '" size="15px"></td>';
                echo '<td> <textarea name="description_ip_' . $row['ID_IP'] . '">' . $row['Description_IP'] . '</textarea></td>';
                echo '<td> <input type="text" name="price_ip_' . $row['ID_IP'] . '" value="' . $row['Price_IP'] . '" size="10px"></td>';
                echo '<td>';
                echo '<select name="id_cp_' . $row['ID_IP'] . '">';
                foreach ($categories as $category) {
                    echo '<option value="' . $category['ID_CP'] . '"';
                    if ($category['ID_CP'] == $row['ID_CP']) {
                        echo ' selected';
                    }
                    echo '>' . $category['Name_CP'] . '</option>';
                }
                echo '</select>';
                echo '</td>';
                echo '<td><textarea name="date_ip_' . $row['ID_IP'] . '">' . $row['Date_IP'] . '</textarea></td>';
                echo '<td>';
                echo '<img class="img-preview" src="' . $row['src_IP'] . '" alt="Category Image">';
                echo '<input type="file" name="ChangePicture_' . $row['ID_IP'] . '" accept="image/*">';
                echo '</td>';
                echo '<td>
                        <input type="submit" name="editProductInfo_' . $row['ID_IP'] . '" value="Sửa">
                        <input type="submit" name="deleteProductInfo_' . $row['ID_IP'] . '" value="Xóa">
                      </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7">Không có dữ liệu</td></tr>';
        }

        echo '</table>';
        echo '</form>';
        $conn->close();
        ?>
    </div>
</body>

</html>
