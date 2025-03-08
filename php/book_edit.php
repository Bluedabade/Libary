<?php
session_start();
include_once("../db/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $b_name = $_POST['b_name'];
    $writer = $_POST['writer'];
    $cate = $_POST['cate'];
    $price = $_POST['price'];

    if (!is_numeric($price)) {
        echo "<script>alert('กรุณากรอกราคาให้ถูกต้อง'); window.history.back();</script>";
        exit;
    }
    if (!is_numeric($cate)) {
        echo "<script>alert('กรุณากรอกประเภทหนังสือเป็นตัวเลข'); window.history.back();</script>";
        exit;
    }

    $sql_get = "SELECT * FROM `tb_book` WHERE id = '$id'";
    $result = $conn->query($sql_get);
    $row = $result->fetch_assoc();
    $old_image = $row['b_img'];

    if (!empty($_FILES["book_img"]["name"])) {
        $target_dir = "../uploads/";
        
        $imageFileType = pathinfo($_FILES["book_img"]["name"], PATHINFO_EXTENSION);
        $new_image_name = uniqid("book_") . "." . $imageFileType;
        $target_file = $target_dir . $new_image_name;

        if (move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file)) {
            if (!empty($old_image) && file_exists($target_dir . $old_image)) {
                unlink($target_dir . $old_image);
            }

            $sql_up = "UPDATE `tb_book` 
                SET `b_name`='$b_name', `b_writer`='$writer', `b_category`='$cate', `b_price`='$price', `b_img`='$new_image_name'
                WHERE id = '$id'";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ'); window.history.back();</script>";
            exit;
        }
    } else {
        $sql_up = "UPDATE `tb_book` 
            SET `b_name`='$b_name', `b_writer`='$writer', `b_category`='$cate', `b_price`='$price'
            WHERE id = '$id'";
    }

    if ($conn->query($sql_up) === TRUE) {
        echo "<script>
            alert('แก้ไขข้อมูลสำเร็จ');
            window.location='../pages/book_manage.php';
        </script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
    }
}
?>
