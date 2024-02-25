<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển thị Giỏ hàng</title>
    <style>
        /* Style for the table */
        .display_cart table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .display_cart table,
        th,
        td {
            border: 1px solid #ddd;
        }

        .display_cart th,
        td {
            padding: 10px;
            text-align: left;
        }

        .display_cart th {
            background-color: #f2f2f2;
        }

        /* Style for form textarea and buttons */
        .display_cart form textarea {
            width: 115px;
            height: 100px;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow-wrap: break-word;
            white-space: normal;
            writing-mode: horizontal-tb;
        }

        .display_cart form input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            border: none;
        }

        .display_cart form input[type="submit"] {
            background-color: #c00000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            margin-bottom: 10px;
            width:120px;
        }

        .display_cart form input[type="submit"]:hover {
            background-color: #7f0000;
        }
    </style>
</head>

<body>
    <div class="display_cart">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "webfastfood";
        $conn = new mysqli($servername, $username, $password, $database);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'accept_') === 0) {
                    $idCart = substr($key, strlen('accept_'));
                    $OrderStatus = "Đang Giao";
                    $sql = "UPDATE cart SET OrderStatus_Cart='$OrderStatus' WHERE ID_Cart='$idCart'";
                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<p>Bạn đã chấp nhận đơn hàng.</p>';
                    } else {
                        echo '<p>Lỗi: ' . $conn->error . '</p>';
                    }
                } elseif (strpos($key, 'complete_') === 0) {
                    $idCart = substr($key, strlen('complete_'));

                    $sql = "DELETE FROM cart WHERE ID_Cart='$idCart'";
                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<p>Xóa đơn hàng thành công.</p>';
                    } else {
                        echo '<p>Lỗi khi xóa đơn hàng: ' . $conn->error . '</p>';
                    }
                }
            }
        }

        // Lấy dữ liệu từ bảng cart
        $sql = "SELECT * FROM cart";
        $result = $conn->query($sql);

        echo '<form method="post">';
        echo '<table>';
        echo '<tr><th>ID</th><th>Tên khách hàng</th><th>Số điện thoại</th><th>Địa chỉ</th><th>Nội dung đơn hàng</th><th>Tổng tiền</th><th>Trạng thái</th><th>Thao tác</th></tr>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td> <input type="text" name="id_cart_' . $row['ID_Cart'] . '" value="' . $row['ID_Cart'] . '" size="3px"></td>';
                echo '<td> <input type="text" name="name_cart_' . $row['ID_Cart'] . '" value="' . $row['Name_Cart'] . '"size="10px"></td>';
                echo '<td> <input type="text" name="phone_cart_' . $row['ID_Cart'] . '" value="' . $row['PhoneNumber_Cart'] . '"size="10px"></td>';
                echo '<td> <textarea name="address_cart_' . $row['ID_Cart'] . '">' . $row['Address_Cart'] . '</textarea></td >';
                echo '<td> <textarea name="content_cart_' . $row['ID_Cart'] . '">' . $row['content_Cart'] . '</textarea></td>';
                echo '<td> <input type="text" name="total_' . $row['ID_Cart'] . '" value="' . $row['Total'] . '"size="3px"></td>';
                echo '<td> <input type="text" name="OrderStatus_' . $row['ID_Cart'] . '" value="' . $row['OrderStatus_Cart'] . '"size="7px" readonly></td>';
                echo '<td>
                        <input type="submit" name="accept_' . $row['ID_Cart'] . '" value="Chấp nhận">
                        <input type="submit" name="complete_' . $row['ID_Cart'] . '" value="Hoàn thành">
                      </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7">Không có dữ liệu</td></tr>';
        }

        echo '</table>';
        echo '</form>';
        $conn->close();
        ?>
    </div>
</body>

</html>
