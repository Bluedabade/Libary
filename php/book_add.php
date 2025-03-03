<?php
session_start();
include_once("../db/db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $b_id = $_POST['b_id'];
    $b_name = $_POST['b_name'];
    $writter = $_POST['writer'];
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

    $sql_ins = "INSERT INTO `tb_book`(`b_id`, `b_name`, `b_writer`, `b_category`, `b_price`) 
    VALUES ('$b_id','$b_name','$writter','$cate','$price')";
    if ($conn->query($sql_ins) === true) {
        echo "<script>alert('เพิ่ม $b_id สำเร็จ'); window.location='../pages/book_manage.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
    }
}
