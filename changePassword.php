<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
</head>
<style>

.container_changePW {
    max-width: 600px;
    margin: auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-left: 150px;
}

h2 {
    text-align: center;
    color: #333;
}

table {
    width: 100%;
}

label {
    margin-bottom: 8px;
    color: #555;
}

input {
    padding: 10px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: calc(100% - 20px);
}

input[type="submit"] {
    background-color: #c00000;
    color: white;
    cursor: pointer;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #690102;
}

.alert {
    margin-top: 16px;
    padding: 10px;
    background-color: #f44336;
    color: white;
    border-radius: 4px;
    display: none;
}


</style>
<body>

<?php

$conn = new mysqli("localhost", "root", "", "webfastfood");

if (isset($_POST['change_password']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmNewPassword = $_POST["confirm_new_password"];
    $sqlUser = "SELECT PassWord_Cus FROM infor_customer WHERE UserName_Cus = '$username'";
    $resultUser = $conn->query($sqlUser);

    if ($resultUser->num_rows > 0) {
        $row =  $resultUser->fetch_assoc();
        $PassDB = $row['PassWord_Cus'];
        if ($currentPassword != $PassDB) {
            echo "<script>alert('Nhập đúng mật khẩu')</script>";
        } else if ($confirmNewPassword != $newPassword) {
            echo "<script>alert('Nhập đúng mật khẩu xác nhận')</script>";
        } else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $newPassword)) {
            echo '<script>alert("Mật khẩu không hợp lệ. Phải chứa ít nhất 8 ký tự, ít nhất một chữ số, một chữ thường và một chữ hoa.");</script>';
        } else {
            $sql = "UPDATE infor_customer SET PassWord_Cus ='$newPassword' WHERE UserName_Cus = '$username' ";
            $result = $conn->query($sql);
            if ($result) {
                echo "<script>alert('Đổi mật khẩu thành công')</script>";
            } else {
                echo "<script>alert('Đổi mật khẩu thất bại')</script>";
            }
        }
    }
}
?>
<div class="container_changePW">

    <h2>THÔNG TIN ĐỔI MẬT KHẨU</h2>
    <form method="post" action="">
        <table>
            <tr>
                <td>
                    <label for="current_password">Mật khẩu hiện tại:</label>
                </td>
                <td>
                    <input type="password" id="current_password" name="current_password" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="new_password">Mật khẩu mới:</label>
                </td>
                <td>
                    <input type="password" id="new_password" name="new_password" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="confirm_new_password">Xác nhận mật khẩu mới:</label>
                </td>
                <td>
                    <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="change_password" value="Đổi Mật Khẩu">
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>
