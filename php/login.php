<?php
session_start();
include_once("../db/db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $sql_me = "SELECT * FROM `tb_member` WHERE `m_user` = '$username'";
    $result_me = $conn->query($sql_me);
    $row_me = $result_me->fetch_assoc();
    if (!empty($row_me) && $row_me['m_pass'] == $pass) {
        $_SESSION['a_id'] = $row_me['m_id'];
        echo "<script>alert('ยินดีต้อนรับ'); window.location='../pages/user_manage.php';</script>";
    } else {
        echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านผิด'); window.history.back();</script>";
    }
}
