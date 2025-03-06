<?php
session_start();
include_once("../db/db.php");
$pagename = "borrow_manage.php";
if (isset($_POST['userid'])) {
    $m_user = $_POST['m_user'];
    $sql_me = "SELECT * FROM `tb_member` WHERE `m_user` ='$m_user'";
    $result_me = $conn->query($sql_me);
    $row_me = $result_me->fetch_assoc();
    if (!empty($row_me)) {
        $tb_name = "";
        $_SESSION['m_name'] = $row_me['m_name'];
    } else {
        $tb_name = "table-danger";
        $_SESSION['m_name'] = "ไม่พบ";
    }
}

if (isset($_POST['book_id'])) {
    $b_id = $_POST['b_id'];
    $sql_b = "SELECT * FROM `tb_book` WHERE `b_id` ='$b_id'";
    $result_b = $conn->query($sql_b);
    $row_b = $result_b->fetch_assoc();
    if (!empty($row_b)) {
        $tb_book = "";
        $_SESSION['b_name'] = $row_b['b_name'];
    } else {
        $tb_book = "table-danger";
        $_SESSION['b_name'] = "ไม่พบ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแรก</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/fonts.css">

</head>

<body>
    <?php
    include_once("../components/nav.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center mt-5">
                <div class="card d-flex" style="width: 35rem;">
                    <form action="./php/login.php" method="post" class="m-5">
                        <h1>ยืมหนังสือ</h1>
                        <div class="input-group mb-3">
                            <input value="<?php echo $m_user = isset($_POST['m_user']) ? $_POST['m_user'] : ""; ?>" type="text" class="form-control" name="m_user" placeholder="รหัสสมาชิก" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button formaction="borrow.php" name="userid" class="btn btn-outline-primary" type="submit" id="button-addon2">เพิ่ม</button>
                        </div>
                        <div class="input-group mb-3">
                            <input value="<?php echo $b_id = isset($_POST['b_id']) ? $_POST['b_id'] : ""; ?>" type="text" class="form-control" name="b_id" placeholder="รหัสหนังสือ" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button formaction="borrow.php" name="book_id" class="btn btn-outline-primary" type="submit" id="button-addon2">เพิ่ม</button>
                        </div>

                        <div class="">
                            <?php if (!empty($_SESSION['m_name']) || !empty($_SESSION['b_name'])): ?>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="<?php echo $tb_name ?>">ชื่อผู้ใช้</td>
                                            <td class="<?php echo $tb_name ?>" style="width: 15rem;"><?php echo isset($_SESSION['m_name']) ? $_SESSION['m_name'] : ""; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="<?php echo $tb_book ?>">ชื่อหนังสือ</td>
                                            <td class="<?php echo $tb_book ?>"><?php echo isset($_SESSION['b_name']) ? $_SESSION['b_name'] : ""; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>

                        <button type="submit d-flex" name="submit" class="btn btn-success">ยืนยัน</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</html>