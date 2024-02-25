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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addBanner'])) {
    echo"<script>window.location.href='addBanner.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí banner</title>
    <style>
        /* Style for the table */
        .display_banner table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .display_banner table, th, td {
            border: 1px solid #ddd;
        }

        .display_banner th, td {
            padding: 10px;
            text-align: left;
        }

        .display_banner th {
            background-color: #f2f2f2;
        }

        /* Style for form inputs and buttons */
        .display_banner form input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: none; 
            border-radius: 4px;
        }


        /* Optional: Style for messages */
        .display_banner p {
            color: #c00000;
            font-weight: bold;
            margin-top: 10px;
        }
        .display_banner form input[type="submit"] {
                background-color: #c00000; 
                color: white;
                padding: 10px 15px;
                border: none;
                border-radius: 4px; 
                cursor: pointer;
                margin-right: 5px;
            }

            .display_banner form input[type="submit"]:hover {
                background-color: #7f0000;
            }
            .display_banner form .img-preview {
                    max-width: 100px; /* Đặt chiều rộng tối đa của ảnh */
                    height: auto; /* Để giữ tỷ lệ khung hình */
                    margin-bottom: 10px;
                    display: block;
                }
    </style>
    <script>
        function confirmAction(action) {
            return confirm('Bạn có chắc chắn muốn ' + action + ' Banner không?');
        }
    </script>
</head>
<body>
<div class="display_banner">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'editBanner_') === 0) {
            $maBanner = substr($key, strlen('editBanner_'));
            $hrefBanner = $_POST['hrefBanner_' . $maBanner];
            $NameBanner = $_POST['NameBanner_' . $maBanner];
            $result_src ="";
            // Nếu có file ảnh được chọn, thực hiện cập nhật ảnh
            if ($_FILES['ChangePicture_' . $maBanner]['size'] > 0) {
                $target_dir = "pic_banner/";
                $target_file = $target_dir . basename($_FILES["ChangePicture_" . $maBanner]["name"]);

                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                    move_uploaded_file($_FILES["ChangePicture_" . $maBanner]["tmp_name"], $target_file);
                    $srcBanner = $target_file; // Cập nhật đường dẫn ảnh mới
                } else {
                    echo '<p>Chỉ chấp nhận file ảnh có định dạng JPG, JPEG, PNG, GIF.</p>';
                }
                $sql_src = "UPDATE banners SET src_Banner='$srcBanner' WHERE MaBanner='$maBanner'";
                $result_src = $conn->query($sql_src);
            }
            // Thực hiện sửa Banner trong cơ sở dữ liệu
            $sql_href = "UPDATE banners SET href_Banner='$hrefBanner',Name_Banner = '$NameBanner' WHERE MaBanner='$maBanner'";
            $result_href= $conn->query($sql_href);

            if ($result_href ||  $result_src ) {
                echo '<script>alert("Sửa Banner thành công.");</script>';
            } else {
                echo '<script>alert("Lỗi khi sửa Banner: ' . $conn->error . '");</script>';
            }
        }  elseif (strpos($key, 'deleteBanner_') === 0) {
            $maBanner = substr($key, strlen('deleteBanner_'));

            $sql = "DELETE FROM banners WHERE MaBanner='$maBanner'";
            $result = $conn->query($sql);

            if ($result) {
                echo '<script>alert("Xóa Banner thành công.");</script>';
            } else {
                echo '<p>Lỗi khi xóa Banner: ' . $conn->error . '</p>';
            }
        }
    }
}

// Hiển thị dữ liệu trong bảng
$sql = "SELECT * FROM banners";
$result = $conn->query($sql);
echo '<form method="post" enctype="multipart/form-data">';
echo '<input type="submit" name="addBanner" value="Thêm">';
echo '<table>';
echo '<tr><th>ID</th><th>Tên của ảnh</th><th>Ảnh</th><th>Link của banner</th><th>Thao tác</th></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td> <input type="text" name="maBanner_' . $row['MaBanner'] . '" value="' . $row['MaBanner'] . '" size="10px"></td>';
        echo '<td> <input type="text" name="NameBanner_' . $row['MaBanner'] . '" value="' . $row['Name_Banner'] . '" ></td>';
        echo '<td>';
        echo '<img class="img-preview" src="' . $row['src_Banner'] . '" alt="Banner Image">';
        echo '<input type="file" name="ChangePicture_' . $row['MaBanner'] . '" accept="image/*">';
        echo '</td>';
        echo '<td> <input type="text" name="hrefBanner_' . $row['MaBanner'] . '" value="' . $row['href_Banner'] . '"></td>';
        echo '<td>
                <input type="submit" name="editBanner_' . $row['MaBanner'] . '" value="Sửa" onclick="return confirmAction(\'sửa\');">
                <input type="submit" name="deleteBanner_' . $row['MaBanner'] . '" value="Xóa" onclick="return confirmAction(\'xóa\');">
              </td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">Không có dữ liệu</td></tr>';
}

echo '</table>';
echo '</form>';
$conn->close();
?>
 </div>
</body>
</html>
