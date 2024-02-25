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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addUserInfo'])) {
    echo"<script>window.location.href='addUser.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển thị Thông tin Người Dùng</title>
    <style>
        /* Style for the table */
        .display_user_info table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .display_user_info table,
        th,
        td {
            border: 1px solid #ddd;
        }

        .display_user_info th,
        td {
            padding: 10px;
            text-align: left;
        }

        .display_user_info th {
            background-color: #f2f2f2;
        }

        /* Style for form inputs and buttons */
        .display_user_info form input[type="text"] {
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

        .display_user_info form input[type="submit"] {
            background-color: #c00000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .display_user_info form input[type="submit"]:hover {
            background-color: #7f0000;
        }

        /* Allow long content to break and wrap onto the next line */
        .display_user_info td input[type="text"] {
            white-space: pre-line;
        }
    </style>
</head>

<body>
    <div class="display_user_info">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'editUserInfo_') === 0) {
                    $idCus = substr($key, strlen('editUserInfo_'));
                    $userNameCus = $_POST['username_cus_' . $idCus];
                    $passwordCus = $_POST['password_cus_' . $idCus];
                    $fullNameCus = $_POST['fullname_cus_' . $idCus];
                    $ageCus = $_POST['age_cus_' . $idCus];
                    $addressCus = $_POST['address_cus_' . $idCus];
                    $phoneCus = $_POST['phone_cus_'.$idCus];
                    $emailCus = $_POST['email_cus_'.$idCus];
                    // Thực hiện sửa thông tin người dùng trong cơ sở dữ liệu
                    $sql = "UPDATE infor_customer SET UserName_Cus='$userNameCus', PassWord_Cus='$passwordCus', FullName_Cus='$fullNameCus', Age_Cus='$ageCus', Address_Cus='$addressCus', Email_Cus='$emailCus', Phone_Cus='$phoneCus' WHERE ID_Cus='$idCus'";
                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<script>alert("Sửa thành công");</script>';
                    } else {
                        echo '<p>Lỗi khi sửa thông tin người dùng: ' . $conn->error . '</p>';
                    }
                } elseif (strpos($key, 'deleteUserInfo_') === 0) {
                    $idCus = substr($key, strlen('deleteUserInfo_'));

                    $sql = "DELETE FROM infor_customer WHERE ID_Cus='$idCus'";
                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<script>alert("Xóa thành công");</script>';
                    } else {
                        echo '<p>Lỗi khi xóa thông tin người dùng: ' . $conn->error . '</p>';
                    }
                }
            }
        }

        // Lấy dữ liệu từ bảng infor_customer
        $sql = "SELECT * FROM infor_customer";
        $result = $conn->query($sql);

        echo '<form method="post">';
        echo '<input type="submit" name="addUserInfo" value="Thêm">';
        echo '<table>';
        echo '<tr><th>ID</th><th>Tài khoản</th><th>Mật khẩu</th><th>Họ tên</th><th>Email</th><th>Số điện thoại</th><th>Tuổi</th><th>Địa chỉ</th><th>Thao tác</th></tr>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td> <input type="text" name="id_cus_' . $row['ID_Cus'] . '" value="' . $row['ID_Cus'] . '" size="2px"></td>';
                echo '<td> <input type="text" name="username_cus_' . $row['ID_Cus'] . '" value="' . $row['UserName_Cus'] . '" size="10px"></td>';
                echo '<td> <input type="text" name="password_cus_' . $row['ID_Cus'] . '" value="' . $row['PassWord_Cus'] . '" size="2px"></td>';
                echo '<td> <input type="text" name="fullname_cus_' . $row['ID_Cus'] . '" value="' . $row['FullName_Cus'] . '"></td>';
                echo '<td> <input type="text" name="email_cus_' . $row['ID_Cus'] . '" value="' . $row['Email_Cus'] . '"></td>';
                echo '<td> <input type="text" name="phone_cus_' . $row['ID_Cus'] . '" value="' . $row['Phone_Cus'] . '" size="2px"></td>';
                echo '<td> <input type="text" name="age_cus_' . $row['ID_Cus'] . '" value="' . $row['Age_Cus'] . '" size="2px"></td>';
                echo '<td> <input type="text" name="address_cus_' . $row['ID_Cus'] . '" value="' . $row['Address_Cus'] . '"size="7px"></td>';
                
                echo '<td>
                        <input type="submit" name="editUserInfo_' . $row['ID_Cus'] . '" value="Sửa">
                        <input type="submit" name="deleteUserInfo_' . $row['ID_Cus'] . '" value="Xóa">
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
