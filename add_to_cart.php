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
                        <li class="header__funtcion-items"><a href="AboutYou.php" style=" color: #c00000;"><img src="pic_header/about.png">Tài khoản của bạn</a></li>
                    </ul>
                </div>
            </div>
        </header>
     <div class="container_cart">
            
<?php
 $total = 0; 

// Xóa sản phẩm khỏi giỏ hàng nếu có yêu cầu
if (isset($_GET['remove']) && isset($_GET['product_id'])) {
    $product_id_to_remove = $_GET['product_id'];

    if (isset($_SESSION['cart'][$product_id_to_remove])) {
        unset($_SESSION['cart'][$product_id_to_remove]);
    }

    // Log thông báo
    error_log("Removed product $product_id_to_remove from cart");

    // Chuyển hướng để tránh việc xóa dữ liệu khi người dùng làm mới trang
    header('Location: add_to_cart.php');
    exit();
}

// Xóa tất cả sản phẩm khỏi giỏ hàng nếu có yêu cầu
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);

    // Log thông báo
    error_log("Cleared all products from cart");

    // Chuyển hướng để tránh việc xóa dữ liệu khi người dùng làm mới trang
    header('Location: menu.php');
    exit();
}
// Kiểm tra có yêu cầu thêm sản phẩm vào giỏ hàng không
if (isset($_POST['add_to_cart'])) {
        // Kiểm tra lại xem người dùng có đăng nhập không (điều này không thực sự cần thiết nếu đã kiểm tra ở đầu mã)
        if (!isset($_SESSION['username'])) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            header('Location: Login.php');
            exit();
        }
    // Lấy ID sản phẩm từ biểu mẫu
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];
    // Kiểm tra xem ID sản phẩm có hợp lệ không
    if (!empty($product_id)) {
        // Khởi tạo giỏ hàng nếu nó chưa tồn tại trong phiên
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        if (isset($_SESSION['cart'][$product_id])) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm vào với số lượng là 1
            $_SESSION['cart'][$product_id] = [
                'quantity' => 1,
                'category_id' => $category_id, // Lưu category_id trong giỏ hàng
            ];
        }
        header("Location: menu.php?category_id=$category_id");
        // Log thông báo
        error_log("Added product $product_id to cart with category $category_id");
    }
    else {
        echo'<div class="cart_empty">';
            echo '<h2>Giỏ hàng rỗng đặt hàng ngay nào !!!</h2>';
            echo '<a href="menu.php">Đặt hàng</a>';
        echo '</div>';
    }
}

