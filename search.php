
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="header.css" type="text/css">
        <link rel="stylesheet" href="footer.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
        <style>
            /* CSS cho kết quả tìm kiếm */
.container_Seach {
    margin: 20px auto;
    padding: 20px;
    width: 80%;
}

.search-list {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
}

.search-item {
    width: calc(33.33% - 20px);
    margin: 10px;
    border: 1px solid #ddd;
    padding: 10px;
    box-sizing: border-box;
    transition: box-shadow 0.3s ease; /* Hiệu ứng chuyển động */

    /* Thêm hiệu ứng box-shadow khi hover */
    cursor: pointer;
}
.search-item a{
    text-decoration: none;
}
.search-item:hover {
    box-shadow: 0 0 10px #c00000;
}
.pic_search_details{
    height: 290px;
    margin-bottom: 5px;
}
.pic_search_details img {
    width: 100%;
    height: auto;
    border-radius: 5px;
}

.product_search_details {
    display: flex;
    flex-direction: column;
    align-items: center; /* Canh chỉnh theo chiều ngang */
    text-align: center; /* Canh chỉnh theo chiều dọc */
}

.product_search_details h3 {
    font-size: 18px;
    margin: 10px 0;
    color: #c00000; /* Màu văn bản của tiêu đề */
}

.product_search_details h4 {
    font-size: 16px;
    margin: 5px 0;
    color: #c00000; /* Màu văn bản của giá */
}

button[name="add_to_cart"] {
    background-color: #c00000;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease; /* Hiệu ứng chuyển động */
    display: block;
    margin: 0 auto;
}

button[name="add_to_cart"]:hover {
    background-color: #690102;
}
.product_search_name{
    margin-top: 10px;
    height: 50px;
}
        </style>
        <title>Trang chủ</title>
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

                
         <div class="container_Seach">
         <?php
     
         $servername = "localhost";
         $username = "root";
         $password = "";
         $dbname = "webfastfood";
     
         $conn = new mysqli($servername, $username, $password, $dbname);
     
         if ($conn->connect_error) {
             die("Kết nối không thành công: " . $conn->connect_error);
         }
     
         if (isset($_GET['query'])) {
             $searchQuery = $_GET['query'];
     
             $sql = "SELECT * FROM infor_product WHERE Name_IP LIKE '%$searchQuery%'";
             $result = $conn->query($sql);
     
             if (!$result) {
                 die("Truy vấn thất bại: " . $conn->error);
             }
             echo '<h2>Kết quả tìm kiếm : '.$searchQuery.'</h2>';
             echo '<div class="search-list">';
             if ($result->num_rows > 0) {
                 while ($row = $result->fetch_assoc()) {
                     echo '<div class="search-item">';
                     echo '<form method="post" action="add_to_cart.php">';
                     echo '<input type="hidden" name="product_id" value="' . $row['ID_IP'] . '">';
                     echo '<a href="infor_product.php?product_id=' . $row['ID_IP'] . '">';
                     echo '<div class= "pic_search_details">';
                     echo '<img src="' . $row['src_IP'] . '" alt="' . $row['Name_IP'] . '">';
                     echo'</div>';
                     echo '<div class="product_search_details">';
                     echo '<div class = "product_search_name">';
                     echo '<h3>' . $row['Name_IP'] . '</h3>';
                     echo '</div>';
                     echo '<h4 class="product_search_price" style="color:#c00000">Giá : ' . $row['Price_IP'] . ' VNĐ</h4>';
                     echo '</div>';
                     echo '</a>';
                     echo '<button type="submit" name="add_to_cart">Thêm vào giỏ hàng</button>';
                     echo '</form>';
                     echo '</div>';  

                 }
             } else {
                 echo '<p style ="margin-bottom : 150px ">Không tìm thấy kết quả nào.</p>';
             }
             echo '</div>';
         } else {
             echo '<p>Truy vấn tìm kiếm không hợp lệ.</p>';
         }
     
         $conn->close();
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
