<?php
session_start();
include_once("../db/db.php");
$pagename = "book_manage.php";
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
            <div class="col">
                <div class="row mt-3">
                    <div class="col-md-6 d-flex">
                        <form action="book_manage.php" method="post" class="d-flex w-100" role="search">
                            <input class="form-control me-2" name="search" type="search" placeholder="ค้นหา..." aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">ค้นหา</button>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#add_book">
                            เพิ่มหนังสือ
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="add_book" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มหนังสือ</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../php/book_add.php" method="post" class="m-1">
                                <div class="mb-3 mt-2">
                                    <label for="exampleInputEmail1" class="form-label">รหัสหนังสือ</label>
                                    <input name="b_id" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="exampleInputEmail1" class="form-label">ชื่อหนังสือ</label>
                                    <input name="b_name" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">ผู้แต่ง</label>
                                    <input name="writer" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="exampleInputEmail1" class="form-label">ประเภท</label>
                                    <input name="cate" type="number" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="exampleInputEmail1" class="form-label">ราคา</label>
                                    <input name="price" type="number" maxlength="10" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
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
                        <th scope="col">รหัสหนังสือ</th>
                        <th scope="col">ชื่อหนังสือ</th>
                        <th scope="col">ผู้แต่ง</th>
                        <th scope="col">ประเภท</th>
                        <th scope="col">ราคา</th>
                        <th scope="col">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['search'])) {
                        $search = $_POST['search'];
                        $sql_b = "SELECT * FROM `tb_book` WHERE `b_id` LIKE '%$search%' OR `b_name`LIKE '%$search%';";
                    } else {
                        $sql_b = "SELECT * FROM `tb_book`";
                    }
                    $result_b = $conn->query($sql_b);
                    if ($result_b->num_rows > 0):
                    while ($row_b = $result_b->fetch_assoc()):
                    ?>
                        <tr>
                            <th scope="row"><?php echo $row_b['id'] ?></th>
                            <td><?php echo $row_b['b_id'] ?></td>
                            <td><?php echo $row_b['b_name'] ?></td>
                            <td><?php echo $row_b['b_writer'] ?></td>
                            <td><?php echo $row_b['b_category'] ?></td>
                            <td><?php echo $row_b['b_price'] ?></td>
                            <td class="" style="width: 20rem;">
                                <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#edit_user<?php echo $row_b['id'] ?>">
                                    แก้ไขข้อมูล
                                </button>
                                <div class="modal fade" id="edit_user<?php echo $row_b['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูลสมาชิกของ <?php echo $row_b['b_id'] ?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../php/book_edit.php" method="post" class="m-1">
                                                    <input hidden value="<?php echo $row_b['id'] ?>" name="id" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                                    <div class="mb-3 mt-2">
                                                        <label for="exampleInputEmail1" class="form-label">รหัสหนังสือ</label>
                                                        <input value="<?php echo $row_b['b_id'] ?>" name="b_id" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                                    </div>
                                                    <div class="mb-3 mt-2">
                                                        <label for="exampleInputEmail1" class="form-label">ชื่อหนังสือ</label>
                                                        <input value="<?php echo $row_b['b_name'] ?>" name="b_name" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label">ผู้แต่ง</label>
                                                        <input value="<?php echo $row_b['b_writer'] ?>" name="writer" type="text" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="">
                                                    </div>
                                                    <div class="mb-3 mt-2">
                                                        <label for="exampleInputEmail1" class="form-label">ประเภท</label>
                                                        <input value="<?php echo $row_b['b_category'] ?>" name="cate" type="number" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
                                                    </div>
                                                    <div class="mb-3 mt-2">
                                                        <label for="exampleInputEmail1" class="form-label">ราคา</label>
                                                        <input value="<?php echo $row_b['b_price'] ?>" name="price" type="number" maxlength="10" class="form-control" placeholder="กรุณากรอกข้อมูล" required id="" aria-describedby="">
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


                                <a onclick="return confirm('ยืนยันการลบหนังสือ <?php echo $row_b['b_id'] ?> ?')" name="" id="" class="btn btn-danger" href="../php/book_del.php?id=<?php echo $row_b['id'] ?>" role="button">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                            <td class="text-center" colspan="7">ไม่พบข้อมูลที่ค้นหา</td>
                        <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</body>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</html>