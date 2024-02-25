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
    <title>Menu Admin</title>
</head>

<style>
    .container-menu_Admin {
        margin: 20px;
        display: flex;
    }

    .container-menu_Admin ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .cate_menu_Admin li {
        display: flex;
        flex-direction: column;
    }

    .cate_menu_Admin a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
        font-size: 16px;
        display: block;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        transition: background-color 0.3s;
    }

    .cate_menu_Admin li :hover {
        background-color: #ccc;
    }

    .container-menu_Admin ul li {
        margin-right: 20px;
    }

    .container-menu_Admin ul li a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    .container-menu_Admin ul li a:hover {
        color: #c00000;
    }

    .container-menu_Admin p {
        margin-top: 20px;
        font-size: 18px;
        color: #c00000;
        font-weight: bold;
    }
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
                        <input type="text" placeholder="Tìm kiếm..." name="content_Search" required>
                        <button type="submit" name="btn_Search">
                            <img src="pic_header/search2.png" alt="Tìm kiếm">
                        </button>
                    </form>
                </div>
                <div class="header__service-user_buy">
                    <div class="header_service-user"  >
                        <?php
                           session_start();

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

        <div class="container-menu_Admin">
            <div class="cate_menu_Admin">
                <ul>
                    <li>
                        <a href="menu_Admin.php?category=cart">Giỏ hàng</a>
                        <a href="menu_Admin.php?category=product_info">Thông tin Sản phẩm</a>
                    </li>
                </ul>
            </div>
            <div class="content_menu_Admin">
                <?php
                if (isset($_GET['category'])) {
                    $category = $_GET['category'];
                    if ($category == 'cart') {
                        include 'displayCart.php';
                    } elseif ($category == 'product_info') {
                        include 'displayProductInfo.php';
                    } else {
                        echo '<p>Danh mục không hợp lệ.</p>';
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
