<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleOfContact.css" type="text/css">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <title>Liên hệ</title>
    <style>
        .contacted {
    margin-top: 20px;
    margin-left: 20px;
}

.recent-feedback {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.feedback-item{ 
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 10px;
    width: 300px;
    box-shadow: 0 0 10px;
    margin-bottom: 20px;
    cursor: pointer;
}
.recent-feedback :hover{
    border-color: #c00000;
}
    </style>
</head>

<body>
<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webfastfood";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit-contact'])) {
    // Lấy dữ liệu từ form
    $name = trim($_POST['name']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $content = trim($_POST['content-contact']);

    // Chuẩn bị và thực thi truy vấn SQL
    $sql = "INSERT INTO contact (Name_Contact, PhoneNumber_Contact, Address_Contact, Content_Contact)
            VALUES ('$name', '$phone_number', '$address', '$content')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Gửi liên hệ của bạn thành công")</script>';
        } else {
            echo '<script>alert("' . $conn->error . '");</script>';
        }
}
?>
    <div class="app">
    <header class="header">
            <div class="header__service">
                <div class="header__service-logo">
                    <a href="home.php"><img src="pic_header/logo1.png" alt="logo"></a>
                </div>
                <div class="header__service-search">
                    <form method="GET" action="search.php"> 
                    <input type="text" name="query" placeholder="Tìm kiếm về đồ ăn nhanh" required>
                        <button type="submit" name="btn_Search">
                            <img src="pic_header/search2.png" alt="Tìm kiếm">
                        </button>
                    </form>
                </div>
                
                <div class="header__service-user_buy">
                    <div class="header__service-buy">
                    <?php
                        session_start();

                        // Kiểm tra đăng nhập
                        if (isset($_SESSION['username'])) {
                            echo '<a href="add_to_cart.php"><img src="pic_header/cart3.png" alt="Giỏ hàng"></a>';
                        } else {
                            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
                            echo '<a href="Login.php"><img src="pic_header/cart3.png" alt="Giỏ hàng"></a>';
                        }
                        ?>
                    </div>
                    <div class="header_service-user">
                        <?php
                           if (isset($_SESSION['username'])) {
                            echo '<div class="user-info">' . $_SESSION['username'] . '</div>';
                            echo '<a href="Logout.php" class="logout-button">Đăng xuất</a>';
                            
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
                        <li class="header__funtcion-items">
                            <a href="home.php"></a>
                        </li>
                        <li class="header__funtcion-items"><a href="home.php"><img src="pic_header/home.png">TRANG CHỦ</a></li>
                        <li class="header__funtcion-items"><a href="menu.php?category_id=CP_1""><img src="pic_header/menu.png">THỰC ĐƠN</a></li>
                        <li class="header__funtcion-items"><a href="contact.php" style=" color: #c00000;"><img src="pic_header/Contact.png">LIÊN HỆ</a></li>
                        <li class="header__funtcion-items"><a href="AboutYou.php"><img src="pic_header/about.png">Tài khoản của bạn</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="container_contact">
        <div class="contacted">
                    <h3>Phản hồi gần đây</h3>
            <?php
                // Truy vấn để lấy 4 phản hồi gần đây từ bảng contact
                $sqlRecentFeedback = "SELECT Name_Contact, Address_Contact, Content_Contact FROM contact ORDER BY ID_Contact DESC LIMIT 4";
                $resultRecentFeedback = $conn->query($sqlRecentFeedback);

                if ($resultRecentFeedback->num_rows > 0) {
                    echo '<div class="recent-feedback">';
                    while ($rowFeedback = $resultRecentFeedback->fetch_assoc()) {
                        echo '<div class="feedback-item">';
                        echo '<p><strong>Tên:</strong> ' . $rowFeedback['Name_Contact'] . '</p>';
                        echo '<p><strong>Địa chỉ:</strong> ' . $rowFeedback['Address_Contact'] . '</p>';
                        echo '<p><strong>Nội dung:</strong> ' . $rowFeedback['Content_Contact'] . '</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>Chưa có phản hồi nào.</p>';
                }
            ?>
        </div>
            <div class="contact-us">
                <div class="contact-us_main">
                    <h2>LIÊN HỆ VỚI CHÚNG TÔI</h2>
                    <div class="contact-member">
                        <h3>Nguyễn Văn Thành</h3>
                        <p>Số điện thoại: 0985 310 502</p>
                    </div>
                    <div class="contact-member">
                        <h3>Lê Duy Thành</h3>
                        <p>Số điện thoại: 0868 740 511</p>
                    </div>
                </div>
            </div>
            <div class="contact-main">
                <div class="your-infor">
                    <h3>Thông tin của bạn</h3>
                    <form action="contact.php" method="post" required>
                        <table>
                            <tr>
                                <td>Họ và tên</td>
                                <td>
                                    <input type="text" name="name" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Số điện thoại</td>
                                <td>
                                    <input type="text" name="phone_number" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Địa chỉ</td>
                                <td>
                                    <input type="text" name="address" required>
                                </td>
                            </tr>
                        </table>
                        <h4>Nội dung muốn liên hệ</h4>
                        <textarea name="content-contact" required cols="30" rows="10" placeholder="Nhập nội dung muốn liên hệ">
                        </textarea>
                        <button type="submit" name="submit-contact" onclick="trimContent()">Gửi</button>
                    </form>
                </div>  
            </div>   
                   
        </div>
        <footer class="footer"  style = "margin-top: 100px;">
            <?php
            include 'footer.php';
            ?>
        </footer>
    </div>
</body>
</html>