<?php
session_start();
include_once("../db/db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $m_id = $_POST['m_id'];

    if (empty($username) || empty($pass) || empty($name) || empty($tel) || empty($m_id)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit;
    }

    if (!is_numeric($tel)) {
        echo "<script>alert('กรุณากรอกเบอร์โทรเป็นตัวเลข'); window.history.back();</script>";
        exit;
    }

    $sql_up = "UPDATE `tb_member`
    SET `m_user`='$username'
    ,`m_pass`='$pass'
    ,`m_name`='$name'
    ,`m_phone`='$tel'
     WHERE `m_id` = '$m_id'";
    if ($conn->query($sql_up) === true) {
        echo "<script>alert('แก้ไขข้อมูลของ $username สำเร็จ'); window.location='../pages/user_manage.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
    }
}
