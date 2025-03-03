<?php
session_start();
include_once("../db/db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $name = $_POST['name'];
    $tel = $_POST['tel'];

    if (!is_numeric($tel)) {
        echo "<script>alert('กรุณากรอกเบอร์โทรเป็นตัวเลข'); window.history.back();</script>";
        exit;
    }

    $sql_ins = "INSERT INTO `tb_member`(`m_user`, `m_pass`, `m_name`, `m_phone`) 
    VALUES ('$username','$pass','$name','$tel')";
    if ($conn->query($sql_ins) === true) {
        echo "<script>alert('เพิ่ม $username สำเร็จ'); window.location='../pages/user_manage.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
    }
}
