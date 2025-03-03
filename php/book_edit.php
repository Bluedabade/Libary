<?php
session_start();
include_once("../db/db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $b_id = $_POST['b_id'];
    $b_name = $_POST['b_name'];
    $writer = $_POST['writer'];
    $cate = $_POST['cate'];
    $price = $_POST['price'];

    if (!is_numeric($price)) {
        echo "<script>alert('กรุณากรอกราคา'); window.history.back();</script>";
        exit;
    }
    if (!is_numeric($cate)) {
        echo "<script>alert('กรุณากรอกประเภทหนังสือเป็นตัวเลข'); window.history.back();</script>";
        exit;
    }

    $sql_up = "UPDATE `tb_book` 
    SET `b_id`='$b_id'
    ,`b_name`='$b_name'
    ,`b_writer`='$writer'
    ,`b_category`='$cate'
    ,`b_price`='$price'
     WHERE id = '$id'";
    if ($conn->query($sql_up) === true) {
        echo "<script>alert('แก้ไข $b_id สำเร็จ'); window.location='../pages/book_manage.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
    }
}
