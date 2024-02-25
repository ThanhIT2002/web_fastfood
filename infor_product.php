<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <title>Chi tiết</title>
    <script>
    function goBack() {
        window.location.href = 'menu.php?category_id=CP_1';
    }
    </script>
    <style>
        .product_details_main{
            padding: 10px;
        }
        .product_details{
        width: 60%;
        display: flex;
        }
        .product_details img{
            max-width: 60%;
            height: auto;
            margin-bottom: 10px;
        }
        .product_details_main {
        width: 100%;
        display: flex;
        flex-direction: column;
        padding-left: 10px;
        border: 1px solid #ccc;
        margin: 85px;
        box-shadow: 0px 0px 10px;
        
        }
        .product_details_main h3 {
        font-size: 28px; /* Kích thước chữ cho tiêu đề */
        margin-bottom: 10px;
        color:#c00000;
        }

        .product_details_name{
        width: 600px;
        }
        .product_details_main p {
        font-size: 18px; /* Kích thước chữ cho nội dung */
        margin-bottom: 15px;
        }

        .product_details_main img {
        max-width: 100%;
        height: auto;
        margin-bottom: 15px;
        }

        .product_details_main button {
        background-color: #c00000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
        width: 200px;
        text-align: center;
        }

        .product_details_main button:hover {
        background-color: #ff0000;
        }
        .product_details_name h3{
        color: #c00000;
        }
        .product_back button{
        background-color: #c00000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
        width: 200px;
        text-align: center;
        }
        .product_back button
        :hover {
        background-color: #ff0000;
        }
        .product_back{
        position: absolute;
            right: 10px;  
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
                            <img src="pic_header/cart3.png">
                        </div>
                        <div class="header_service-user">
                            <?php
                               session_start();
    
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
                                <a href="home.php"><?php ?></a>
                            </li>
                            <li class="header__funtcion-items"><a href="home.php" ><img src="pic_header/home.png">TRANG CHỦ</a></li>
                            <li class="header__funtcion-items"><a href="menu.php" style=" color: #c00000;"><img src="pic_header/menu.png">THỰC ĐƠN</a></li>
                            <li class="header__funtcion-items"><a href="contact.php"><img src="pic_header/Contact.png">LIÊN HỆ</a></li>
                            <li class="header__funtcion-items"><a href="AboutYou.php"><img src="pic_header/about.png">Tài khoản của bạn</a></li>
                        </ul>
                    </div>
                </div>
            </header>
        <div class="container">
     <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webfastfood";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $categories = [];
    $sql = "SELECT * FROM category_product";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    ?>
    <?php
if (isset($_GET['product_id'])) {
    $selectedProductID = $_GET['product_id'];
    $sql = "SELECT infor_product.*, category_product.Name_CP
    FROM infor_product
    LEFT JOIN category_product ON infor_product.ID_CP = category_product.ID_CP
    WHERE infor_product.ID_IP = '$selectedProductID';";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productName = $row['Name_IP'];
        $productImage = $row['src_IP'];
        $productDescription = nl2br($row['Description_IP']);
        $productPrice = $row['Price_IP'];
    } else {
        $productName = 'Sản phẩm không tồn tại.';
        $productImage = ''; 
        $productDescription = '';
        $productPrice = '';
    }
} else {
    $productName = 'Không có sản phẩm được chọn.';
    $productImage = ''; 
    $productDescription = '';
    $productPrice = '';
}
?>

        <div class="product_main">
            <div class="product_details">
                <div class="product_details_title"></div>
                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
                <div class="product_details_main">
                    <h2 class="product_details_name"><?php echo $productName; ?></h2>
                    <p><?php echo $productDescription; ?></p>
                    <h3>Giá: <?php echo $productPrice; ?> VNĐ</h3>
                    <form method="post" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $selectedProductID; ?>">
                    <button type="submit" name="add_to_cart">Thêm vào giỏ hàng</button>
                </form>
                </div>
            </div>
        </div>
        <div class="product_back">
        <button onclick="goBack()">Quay lại</button>
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