<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webfastfood";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
    <script src = "bootstrap/js/bootstrap.bundle.min.js" ></script>
    <title>Giỏ hàng</title>
    <style>
        .container_HistoryCart {
    margin: 20px;
}

.order-history {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.order-history h2 {
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

.order-history table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.order-history th, .order-history td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.order-history th {
    background-color:#c00000;
    color: white;
}

.order-history ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.order-history li {
    margin-bottom: 5px;
}
.back-button {
    margin-top: 20px;
}

.back-button a {
    background-color: #c00000; /* Your primary color */
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.back-button a:hover {
    background-color: #800000; /* Darker shade for hover effect */
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
                        <li class="header__funtcion-items"><a href="menu.php?category_id=CP_1" style=" color: #c00000;"><img src="pic_header/menu.png">THỰC ĐƠN</a></li>
                        <li class="header__funtcion-items"><a href="contact.php"><img src="pic_header/Contact.png">LIÊN HỆ</a></li>
                        <li class="header__funtcion-items"><a href="AboutYou.php" style=" color: #c00000;"><img src="pic_header/about.png">Tài khoản của bạn</a></li>
                    </ul>
                </div>
            </div>
        </header>
     <div class="container_HistoryCart">
      <?php 
      if (isset($_SESSION['username'])) {
        // Hiển thị đơn hàng cho khách hàng đã đăng nhập
        $sql_orders = "SELECT * FROM cart WHERE ID_Cus = (SELECT ID_Cus FROM infor_customer WHERE UserName_Cus = ?) AND OrderStatus_Cart != 'Đã giao hàng'";
        $stmt_orders = $conn->prepare($sql_orders);
        $stmt_orders->bind_param("s", $_SESSION['username']);
        $stmt_orders->execute();
        $result_orders = $stmt_orders->get_result();
    
        if ($result_orders->num_rows > 0) {
            // Hiển thị danh sách đơn hàng
            echo '<div class="order-history">';
            echo '<h2>Đơn hàng đã đặt</h2>';
            echo '<table>';
            echo '<tr>';
            echo '<th>ID Đơn hàng</th>';
            echo '<th>Tên người nhận</th>';
            echo '<th>Số điện thoại</th>';
            echo '<th>Địa chỉ giao hàng</th>';
            echo '<th>Nội dung đơn hàng</th>';
            echo '<th>Tổng tiền</th>';
            echo '<th>Trạng thái</th>';
            echo '</tr>';
            while ($order = $result_orders->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $order['ID_Cart'] . '</td>';
                echo '<td>' . $order['Name_Cart'] . '</td>';
                echo '<td>' . $order['PhoneNumber_Cart'] . '</td>';
                echo '<td>' . $order['Address_Cart'] . '</td>';
                echo '<td>';
                $content = json_decode($order['content_Cart'], true);
                echo '<ul>';
                foreach ($content as $productName => $quantity) {
                    echo '<li>' . $productName . ' - Số lượng: ' . $quantity . '</li>';
                }
                echo '</ul>';
                echo '</td>';
                echo '<td>' . $order['Total'] . ' VNĐ</td>';
                echo '<td>' . $order['OrderStatus_Cart'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>Không có đơn hàng nào.</p>';
        }
    } else {
        // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        header('Location: Login.php');
        exit();
    }
      ?>
<div class="back-button">
    <a href="menu.php?category_id=CP_1">Đặt hàng</a>
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