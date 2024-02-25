<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleOfHome.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <script src = "bootstrap/js/bootstrap.bundle.min.js" ></script>
    <script src = "toast.js" ></script>
    <title>Đăng nhập</title>
</head>
<body>
    <div class="app">
                <?php
                    // Kết nối đến cơ sở dữ liệu MySQL
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "webfastfood";
                    $conn = new mysqli($servername, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Kết nối không thành công: " . $conn->connect_error);
                    }

                    if (isset($_POST["btn_login"])) {
                        $username = $_POST["UserName"];
                        $password = $_POST["PassWord"];
                        $sql = "SELECT * FROM infor_customer WHERE UserName_Cus = '$username' AND PassWord_Cus = '$password'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            session_start();
                            $row = $result->fetch_assoc();
                            $_SESSION["username"] = $username;
                            $id = $row['ID_Cus'];
                            if (substr($id, 0, 2) === "AD") {
                                header("Location: Home_Admin.php?category=banners");
                                exit(); 
                            } elseif (substr($id, 0, 2) === "CT") {
                                header("Location: home.php");
                            }
                            exit;
                        } else {
                          
                            echo '<script>alert("Đăng nhập thất bại. Vui lòng kiểm tra tên người dùng và mật khẩu.");</script>';
                        }
                    }
                 ?>

                    <div class="Login_container">
                        <div class="row">
                            <div class="col-md-6 mx-auto py-4 px-0">
                                <div class="card p-0">
                            <div class="card-title text-center">
                                <h5 class="mt-5">Đăng nhập</h5>
                                 <small class="para">Vui lòng đăng nhập để sử dụng dịch vụ</small>
                            </div>
                            <form class="signup" action="Login.php" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="UserName" placeholder="Tên đăng nhập">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="PassWord" placeholder="Mật khẩu">
                                </div> 
                                <button type="submit" name ="btn_login" class="btn btn-primary">Đăng nhập</button>
                                <div class="row">
                                    <div class="col-6 col-sm-6">
                                    <a href="register.php">
                                         <p class="text-right pt-2 mr-1">Đăng ký</p>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-6">
                                    <a href="home.php">
                                         <p class="text-right pt-2 mr-1">Quay lại trang chủ</p>
                                        </a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
    </div>
</body>
</html>