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
    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
            border: none;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card img {
            height: 250px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .card-title {
            font-weight: bold;
            font-size: 1.2rem;
            color: #333;
        }

        .card-text {
            font-size: 0.9rem;
            color: #777;
        }

        .card-buttons {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .card:hover .card-buttons {
            opacity: 1;
        }

        /* ปรับปุ่มให้สวยขึ้น */
        .btn {
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .btn-warning {
            background-color: #FFC107;
            border: none;
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #FFA000;
        }

        .btn-danger {
            background-color: #DC3545;
            border: none;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #C82333;
        }
    </style>

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
                            <form action="../php/book_add.php" method="post" class="m-1" enctype="multipart/form-data">
                                <div class="mb-3 mt-2">
                                    <label class="form-label">รหัสหนังสือ</label>
                                    <input name="b_id" type="text" class="form-control" required>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label class="form-label">ชื่อหนังสือ</label>
                                    <input name="b_name" type="text" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ผู้แต่ง</label>
                                    <input name="writer" type="text" class="form-control" required>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label class="form-label">ประเภท</label>
                                    <input name="cate" type="number" class="form-control" required>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label class="form-label">ราคา</label>
                                    <input name="price" type="number" class="form-control" required>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label class="form-label">อัปโหลดรูปหนังสือ</label>
                                    <input type="file" name="book_img" class="form-control" accept="image/*" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <button type="submit" class="btn btn-primary">เพิ่มหนังสือ</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <?php
                $sql_b = "SELECT * FROM `tb_book`";
                $result_b = $conn->query($sql_b);
                if ($result_b->num_rows > 0):
                    while ($row_b = $result_b->fetch_assoc()):
                ?>
                        <div class="col-md-4 mb-4">
                            <div class="card position-relative">
                                <img src="../uploads/<?php echo $row_b['b_img']; ?>" class="card-img-top" alt="รูปหนังสือ">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row_b['b_name']; ?></h5>
                                    <p class="card-text">รหัสหนังสือ: <?php echo $row_b['b_id']; ?></p>
                                    <p class="card-text">ผู้แต่ง: <?php echo $row_b['b_writer']; ?></p>
                                    <p class="card-text">ประเภท: <?php echo $row_b['b_category']; ?></p>
                                    <p class="card-text">ราคา: <span style="color: #FF5722; font-weight: bold;"><?php echo $row_b['b_price']; ?> บาท</span></p>

                                    <!-- ปุ่มจะแสดงเมื่อ Hover -->
                                    <div class="card-buttons d-flex gap-2">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit_book<?php echo $row_b['id'] ?>">
                                            แก้ไข
                                        </button>
                                        <a onclick="return confirm('ยืนยันการลบหนังสือ?')" class="btn btn-danger" href="../php/book_del.php?id=<?php echo $row_b['id'] ?>">
                                            ลบ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal แก้ไข -->
                        <div class="modal fade" id="edit_book<?php echo $row_b['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">แก้ไขหนังสือ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../php/book_edit.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo $row_b['id'] ?>">

                                            <div class="mb-3">
                                                <label class="form-label">ชื่อหนังสือ</label>
                                                <input type="text" name="b_name" class="form-control" value="<?php echo $row_b['b_name']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">ผู้แต่ง</label>
                                                <input type="text" name="writer" class="form-control" value="<?php echo $row_b['b_writer']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">ประเภท</label>
                                                <input type="number" name="cate" class="form-control" value="<?php echo $row_b['b_category']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">ราคา</label>
                                                <input type="number" name="price" class="form-control" value="<?php echo $row_b['b_price']; ?>" required>
                                            </div>

                                            <!-- แสดงรูปปัจจุบัน -->
                                            <div class="mb-3">
                                                <label class="form-label">รูปปัจจุบัน</label><br>
                                                <img src="../uploads/<?php echo $row_b['b_img']; ?>" width="150" class="img-thumbnail">
                                            </div>

                                            <!-- Input อัปโหลดรูปใหม่ -->
                                            <div class="mb-3">
                                                <label class="form-label">อัปโหลดรูปใหม่</label>
                                                <input type="file" name="book_img" class="form-control" accept="image/*">
                                            </div>

                                            <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">ไม่พบหนังสือ</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
    </div>
</body>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</html>