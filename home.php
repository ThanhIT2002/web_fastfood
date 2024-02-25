<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleOfHome.css" type="text/css">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <script src = "bootstrap/js/bootstrap.bundle.min.js" ></script>
    <title>Trang chủ</title>
    <style>
        

    .new_product {
        margin-bottom: 50px;
      margin-left: 75px;
      padding: 20px;
      width: 80%;
      background-color: #fff; /* Màu nền của phần new_product */
      border: 1px solid #ddd; /* Đường viền */
      border-radius: 10px; /* Góc bo tròn */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Đổ bóng */
  }
  
  .new_product h2 {
      font-size: 24px;
      color: #333; /* Màu chữ */
      margin-bottom: 20px;
  }
  
  .new_product-list {
      display: flex;
      flex-wrap: wrap;
      margin-top: 20px;
  }
  
  .new_product-item {
      width: calc(20% - 20px);
      margin: 10px;
      border: 1px solid #ddd;
      padding: 10px;
      box-sizing: border-box;
      background-color: #fff;
      border-radius: 5px;
      overflow: hidden;
      transition: transform 0.3s ease-in-out;
  }
  
  .new_product-item:hover {
      transform: scale(1.05); /* Phóng to khi di chuột qua */
  }
  .new_product-name{
    height: 55px;
  }
  .new_product-item img {
      width: 100%;
      height: auto;
      border-radius: 5px;
  }
  
  .new_product-item h4 {
      font-size: 16px;
      margin: 10px 0;
  }
  
  .new_product-item h4.new_product-price {
      color: #c00000; /* Màu chữ giá */
  }
  
  /* Thêm một hiệu ứng đẹp cho nút "Khám phá" */
  .new_product-item a {
      text-decoration: none;
      display: block;
      margin-top: 10px;
      background-color: #c00000;
      color: #fff;
      padding: 8px 16px;
      text-align: center;
      border-radius: 5px;
      transition: background-color 0.3s;
  }
  
  .new_product-item a:hover {
      background-color: #690102; /* Màu nền khi di chuột qua */
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
                        <li class="header__funtcion-items"><a href="home.php" style=" color: #c00000;"><img src="pic_header/home.png">TRANG CHỦ</a></li>
                        <li class="header__funtcion-items"><a href="menu.php?category_id=CP_1"><img src="pic_header/menu.png">THỰC ĐƠN</a></li>
                        <li class="header__funtcion-items"><a href="contact.php"><img src="pic_header/Contact.png">LIÊN HỆ</a></li>
                        <li class="header__funtcion-items"><a href="AboutYou.php"><img src="pic_header/about.png">Tài khoản của bạn</a></li>
                    </ul>
                </div>
            </div>
        </header>

     <div class="container">
            <div class="container_home_banner">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade">
                    <div class="carousel-inner">
                    <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "webfastfood";
                        $conn = new mysqli($servername, $username, $password, $database);

                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT src_Banner, href_Banner FROM banners";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $active = true;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $src = $row["src_Banner"];
                                $href = $row["href_Banner"];
                                echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                                echo '<a href="' . $href . '"><img class="d-block w-100" src="' . $src . '" alt="Slide"></a>';
                                echo '</div>';
                                $active = false;
                            }
                        } else {
                            echo '<div class="carousel-item active">No banners available</div>';
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    </div>
            </div>
            <div class="container_home_catetory">
                <div class="category_home-tittle">
                    <h2>DANH MỤC SẢN PHẨM</h2>
                </div>
                <div class="category_product-main">
                <?php
                        // Truy vấn để lấy dữ liệu từ bảng category_product
                        $sql = "SELECT Src_CP, Src_Button FROM category_product";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '
                                    <div class="category_product-items">
                                        <div class="category_product-items-image">
                                            <img src="' . $row["Src_CP"] . '" alt="Product Image">
                                        </div>
                                        
                                        <div class="category_product-items-button">
                                            <a href="' . $row["Src_Button"] . '">
                                                <button>Khám phá</button>
                                            </a>
                                        </div>
                                </div>';
                            }
                        } else {
                            echo "Không có dữ liệu trong bảng category_product.";
                        }
                        ?>
                </div>
            </div>
            <div class="new_product">
    <h2>SẢN PHẨM MỚI NHẤT</h2>
    <div class="new_product-list">
        <?php
        // Truy vấn để lấy 5 sản phẩm mới nhất từ bảng infor_product
        $sqlNewProducts = "SELECT * FROM infor_product ORDER BY Date_IP DESC LIMIT 5";
        $resultNewProducts = $conn->query($sqlNewProducts);

        if ($resultNewProducts->num_rows > 0) {
            while ($rowNewProduct = $resultNewProducts->fetch_assoc()) {
                echo '<div class="new_product-item">';
                echo '<a href="infor_product.php?product_id=' . $rowNewProduct['ID_IP'] . '">';
                echo '<img src="' . $rowNewProduct['src_IP'] . '" alt="' . $rowNewProduct['Name_IP'] . '">';
                echo '<h4 class="new_product-name">' . $rowNewProduct['Name_IP'] . '</h4>';
                echo '<h4 class="new_product-price">' . $rowNewProduct['Price_IP'] . ' VNĐ</h4>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>Không có sản phẩm mới nào.</p>';
        }
        $conn->close();
        ?>
    </div>
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