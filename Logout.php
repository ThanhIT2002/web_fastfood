<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "webfastfood";
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Truy vấn để lấy ID_Cus từ bảng infor_customer dựa trên username
    $sql = "SELECT ID_Cus FROM infor_customer WHERE UserName_Cus = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy ID_Cus từ kết quả truy vấn
        $row = $result->fetch_assoc();
        $idCus = $row['ID_Cus'];

        // Kiểm tra nếu ID_Cus bắt đầu bằng "AD_" hoặc "CT_" và chuyển hướng tương ứng
        if (strpos($idCus, 'AD') === 0) {
            ?>
            <script>
                var confirmed = confirm("Bạn có chắc chắn muốn đăng xuất không?");
                if (confirmed) {
                    window.location.href = "unsset.php";
                } else {
                    window.location.href = "home_Admin.php?category=banners.php";
                }
            </script>
            <?php
        } elseif (strpos($idCus, 'CT') === 0) {
            ?>
            <script>
                var confirmed = confirm("Bạn có chắc chắn muốn đăng xuất không?");
                if (confirmed) {
                    window.location.href = "unsset.php";
                } else {
                    window.location.href = "home.php";
                }
            </script>
            <?php
        } else {
            // Trường hợp khác, chẳng hạn nếu không bắt đầu bằng "AD_" hoặc "CT_"
            echo "Invalid ID_Cus format!";
        }
    } else {
        echo "Username không tồn tại trong hệ thống!";
    }

    $conn->close();
} else {
    // Nếu không có phiên đăng nhập, quay lại trang chủ
    header('Location: home.php');
    exit();
}
?>
