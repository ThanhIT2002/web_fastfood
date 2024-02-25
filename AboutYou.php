<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleOfTeam.css" type="text/css">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <title>Team 5</title>
    <style>
        body {
            font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

   .container_about {
    width: 90%;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
}

.category_about {
    border: 1px solid #ccc;
    padding: 20px;
    background-color: #f8f8f8;
    border-radius: 5px;
    margin-right: 50px;
}

.category_about .user-section {
    text-align: center;
    margin-bottom: 20px;
    font-size: 18px;
    color: #333;
}

.category_about .user-section img {
    max-width: 100px;
    margin-bottom: 10px;
}

.category_about .options-section {
    margin-top: 20px;
}

.category_about .options-section ul {
    list-style: none;
    padding: 0;
}

.category_about .options-section li {
    display: inline-block;
}

.category_about .options-section a {
    display: block;
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
    color: #c00000;
    font-weight: bold;
    transition: background-color 0.3s;
}

.category_about .options-section a:hover {
    background-color: #ccc;
    text-decoration: underline;
}
.content_about{
    display: flex;
    justify-content: center;
}

</style>
</head>
<body>
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
                        <li class="header__funtcion-items"><a href="menu.php?category_id=CP_1"><img src="pic_header/menu.png">THỰC ĐƠN</a></li>
                        <li class="header__funtcion-items"><a href="contact.php"><img src="pic_header/Contact.png">LIÊN HỆ</a></li>
                        <li class="header__funtcion-items"><a href="AboutYou.php?category=yourInfor" style=" color: #c00000;"><img src="pic_header/about.png">Tài khoản của bạn</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="container_about">
           <div class="category_about">
           <div class="user-section">
                <img src="pic_header/logo2.png">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<div>Xin chào, ' . $_SESSION['username'] . '!</div>';
                }
                ?>
            </div>

            <div class="options-section">
                <ul>
                    <li>
                        <a href="?category=yourInfor">Thông tin của bạn</a>
                        <a href="?category=changePassword">Đổi mật khẩu</a>
                        <a href="?category=HistoryCart">Đơn hàng đã đặt</a>
                        <a href="?category=DeleteYourAccount">Xóa tài khoản</a>
                    </li>
                </ul>
            </div>
           </div>
           <div class="content_about">
           <?php
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        if ($category == 'yourInfor') {
            include 'Your_Infor.php';
        } elseif ($category == 'changePassword') {
            include 'changePassword.php';
        }
        elseif ($category == 'DeleteYourAccount') {
            include 'deleteAcc.php';
        }
        elseif ($category == 'HistoryCart') {
            echo '<script>window.location.href="History_Cart.php"</script>';
        }
    } else {
        echo '<p>Vui lòng chọn một danh mục để hiển thị.</p>';
    }
    ?>
           </div>

        </div>

        <footer class="footer" style = "margin-top: 100px;">
            <?php
            include 'footer.php';
            ?>
        </footer>
    </div>
</body>
</html>