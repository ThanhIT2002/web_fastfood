<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "webfastfood";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addCategoryProduct'])) {
    echo"<script>window.location.href='addCategoryProduct.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí danh mục</title>
    <style>     
        .display_cate table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .display_cate table, th, td {
            border: 1px solid #ddd;
        }

        .display_cate th, td {
            padding: 10px;
            text-align: left;
        }

        .display_cate th {
            background-color: #f2f2f2;
        }

        .display_cate form input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: none; 
            border-radius: 4px;
        }

        .display_cate form input[type="submit"] {
            background-color: #c00000; 
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px; 
            cursor: pointer;
            margin-right: 5px;
        }

        .display_cate form input[type="submit"]:hover {
            background-color: #7f0000;
        }

        .display_cate p {
            color: #c00000;
            font-weight: bold;
            margin-top: 10px;
        }
        .display_cate form .img-preview {
            max-width: 100px; /* Đặt chiều rộng tối đa của ảnh */
            height: auto; /* Để giữ tỷ lệ khung hình */
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>
<body>
<div class="display_cate">
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'editCategoryProduct_') === 0) {
                $idCP = substr($key, strlen('editCategoryProduct_'));
                $nameCP = $_POST['nameCP_' . $idCP];
                $srcButton = $_POST['srcButton_' . $idCP];
                $result_src="";
                if ($_FILES['ChangePicture_' . $idCP]['size'] > 0) {
                    $target_dir = "pic_banner/";
                    $target_file = $target_dir . basename($_FILES["ChangePicture_" . $idCP]["name"]);
    
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                        move_uploaded_file($_FILES["ChangePicture_" . $idCP]["tmp_name"], $target_file);
                        $srcCP = $target_file; // Cập nhật đường dẫn ảnh mới
                    } else {
                        echo '<p>Chỉ chấp nhận file ảnh có định dạng JPG, JPEG, PNG, GIF.</p>';
                    }
                    $sql_src = "UPDATE category_product SET Src_CP='$srcCP' WHERE ID_CP='$idCP'";
                    $result_src = $conn->query($sql_src);
                }
               


                // Thực hiện sửa Category Product trong cơ sở dữ liệu
                $sql = "UPDATE category_product SET Name_CP='$nameCP',Src_button='$srcButton' WHERE ID_CP='$idCP'";
                $result = $conn->query($sql);

                if ($result || $result_src) {
                    echo '<p>Sửa danh mục thành công.</p>';
                } else {
                    echo '<p>Lỗi khi sửa Category Product: ' . $conn->error . '</p>';
                }
            } elseif (strpos($key, 'deleteCategoryProduct_') === 0) {
                $idCP = substr($key, strlen('deleteCategoryProduct_'));

                // Thực hiện xóa Category Product trong cơ sở dữ liệu
                $sql = "DELETE FROM category_product WHERE ID_CP='$idCP'";
                $result = $conn->query($sql);

                if ($result) {
                    echo '<p>Xóa Category Product thành công.</p>';
                } else {
                    echo '<p>Lỗi khi xóa Category Product: ' . $conn->error . '</p>';
                }
            }
        }
    }

    $sql = "SELECT * FROM category_product";
$result = $conn->query($sql);

echo '<form method="post" enctype="multipart/form-data">';
echo '<input type="submit" name="addCategoryProduct" value="Thêm" >';
echo '<table>';
echo '<tr><th>ID</th><th>Tên danh mục</th><th>Ảnh danh mục</th><th>Link danh mục</th><th>Thao tác</th></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td> <input type="text" name="idCP_' . $row['ID_CP'] . '" value="' . $row['ID_CP'] . '" size="4px"></td>';
        echo '<td> <input type="text" name="nameCP_' . $row['ID_CP'] . '" value="' . $row['Name_CP'] . '" size="21px"></td>';
        echo '<td>';
        echo '<img class="img-preview" src="' . $row['Src_CP'] . '" alt="Category Image">';
        echo '<input type="file" name="ChangePicture_' . $row['ID_CP'] . '" accept="image/*">';
        echo '</td>';
        echo '<td> <input type="text" name="srcButton_' . $row['ID_CP'] . '" value="' . $row['Src_button'] . '" size="30px"></td>';
        echo '<td>
                    <input type="submit" name="editCategoryProduct_' . $row['ID_CP'] . '" value="Sửa">
                    <input type="submit" name="deleteCategoryProduct_' . $row['ID_CP'] . '" value="Xóa">
              </td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">Không có dữ liệu</td></tr>';
}

echo '</table>';
echo '</form>';
$conn->close();
    ?>
</div>
</body>
</html>
