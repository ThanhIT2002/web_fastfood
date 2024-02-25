<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<style>
    .user-details {
        margin-top: 20px;
    }

    .user-details h2 {
        color: #c00000;
        margin-bottom: 10px;
        text-align: center;
    }

    .user-details table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .user-details table td {
        padding: 10px;
        border: 1px solid #ccc;
    }
    .user-details td {
       width: 200px;
    }
    .user-details table input {
        width:730px;
        padding: 8px;
        box-sizing: border-box;
        margin-bottom: 5px;
    }
    .user-details input {
        border :none;
        margin-left: 10px;
    }
    .user-details button {
        padding: 10px;
        background-color: #c00000;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .user-details button:hover {
        background-color: #a00000;
    }
</style>

<body>
<?php
$conn = new mysqli("localhost", "root", "", "webfastfood");
// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}
// Kiểm tra đăng nhập
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    if (isset($_POST['update'])) {
        $fullName = $_POST['FullName_Cus'];
        $email = $_POST['Email_Cus'];
        $phone = $_POST['Phone_Cus'];
        $age = $_POST['Age_Cus'];
        $address = $_POST['Address_Cus'];
    
        if (strpos($fullName, '  ') !== false) {
            echo '<script>alert("Họ tên không được nhập 2 dấu cách liền nhau.");</script>';
        } else if (strlen($age) > 2) {
            echo '<script>alert("Tuổi không hợp lệ.");</script>';
        } else if ( $age <= 0) {
            echo '<script>alert("Tuổi phải là một số nguyên dương.");</script>';
        } 
        else if (!ctype_digit($phone)) {
            echo '<script>alert("Số điện thoại không hợp lệ.");</script>';
        }
        else{
            $sqlupdate = "UPDATE infor_customer SET FullName_Cus = '$fullName', Email_Cus = '$email',
            Phone_Cus = '$phone', Age_Cus = '$age', Address_Cus = '$address' WHERE UserName_Cus = '$username'";
            
            $resultupdate = $conn->query($sqlupdate);
    
            if ($resultupdate) {
                echo '<script>alert("Cập nhật thành công");</script>';
            } else {
                echo '<p>Lỗi khi sửa thông tin người dùng: ' . $conn->error . '</p>';
            }
        }
        
    }
    // Truy vấn SQL để lấy thông tin người dùng từ bảng
    $sql = "SELECT UserName_Cus, PassWord_Cus, FullName_Cus, Age_Cus, Address_Cus, Email_Cus, Phone_Cus FROM infor_customer WHERE UserName_Cus = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="user-details">';
        echo '<h2>Thông tin của bạn</h2>';
        echo '<form action="" method="POST">';
        echo '<table>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>Họ tên</td>';
            echo '<td><input type="text" name="FullName_Cus" value="' . $row['FullName_Cus'] . '" ></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Email</td>';
            echo '<td><input type="email" name="Email_Cus" value="' . $row['Email_Cus'] . '"></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Số điện thoại</td>';
            echo '<td><input type="tel" name="Phone_Cus" value="' . $row['Phone_Cus'] . '" ></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Tuổi</td>';
            echo '<td><input type="text" name="Age_Cus" value="' . $row['Age_Cus'] . '" ></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Địa chỉ</td>';
            echo '<td><input type="text" name="Address_Cus" value="' . $row['Address_Cus'] . '" ></td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<button type="submit" name="update">Cập nhật</button>';
        echo '</form>';
        echo '</div>';
    } else {
        echo 'Không tìm thấy thông tin người dùng.';
    }
    $stmt->close();
} else {
    echo 'Vui lòng đăng nhập để xem thông tin.';
}

$conn->close();
?>
</body>
</html>
