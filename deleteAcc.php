<?php
$conn = new mysqli("localhost", "root", "", "webfastfood");

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
?>
    <script>
        var confirmed = confirm("Bạn có chắc chắn muốn xóa tài khoản của mình không?");
        if (confirmed) {
            var deleteConfirmed = true;
        } else {
            var deleteConfirmed = false;
        }

        // Chuyển biến JavaScript vào PHP bằng cách sử dụng document.write
        document.write('<?php
            if (isset($username) && isset($deleteConfirmed) && $deleteConfirmed) {
                $sqlDelete = "DELETE FROM infor_customer WHERE UserName_Cus = '$username'";
                $result = $conn->query($sqlDelete);

                if ($result) {
                    echo 'alert("Xóa tài khoản thành công");';
                    echo 'window.location.href = "home.php";';
                } else {
                    echo 'alert("Xóa tài khoản thất bại");';
                }

                session_destroy();
            } else {
               
            }
        ?>');
    </script>
<?php
}
?>