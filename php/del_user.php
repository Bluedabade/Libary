<?php
session_start();
include_once("../db/db.php");
if(isset($_GET['m_id'])){
    $m_id = $_GET['m_id'];
    $sql_del = "DELETE FROM `tb_member` WHERE `m_id` = '$m_id'";
    if($conn -> query($sql_del) === true){
        echo "<script>alert('ทำรายการสำเร็จ'); window.location='../pages/user_manage.php';</script>";
    }
}
?>