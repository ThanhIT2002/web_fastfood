<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "webfastfood";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển Thị Liên Hệ</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Áp dụng white-space: pre-line cho cột Content_Contact */
        td:nth-child(5) {
            white-space: pre-line;
        }
        .feedback-button {
            background-color: #c00000; 
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px; 
            cursor: pointer;
            margin-right: 5px;
        }
        .feedback-button:hover {
            background-color: #7f0000;
        }
        .feedback-form input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: none; 
            border-radius: 4px;
        }
        .feedback-form textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            font-size: 14px;
            line-height: 1.5;
            min-height: 100px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="display_contact">
    <?php
    // Truy vấn dữ liệu từ bảng liên hệ
    $sql = "SELECT ID_Contact, Name_Contact, PhoneNumber_Contact, Address_Contact, Content_Contact FROM contact";
    $result = $conn->query($sql);

    echo '<form method="post" class="feedback-form">';
    echo '<table>';
    echo '<tr><th>ID Liên Hệ</th><th>Tên Người Liên Hệ</th><th>Số Điện Thoại</th><th>Địa Chỉ</th><th>Nội Dung</th></tr>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td> <input type="text" name="idContact_' . $row['ID_Contact'] . '" value="' . $row['ID_Contact'] . '" readonly></td>';
            echo '<td> <input type="text" name="nameContact_' . $row['ID_Contact'] . '" value="' . $row['Name_Contact'] . '" readonly></td>';
            echo '<td> <input type="text" name="phoneContact_' . $row['ID_Contact'] . '" value="' . $row['PhoneNumber_Contact'] . '" readonly></td>';
            echo '<td> <input type="text" name="addressContact_' . $row['ID_Contact'] . '" value="' . $row['Address_Contact'] . '" readonly></td>';
            echo '<td> <textarea name="contentContact_' . $row['ID_Contact'] . '" readonly>' . $row['Content_Contact'] . '</textarea></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6">Không có dữ liệu</td></tr>';
    }
    echo '</table>';
    echo '</form>';


    $conn->close();
    ?>
</div>
</body>
</html>
