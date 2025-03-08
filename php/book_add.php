<?php
include_once("../db/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $b_id = $_POST["b_id"];
    $b_name = $_POST["b_name"];
    $writer = $_POST["writer"];
    $cate = $_POST["cate"];
    $price = $_POST["price"];

    $target_dir = "../uploads/";
    $image_name = basename($_FILES["book_img"]["name"]);
    $target_file = $target_dir . $image_name;
    move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file);

    $sql = "INSERT INTO tb_book (b_id, b_name, b_writer, b_category, b_price, b_img) 
            VALUES ('$b_id', '$b_name', '$writer', '$cate', '$price', '$image_name')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('เพิ่มหนังสือสำเร็จ'); window.location='../pages/book_manage.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
