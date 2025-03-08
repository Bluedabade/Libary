<?php
session_start();
include_once("../db/db.php");

$message = "";
$borrowData = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ค้นหารายการที่ต้องการคืน
    if (!empty($_POST['b_id'])) {
        $b_id = $_POST['b_id'];
        $stmt = $conn->prepare("SELECT br.*, b.b_name, m.m_name FROM tb_borrow_book br
                                JOIN tb_book b ON br.b_id = b.b_id
                                JOIN tb_member m ON br.me_user = m.m_user
                                WHERE br.b_id = ? AND br.br_date_rt IS NULL");
        $stmt->bind_param("s", $b_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $borrowData = $result->fetch_assoc();
        $stmt->close();
        
        if (!$borrowData) {
            $message = "⚠️ ไม่พบข้อมูลการยืมที่ยังไม่ได้คืนของหนังสือเล่มนี้!";
        }
    }

    // ยืนยันการคืนหนังสือ
    if (isset($_POST['confirm_return'])) {
        if ($borrowData) {
            $br_date_rt = date('Y-m-d');  // วันที่คืนปัจจุบัน
            $br_fine = !empty($_POST['br_fine']) ? (int)$_POST['br_fine'] : 0; // ค่าปรับ (ถ้ามี)

            $stmt_update = $conn->prepare("UPDATE tb_borrow_book SET br_date_rt = ?, br_fine = ? WHERE br_id = ?");
            $stmt_update->bind_param("sii", $br_date_rt, $br_fine, $borrowData['br_id']);

            if ($stmt_update->execute()) {
                $message = "✅ คืนหนังสือเรียบร้อยแล้ว!";
                $borrowData = null; // เคลียร์ข้อมูลหลังคืนเสร็จ
            } else {
                $message = "❌ เกิดข้อผิดพลาดขณะคืนหนังสือ!";
            }
            $stmt_update->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คืนหนังสือ</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/fonts.css">

</head>
<body>
    <?php include_once("../components/nav.php"); ?>

    <div class="container mt-5">
        <div class="card mx-auto" style="width: 40rem;">
            <form action="return.php" method="post" class="m-5">
                <h2 class="mb-4">ระบบคืนหนังสือ</h2>

                <div class="mb-3">
                    <input type="text" class="form-control" name="b_id" placeholder="รหัสหนังสือที่คืน" value="<?= htmlspecialchars($_POST['b_id'] ?? '') ?>" required>
                </div>

                <button type="submit" class="btn btn-primary mb-4">ค้นหา</button>

                <?php if ($borrowData): ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>ชื่อหนังสือ</th>
                            <td><?= htmlspecialchars($borrowData['b_name']) ?></td>
                        </tr>
                        <tr>
                            <th>ผู้ยืม</th>
                            <td><?= htmlspecialchars($borrowData['m_name']) ?></td>
                        </tr>
                        <tr>
                            <th>วันที่ยืม</th>
                            <td><?= htmlspecialchars($borrowData['br_date_br']) ?></td>
                        </tr>
                    </table>

                    <div class="mb-3">
                        <input type="number" class="form-control" name="br_fine" placeholder="ค่าปรับ (ถ้ามี)" min="0">
                    </div>

                    <button type="submit" name="confirm_return" class="btn btn-success">✅ ยืนยันการคืน</button>
                <?php endif; ?>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-info mt-3">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
