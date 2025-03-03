<?php
session_start();
include_once("../db/db.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_del = "DELETE FROM `tb_book` WHERE `id` = '$id'";
    if ($conn->query($sql_del) === true) {
        echo "<script>alert('ทำรายการสำเร็จ'); window.location='../pages/book_manage.php';</script>";
    }
}
