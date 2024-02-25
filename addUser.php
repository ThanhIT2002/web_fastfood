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
    <title>Thêm Thông Tin Người Dùng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .addUserInfo {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
        }

        form {
            max-width: 400px;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"],
        input[type="tel"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #c00000;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #7f0000;
        }

        p {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        .back-button-container {
            background-color: #ccc;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
        }

        .back-button-container a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="addUserInfo">
    <form action="addUser.php" method="post">

    <table>
        <tr>
            <td><label for="userNameCus">Tên Người Dùng:</label></td>
            <td><input type="text" id="userNameCus" name="userNameCus" required></td>
        </tr>
        <tr>
            <td><label for="passWordCus">Mật Khẩu:</label></td>
            <td><input type="password" id="passWordCus" name="passWordCus" required></td>
        </tr>
        <tr>
            <td><label for="confirmPassWordCus">Xác Nhận Mật Khẩu:</label></td>
            <td><input type="password" id="confirmPassWordCus" name="confirmPassWordCus" required></td>
        </tr>
        <tr>
            <td><label for="fullNameCus">Họ và Tên:</label></td>
            <td><input type="text" id="fullNameCus" name="fullNameCus" required></td>
        </tr>
        <tr>
                    <td><label for="phoneCus">Số Điện Thoại:</label></td>
                    <td><input type="tel" id="phoneCus" name="phoneCus" required></td>
                </tr>
                <tr>
                    <td><label for="emailCus">Email:</label></td>
                    <td><input type="email" id="emailCus" name="emailCus" required></td>
                </tr>
        <tr>
            <td><label for="ageCus">Tuổi:</label></td>
            <td><input type="text" id="ageCus" name="ageCus" required></td>
        </tr>
        <tr>
            <td><label for="addressCus">Địa Chỉ:</label></td>
            <td><input type="text" id="addressCus" name="addressCus" required></td>
        </tr>
        <tr>
            <td><label for="userRole">Chức Vụ:</label></td>
            <td>
                <select id="userRole" name="userRole" required>
                    <option value="customer">Khách Hàng</option>
                    <option value="admin">Quản Lý</option>
                </select>
            </td>
        </tr>
    </table>
        <input type="submit" value="Thêm" name="add_UserInfo">
    </form>
    <div class="back-button-container">
        <a href="contact_User.php?category=user">Quay lại</a>
    </div>
    <?php
    if (isset($_POST['add_UserInfo'])) {
        $username = $_POST["userNameCus"];
    // Kiểm tra xem tên người dùng đã tồn tại trong cơ sở dữ liệu chưa
    $checkUsernameQuery = "SELECT * FROM infor_customer WHERE UserName_Cus = '$username'";
    $result = $conn->query($checkUsernameQuery);

    if ($result->num_rows > 0) {
        echo '<script>alert("Tên người dùng đã tồn tại. Vui lòng chọn tên người dùng khác.");</script>';
    } else {
    $fullname = $_POST["fullNameCus"];
    $password = $_POST["passWordCus"];
    $confirm_password = $_POST["confirmPassWordCus"];
    $age = $_POST["ageCus"];
    $address = $_POST["addressCus"];
    $email = $_POST['$emailCus'];
    $phoneNumber = $_POST["phoneCus"];
        if (strpos($fullname, '  ') !== false) {
            echo '<script>alert("Họ tên không được nhập 2 dấu cách liền nhau.");</script>';
        } else if (strlen($age) > 2) {
            echo '<script>alert("Tuổi không hợp lệ.");</script>';
        } else if ( $age <= 0) {
            echo '<script>alert("Tuổi phải là một số nguyên dương.");</script>';
        } else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
            echo '<script>alert("Mật khẩu không hợp lệ. Phải chứa ít nhất 8 ký tự, ít nhất một chữ số, một chữ thường và một chữ hoa.");</script>';
        } else if ($password !== $confirm_password) {
            echo '<script>alert("Mật khẩu và xác nhận mật khẩu không khớp.");</script>';
        }
        else if (!ctype_digit($phoneNumber)) {
            echo '<script>alert("Số điện thoại không hợp lệ.");</script>';
        } else {
            $sqlGetMaxNumber = "SELECT MAX(CAST(SUBSTRING(ID_Cus, 3) AS SIGNED)) AS max_number FROM infor_customer";
            $resultMaxNumber = $conn->query($sqlGetMaxNumber);

            if ($resultMaxNumber->num_rows > 0) {
                $row = $resultMaxNumber->fetch_assoc();
                $maxNumber = $row['max_number'];
                $currentNumber = $maxNumber + 1;
            } else {
                $currentNumber = 1;
            }
            $userRole = $_POST["userRole"];
            if ($userRole == "customer") {
                 $ID = "CT" . $currentNumber;;
            } elseif ($userRole == "admin") {
                 $ID = "AD" . $currentNumber;;
            } else {
                echo '<script>alert("Chức vụ không hợp lệ.");</script>';
                exit;
            }
            $sql = "INSERT INTO infor_customer (ID_Cus, UserName_Cus, PassWord_Cus, FullName_Cus, Age_Cus, Address_Cus ,Email_Cus ,Phone_Cus) 
                        VALUES ('$ID', '$username', '$password', '$fullname', '$age', '$address','$email','$phoneNumber')";

            if ($conn->query($sql) === TRUE) {
                echo '<script>alert("Đăng ký thành công");</script>';
                echo '<script>window.location = "contact_User.php?category=user";</script>';
                exit;
            } else {
                echo '<script>alert("Đăng ký thất bại: ' . $conn->error . '");</script>';
            }
        }
    }
    }
    ?>

</div>
</body>
</html>
