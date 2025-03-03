<?php
session_start();
include_once("../db/db.php");
$pagename = "user_manage.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรายชื่อสมาชิก</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/fonts.css">

</head>

<body>
    <?php
    include_once("../components/nav.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="row mt-3">
                    <div class="col-md-6 d-flex">
                        <form action="user_manage.php" method="post" class="d-flex w-100" role="search">
                            <input class="form-control me-2" name="search" type="search" placeholder="ค้นหา..." aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">ค้นหา</button>
                        </form>
                    </div>

                    <div class="col-md-6 text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_user">
                            เพิ่มสมาชิก
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="add_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มข้อมูลสมาชิก</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="../php/add_user.php" method="post" class="m-1">
                                    <div class="mb-3 mt-2">
                                        <label for="exampleInputEmail1" class="form-label">ชื่อผู้ใช้</label>
                                        <input name="username" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">รหัสผ่าน</label>
                                        <input name="pass" type="password" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="">
                                    </div>
                                    <div class="mb-3 mt-2">
                                        <label for="exampleInputEmail1" class="form-label">ชื่อ-สกุล</label>
                                        <input name="name" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                    </div>
                                    <div class="mb-3 mt-2">
                                        <label for="exampleInputEmail1" class="form-label">เบอร์โทร</label>
                                        <input name="tel" type="tel" maxlength="10" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>


                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ชื่อผู้ใช้</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">เบอร์โทร</th>
                            <th scope="col">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['search'])) {
                            $search = $_POST['search'];
                            $sql_me = "SELECT * FROM `tb_member` WHERE `m_permis` = 'user' AND `m_user` LIKE '%$search%' OR `m_name` LIKE '%$search%'";
                        } else {
                            $sql_me = "SELECT * FROM `tb_member` WHERE `m_permis` = 'user'";
                        }
                        $result_me = $conn->query($sql_me);
                        if ($result_me->num_rows > 0):
                            while ($row_me = $result_me->fetch_assoc()):
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $row_me['m_id'] ?></th>
                                    <td><?php echo $row_me['m_user'] ?></td>
                                    <td><?php echo $row_me['m_name'] ?></td>
                                    <td><?php echo $row_me['m_phone'] ?></td>
                                    <td class="" style="width: 20rem;">
                                        <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#edit_user<?php echo $row_me['m_id'] ?>">
                                            แก้ไขข้อมูล
                                        </button>
                                        <div class="modal fade" id="edit_user<?php echo $row_me['m_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูลสมาชิกของ <?php echo $row_me['m_user'] ?></h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../php/edit_user.php" method="post" class="m-1">
                                                            <div class="mb-3 mt-2">
                                                                <label for="exampleInputEmail1" class="form-label">ชื่อผู้ใช้</label>
                                                                <input value="<?php echo $row_me['m_user'] ?>" name="username" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                                                <input hidden value="<?php echo $row_me['m_id'] ?>" name="m_id" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleInputPassword1" class="form-label">รหัสผ่าน</label>
                                                                <input value="<?php echo $row_me['m_pass'] ?>" name="pass" type="password" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="">
                                                            </div>
                                                            <div class="mb-3 mt-2">
                                                                <label for="exampleInputEmail1" class="form-label">ชื่อ-สกุล</label>
                                                                <input value="<?php echo $row_me['m_name'] ?>" name="name" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                                            </div>
                                                            <div class="mb-3 mt-2">
                                                                <label for="exampleInputEmail1" class="form-label">เบอร์โทร</label>
                                                                <input value="<?php echo $row_me['m_phone'] ?>" name="tel" type="tel" maxlength="10" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a onclick="return confirm('ยืนยันการลบผู้ใช้ <?php echo $row_me['m_user'] ?> ?')" name="" id="" class="btn btn-danger" href="../php/del_user.php?m_id=<?php echo $row_me['m_id'] ?>" role="button">ลบ</a>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <td class="text-center" colspan="5">ไม่พบข้อมูลที่ค้นหา</td>
                        <?php endif; ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</html>