<?php
    $conn = new mysqli("localhost" ,"root","","webfastfood");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleOfCart.css" type="text/css">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <title>Giỏ hàng</title>
    <style>
       .pic_cart img{
                    max-width: 100px; /* Đặt chiều rộng tối đa của ảnh */
                    height: auto; /* Để giữ tỷ lệ khung hình */
                    margin-bottom: 10px;
                    display: block;
        }
        .order-history {
    text-align: center;
    margin-bottom: 20px;
}

.cart_empty {
    padding: 20px;
}

.place-order-button,
.view-order-button {
    display: inline-block;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    font-weight: bold;
    margin: 10px; /* Khoảng cách giữa các nút */
}

.place-order-button {
    background-color: #c00000;
    color: white;
    border-radius: 5px;
    width: 170px;
    margin-top: 10px;
}

.view-order-button {
    color: #c00000;
    border: 1px solid #c00000;
    border-radius: 5px;
}
.cart_empty img {
    margin-bottom: 10px;
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
                        session_start();

                        // Kiểm tra đăng nhập
                        if (isset($_SESSION['username'])) {
                            echo '<a href="add_to_cart.php"><img src="pic_header/cart3.png" alt="Giỏ hàng"></a>';
                        
                            $sql_get_id = "SELECT ID_Cus FROM infor_customer WHERE UserName_Cus = ?";
                            $stmt_get_id = $conn->prepare($sql_get_id);
                            $stmt_get_id->bind_param("s", $_SESSION['username']);
                            $stmt_get_id->execute();
                            $result_get_id = $stmt_get_id->get_result();
                        
                            if ($result_get_id->num_rows > 0) {
                                $row = $result_get_id->fetch_assoc();
                                $id_cus = $row['ID_Cus'];
                            } else {
                                echo 'Không tìm thấy thông tin khách hàng.';
                                exit();
                            }
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
                        <li class="header__funtcion-items"><a href="menu.php?category_id=CP_1"" style=" color: #c00000;"><img src="pic_header/menu.png">THỰC ĐƠN</a></li>
                        <li class="header__funtcion-items"><a href="contact.php"><img src="pic_header/Contact.png">LIÊN HỆ</a></li>
                        <li class="header__funtcion-items"><a href="AboutYou.php"><img src="pic_header/about.png">Tài khoản của bạn</a></li>
                    </ul>
                </div>
            </div>
        </header>
     <div class="container_cart" style="margin-bottom : 150px; margin-top:70px">
     <?php
        echo '<div class="order-history" style ="color : #c00000">';
        echo'<div class="cart_empty">';
        echo '<img src = "pic_header/success.png">';
        echo '<h2>Đặt hàng thành công!!!</h2>';
        echo '<a class="place-order-button" href="menu.php?category_id=CP_1">Đặt hàng</a>';
        if (isset($_SESSION['username'])) {
            echo '<a href="History_Cart.php" class="place-order-button">Đơn hàng đã đặt</a>';
        }
        echo '</div>';
        echo '</div>';
     ?>
     </div>

     <footer class="footer" style = "margin-top: 100px;">
            <?php
            include 'footer.php';
            ?>
        </footer>
    </div>
</body>
</html>