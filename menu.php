<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webfastfood";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
$selectedCategoryID = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$selectedCategoryName = null;

// Nếu có danh mục được chọn, lấy tên của nó
if ($selectedCategoryID) {
    $sqlCategoryName = "SELECT Name_CP FROM category_product WHERE ID_CP = '$selectedCategoryID'";
    $resultCategoryName = $conn->query($sqlCategoryName);
    
    if ($resultCategoryName->num_rows > 0) {
        $rowCategoryName = $resultCategoryName->fetch_assoc();
        $selectedCategoryName = $rowCategoryName['Name_CP'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleOfMenu.css" type="text/css">
    <link rel="stylesheet" href="header.css" type="text/css">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <script src = "bootstrap/js/bootstrap.bundle.min.js" ></script>
</script>
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

     <div class="container_main_menu">
     <?php
    $categories = [];
    $sql = "SELECT * FROM category_product";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
?>
        <div class="category_menu">
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <input type="hidden" name="category_id" value="<?php echo $category['ID_CP']; ?>">
                <a class="category_list <?php echo ($selectedCategoryID == $category['ID_CP']) ? 'active' : ''; ?>"  href="?category_id=<?php echo $category['ID_CP']; ?>">
                    <?php echo $category['Name_CP']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
        <div class="product_main">
        <?php
if (isset($_GET['category_id'])) {
    $selectedCategoryID = $_GET['category_id'];
    $sql = "SELECT infor_product.*, category_product.Name_CP
            FROM infor_product
            LEFT JOIN category_product ON infor_product.ID_CP = category_product.ID_CP
            WHERE infor_product.ID_CP = '$selectedCategoryID';";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    echo '<h2 class="product_cart_tittle">' . $selectedCategoryName . '</h2>';
    echo '<div class="product_cart_main">';

    // Hiển thị thông tin sản phẩm
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product_cart_menu">';
        echo '<form method="post" action="add_to_cart.php">';
        echo '<input type="hidden" name="product_id" value="' . $row['ID_IP'] . '">';
        echo '<a href="infor_product.php?product_id=' . $row['ID_IP'] . '">';
        echo '<div class= "pic_cart_details">';
        echo '<img src="' . $row['src_IP'] . '" alt="' . $row['Name_IP'] . '">';
        echo'</div>';
        echo '<div class="product_cart_details">';
        echo '<h4 class="product_cart_name">' . $row['Name_IP'] . '</h4>';
        echo '<h3 class="product_cart_price" style="color:#c00000">Giá : ' . $row['Price_IP'] . ' VNĐ</h3>';
        echo '</div>';
        echo '</a>';
        echo '<input type="hidden" name="category_id" value="'.$selectedCategoryID.'">';
        echo '<button type="submit" name="add_to_cart">Thêm vào giỏ hàng</button>';
        echo '</form>';
        echo '</div>';
    }

    echo '</div>';
} else {
    
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