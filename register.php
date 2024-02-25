<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleOfHome.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <title>Đăng ký</title>
</head>
<body>
    <div class="app">
                <div class="Login_container">
                        <div class="row">
                            <div class="col-md-6 mx-auto py-4 px-0">
                                <div class="card p-0">
                            <div class="card-title text-center">
                                <h5 class="mt-5">Đăng ký</h5>
                            </div>
                            <form class="signup" action="register.php" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="UserName" placeholder="Tên đăng nhập" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="PassWord" placeholder="Mật khẩu" required>
                                </div> 
                                <div class="form-group">
                                    <input type="password" class="form-control" name="Confirm_PassWord" placeholder="Xác nhận mật khẩu" required>
                                </div> 
                                <div class="form-group">
                                    <input type="text" class="form-control" name="FullName" placeholder="Họ và tên" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="Email" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" name="PhoneNumber" placeholder="Số điện thoại" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Age" placeholder="Tuổi" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Address" placeholder="Địa chỉ" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="btn_SignUp">Đăng ký</button>
                                <div class="row">
                                    <div class="col-6 col-sm-6">
                                    <a href="Login.php">
                                         <p class="text-right pt-2 mr-1">Quay lại đăng nhập</p>
                                        </a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
             $servername = "localhost";
             $username = "root";
             $password = "";
             $database = "webfastfood";
             $ID="";
             $conn = new mysqli($servername, $username, $password, $database);
             
             // Kiểm tra kết nối
             if ($conn->connect_error) {
                 die("Kết nối không thành công: " . $conn->connect_error);
             }
                
             if (isset($_POST["btn_SignUp"])) {
                $username = $_POST["UserName"];
                // Kiểm tra xem tên người dùng đã tồn tại trong cơ sở dữ liệu chưa
                $checkUsernameQuery = "SELECT * FROM infor_customer WHERE UserName_Cus = '$username'";
                $result = $conn->query($checkUsernameQuery);
            
                if ($result->num_rows > 0) {
                    echo '<script>alert("Tên người dùng đã tồn tại. Vui lòng chọn tên người dùng khác.");</script>';
                } else {
                    $fullname = $_POST["FullName"];
                    $password = $_POST["PassWord"];
                    $confirm_password = $_POST["Confirm_PassWord"];
                    $age = $_POST["Age"];
                    $address = $_POST["Address"];
                    $email = $_POST["Email"];
                    $phoneNumber = $_POST["PhoneNumber"];
                    if (strpos($fullname, '  ') !== false) {
                        echo '<script>alert("Họ tên không được nhập 2 dấu cách liền nhau.");</script>';
                    }
                    else if( strlen($age) > 2){
                        echo '<script>alert("Tối đa 3 ký tự.");</script>';
                    }
                    else if (!is_numeric($age)) {
                        echo '<script>alert("Tuổi phải là số.");</script>';
                    }
                    else if (!empty($password) && !empty($confirm_password) && $password !== $confirm_password) {
                        echo '<script>alert("Mật khẩu và xác nhận mật khẩu không khớp.");</script>';
                    }
                    else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
                        echo '<script>alert("Mật khẩu không hợp lệ. Phải chứa ít nhất 8 ký tự, ít nhất một chữ số, một chữ thường và một chữ hoa.");</script>';
                    }
                    // Kiểm tra định dạng email
                    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo '<script>alert("Địa chỉ email không hợp lệ.");</script>';
                    }
                    // Kiểm tra định dạng số điện thoại
                    else if (!ctype_digit($phoneNumber)) {
                        echo '<script>alert("Số điện thoại không hợp lệ.");</script>';
                    }
                    else {
                        $sqlGetMaxNumber = "SELECT MAX(CAST(SUBSTRING(ID_Cus, 3) AS SIGNED)) AS max_number FROM infor_customer";
                        $resultMaxNumber = $conn->query($sqlGetMaxNumber);
            
                        if ($resultMaxNumber->num_rows > 0) {
                            $row = $resultMaxNumber->fetch_assoc();
                            $maxNumber = $row['max_number'];
                            $currentNumber = $maxNumber + 1;
                        } else {
                            $currentNumber = 1;
                        }
            
                        $ID = "CT" . $currentNumber;
                        $sql = "INSERT INTO infor_customer (ID_Cus, UserName_Cus, PassWord_Cus, FullName_Cus, Age_Cus, Address_Cus ,Email_Cus ,Phone_Cus) 
                        VALUES ('$ID', '$username', '$password', '$fullname', '$age', '$address','$email','$phoneNumber')";
            
                        if ($conn->query($sql) === TRUE) {
                            echo '<script>alert("Đăng ký thành công");</script>';
                            echo '<script>window.location = "Login.php";</script>';
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