// Hiển thị thông tin giỏ hàng
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
   echo'<div class= "content_cart">';
   echo '<div class="order-history" style ="color : #c00000">';
   if (isset($_SESSION['username'])) {
       echo '<a href="History_Cart.php">Đơn hàng đã đặt</a>';
   }
    echo '</div>';
    if (isset($_POST['decrease_quantity'])) {
        $product_id_to_update = $_POST['product_id'];
            $current_quantity = $_SESSION['cart'][$product_id_to_update]['quantity'];
                $new_quantity = max(1, $current_quantity - 1);
            // Cập nhật số lượng trong giỏ hàng
            $_SESSION['cart'][$product_id_to_update]['quantity'] = $new_quantity;
    }
    if (isset($_POST['increase_quantity'])) {
        $product_id_to_update = $_POST['product_id'];
        $current_quantity = $_SESSION['cart'][$product_id_to_update]['quantity'];
          $new_quantity = $current_quantity + 1;
            // Cập nhật số lượng trong giỏ hàng
            $_SESSION['cart'][$product_id_to_update]['quantity'] = $new_quantity;
    }
   echo '<div class ="infor_cart">';
   echo '<div class = "content_cart_main">';
   echo '<h2>Thông Tin Giỏ Hàng</h2>';
   echo '<table border="1">';
   echo '<tr><th>Ảnh</th><th>Tên Sản Phẩm</th><th>Giá</th><th>Số Lượng</th><th>Xóa</th></tr>';
   $total = 0; 
   // Lặp qua các sản phẩm trong giỏ hàng
   foreach ($_SESSION['cart'] as $product_id => $item) {
       // Truy vấn cơ sở dữ liệu để lấy thông tin chi tiết về sản phẩm
       $sql_product = "SELECT * FROM infor_product WHERE ID_IP = '$product_id'";
       $result_product = $conn->query($sql_product);
   
       if ($result_product->num_rows > 0) {
           $product_info = $result_product->fetch_assoc();
           $product_total = $item['quantity'] * $product_info['Price_IP'];
           $total += $product_total;
           
           // Hiển thị thông tin chi tiết
           echo '<tr>';
           echo '<td class= "pic_cart">';
           echo '<img src="' . $product_info['src_IP'] . '" alt="' .$product_info['Name_IP'] . '">';
           echo '</td>';
           echo '<td>' . $product_info['Name_IP'] . '</td>';
           echo '<td>' . $product_info['Price_IP'] . ' VNĐ</td>';
           echo '<td>';
           echo '<form method="post" action="">';
           echo '<div class = "quantity" >';
           // Nút giảm số lượng
           echo '<button type="submit" name="decrease_quantity" value="' . $product_id . '"> - </button>';
           
           // Hiển thị số lượng
           echo $item['quantity'];
           
           // Nút tăng số lượng
           echo '<button type="submit" name="increase_quantity" value="' . $product_id . '"> + </button>';
           echo '</div>';
           echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
           echo '</form>';
           echo '</td>';
           echo '<td><a href="add_to_cart.php?remove=true&product_id=' . $product_id . '">Xóa</a></td>';
           echo '</tr>';
       }
   }
   echo '</table>';
    echo'</div>';
   echo '<p><a href="add_to_cart.php?clear=true">Xóa Tất Cả Sản Phẩm</a></p>';
   echo '<div class="total_cart">' ;
   echo '<p>Tổng tiền là : '.$total.' VNĐ</p>';
   echo '</div>';
   echo '</div>';
   echo '<div class = "infor_customer">';
   echo '<h2>Thông Tin Khách Hàng</h2>';
   echo '<form method="post" action="">';
   echo '<table>';
   echo '<tr>';
   echo '<td><label for="customer_name">Họ tên:</label></td>';
   echo '<td><input type="text" name="customer_name" required></td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td><label for="phone_number">Số điện thoại:</label></td>';
   echo '<td><input type="text" name="phone_number" required></td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td><label for="delivery_address">Địa chỉ giao hàng:</label></td>';
   echo '<td><input type="text" name="delivery_address" required></td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td></td>';
   echo '<td><button type="submit" name="place_order">Đặt Hàng</button></td>';
   echo '</tr>';
   echo '</table>';
   echo '</form>';
   echo '</div>';
   echo '</div>';
} else {
    echo '<div class="order-history" style ="color : #c00000">';
    echo'<div class="cart_empty">';
    echo '<h2>Giỏ hàng rỗng đặt hàng ngay nào !!!</h2>';
    echo '<a class="place-order-button" href="menu.php?category_id=CP_1">Đặt hàng</a>';
    if (isset($_SESSION['username'])) {
        echo '<a href="History_Cart.php" class="place-order-button">Đơn hàng đã đặt</a>';
    }
    echo '</div>';
    echo '</div>';
}
// Kiểm tra có yêu cầu đặt hàng không
if (isset($_POST['place_order'])) {
    // Lấy thông tin người dùng
    $customer_name = $_POST['customer_name'];
    $phone_number = $_POST['phone_number'];
    $delivery_address = $_POST['delivery_address'];

    // Kiểm tra giỏ hàng không rỗng
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Khởi tạo mảng để lưu thông tin sản phẩm
        $products_info = [];
        $totalAmount = 0;
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $product_quantity = $item['quantity'];

            // Truy vấn cơ sở dữ liệu để lấy thông tin chi tiết về sản phẩm
            $sql_product = "SELECT * FROM infor_product WHERE ID_IP = '$product_id'";
            $result_product = $conn->query($sql_product);

            if ($result_product->num_rows > 0) {
                $product_info = $result_product->fetch_assoc();

                // Thêm thông tin sản phẩm vào mảng
                $products_info[$product_info['Name_IP']] = $product_quantity;
                $totalAmount += $product_info['Price_IP'] * $product_quantity;
            }
        }

        // Chuyển mảng thành chuỗi JSON
        $products_json = json_encode($products_info, JSON_UNESCAPED_UNICODE);
        $OrderStatus = "Đang chờ";
        // Thêm đơn hàng vào cơ sở dữ liệu
        $insert_cart_sql = "INSERT INTO cart (Name_Cart, PhoneNumber_Cart, Address_Cart, content_Cart, Total,OrderStatus_Cart,ID_Cus) 
                            VALUES ('$customer_name', '$phone_number', '$delivery_address', '$products_json', '$totalAmount','$OrderStatus','$id_cus')";

        $result_insert_cart = $conn->query($insert_cart_sql);

        // Kiểm tra việc chèn dữ liệu có thành công không
        if ($result_insert_cart) {
            // Xóa giỏ hàng trong phiên sau khi đặt hàng
            unset($_SESSION['cart']);
            // Chuyển hướng đến trang thành công hoặc thực hiện các hành động cần thiết khác
            echo '<script>window.location.href = "OrderSuccess.php";</script>';
            exit();
        } else {
            // Ghi log thông báo lỗi
            error_log("Lỗi khi đặt hàng: " . $conn->error);

            // Hiển thị thông báo lỗi hoặc chuyển hướng đến trang lỗi khác
            echo 'Lỗi khi đặt hàng. Vui lòng thử lại.';
        }
    }
}
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