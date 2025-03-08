<?php
session_start();
include_once("../db/db.php");

$pagename = "borrow_manage.php";
unset($_SESSION['m_name']);
unset($_SESSION['b_name']);

$search = $_POST['search'] ?? "";

$sql = "SELECT br.br_id, br.br_date_br, br.br_date_rt, br.br_fine, 
               b.b_name, b.b_id, m.m_name, m.m_user
        FROM tb_borrow_book br
        JOIN tb_book b ON br.b_id = b.b_id
        JOIN tb_member m ON br.me_user = m.m_user ";

if (!empty($search)) {
    $sql .= " WHERE b.b_id LIKE ? OR m.m_user LIKE ? ";
}

$sql .= " ORDER BY br.br_date_br DESC";

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $like_search = "%{$search}%";
    $stmt->bind_param("ss", $like_search, $like_search);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการการยืมคืน</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
    <?php include_once("../components/nav.php"); ?>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <form action="borrow_manage.php" method="post" class="d-flex w-100" role="search">
                    <input class="form-control me-2" name="search" type="search" placeholder="รหัสหนังสือหรือรหัสผู้ใช้งาน" aria-label="Search" value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-outline-success" type="submit">ค้นหา</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="borrow.php" class="btn btn-success">ยืมหนังสือ</a>
                <a href="return.php" class="btn btn-warning">คืนหนังสือ</a>
                <a href="statistics.php" class="btn btn-primary">สถิติ</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <h3>รายการยืมคืนหนังสือ</h3>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>รหัสการยืม</th>
                            <th>รหัสหนังสือ</th>
                            <th>ชื่อหนังสือ</th>
                            <th>รหัสผู้ใช้งาน</th>
                            <th>ชื่อสมาชิก</th>
                            <th>วันที่ยืม</th>
                            <th>วันที่คืน</th>
                            <th>ค่าปรับ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['br_id']) ?></td>
                                    <td><?= htmlspecialchars($row['b_id']) ?></td>
                                    <td><?= htmlspecialchars($row['b_name']) ?></td>
                                    <td><?= htmlspecialchars($row['m_user']) ?></td>
                                    <td><?= htmlspecialchars($row['m_name']) ?></td>
                                    <td><?= htmlspecialchars($row['br_date_br']) ?></td>
                                    <td>
                                        <?= $row['br_date_rt'] ? htmlspecialchars($row['br_date_rt']) : '<span class="text-danger">ยังไม่คืน</span>' ?>
                                    </td>
                                    <td><?= $row['br_fine'] > 0 ? number_format($row['br_fine'], 2) . " บาท" : '-' ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-danger">ไม่พบข้อมูลที่ค้นหา!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
