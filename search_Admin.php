<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleOfHome.css" type="text/css">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Trang chủ</title>
</head>

<style>
    .header__service-search select {
    padding: 8px;
    border: none;
    border-radius: 4px;
    margin-right: 10px;
    cursor: pointer;
    appearance: none; /* Ẩn kiểu mặc định của select trên Firefox */
}

.header__service-search select:focus {
    outline: none;
}

/* Thiết lập border, background và màu chữ cho select khi được chọn */
.header__service-search select option:checked {
    background-color: #c00000;
    color: white;
}

/* Định dạng mũi tên xuống cho select */
.header__service-search select:after {
    content: "\25BC"; /* Mã Unicode của mũi tên xuống */
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
}
.container-Search{
    width: 95%;
    margin: 10px auto;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #c00000;
    color: white;
}

/* Định dạng các input trong bảng */
input[type="text"],
textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border :none;
}

/* Định dạng nút Sửa và Xóa */
.container-Search input[type="submit"] {
    padding: 5px 10px;
    cursor: pointer;
    background-color: #c00000;
    color: white;
    border: none;
    border-radius: 4px;
    margin-right: 5px;
    margin-bottom: 5px;
}

.container-Search input[type="submit"]:hover {
    background-color: #690102;
}
.container-Search img {
    max-width: 100px; /* Đặt chiều rộng tối đa của ảnh */
            height: auto; /* Để giữ tỷ lệ khung hình */
            margin-bottom: 10px;
            display: block;
}

</style>

<body>
    <div class="app">
        <header class="header">
            <div class="header__service">
                <div class="header__service-logo">
                    <a href="Home_Admin.php?category=banners"><img src="pic_header/logo1.png" alt="logo"></a>
                </div>
                <div class="header__service-search">
                    <form method="POST" action="search_Admin.php"> 
                        <select name="search_category">
                            <option value="product">Sản phẩm</option>
                            <option value="account">Tài khoản</option>
                        </select>
                        

    <input type="text" placeholder="Tìm kiếm..." name="content_Search" value="" required>
                        <button type="submit" name="btn_Search">
                            <img src="pic_header/search2.png" alt="Tìm kiếm">
                        </button>
                    </form>
                </div>
                <div class="header__service-user_buy">
                    <div class="header_service-user"  >
                        <?php
                        

                        if (isset($_SESSION['username'])) {
                            echo '<div class="user-info" style="margin-right:10px">xin chào ' . $_SESSION['username'] . '</div>';
                            echo '<a href="Logout.php" class="logout-button" style="">Đăng xuất</a>';
                        } else {
                            echo '<div class="user-info"><a href="Login.php"><img src="pic_header/user2.png"></a></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="header__funtcion-full">
                <div class="header__funtcion">
                    <ul class="header__funtcion-list">
                        <li class="header__funtcion-items"><a href="Home_Admin.php?category=banners" ><img src="pic_header/home.png">Quản lí trang chủ</a></li>
                        <li class="header__funtcion-items"><a href="menu_Admin.php?category=cart" style=" color: #c00000;"><img src="pic_header/menu.png">Quản lí thực đơn</a></li>
                        <li class="header__funtcion-items"><a href="contact_User.php?category=contact"><img src="pic_header/Contact.png">Quản lí liên hệ và tài khoản</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="container-Search">
       <form method="post" enctype="multipart/form-data">
            <?php
            $conn = new mysqli("localhost","root","","webfastfood");

           
            if(isset($_POST['btn_Search']) ){
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
                                echo"<script>alert('Sửa thành công')</script>";
                                continue;
                            } else {
                                echo '<p>Lỗi khi sửa thông tin sản phẩm: ' . $conn->error . '</p>';
                            }
                        } elseif (strpos($key, 'deleteProductInfo_') === 0) {
                            $idIP = substr($key, strlen('deleteProductInfo_'));
        
                            $sql = "DELETE FROM infor_product WHERE ID_IP='$idIP'";
                            $result = $conn->query($sql);
        
                            if ($result) {
                                echo"<script>alert('Xóa thành công')</script>";
                                continue;
                            } else {
                                echo '<p>Lỗi khi xóa thông tin sản phẩm: ' . $conn->error . '</p>';
                            }
                        }
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
                $content_search = $_POST['content_Search'];
                $category_search = $_POST['search_category'];
                if (empty($content_search)) {
                    echo "<script>alert('Vui lòng nhập nội dung muốn tìm')</script>";
                    echo "<script>window.location.href = 'Home_Admin.php?category=banners'</script>";
                } 
                else{
                    switch($category_search){
                        case 'product':
                            $sql="SELECT * FROM infor_product WHERE Name_IP LIKE '%$content_search%' ";
                            break;
                        case 'account':
                            $sql = "SELECT * FROM infor_customer WHERE UserName_Cus LIKE '%$content_search%' OR FullName_Cus LIKE '%$content_search%'";
                            break;
                        default : 
                            echo "Danh mục không hợp lệ!!";
                            exit();
                    }
                    $result = $conn->query($sql);

                    if($result->num_rows>0){
                        
                        echo "<table>";

                        switch($category_search){
                            case 'product':
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
                                }
                                break;
                            case 'account':
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
                                }
                                break;
                        }
                        echo "</table>";
                    }
                    else{
                        echo "Không tìm thấy kết quả";
                    }
                }
            }
            else{
                
            }
           
            $conn->close();
            ?>
            </form>
        </div>

        <footer class="footer" style="margin-top: 100px;">
            <?php
            include 'footer.php';
            ?>
        </footer>
    </div>
</body>

</html>
