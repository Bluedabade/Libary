<?php
session_start();
include_once("../db/db.php");

$memberData = null;
$bookData = null;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['m_user'])) {
        $stmt = $conn->prepare("SELECT * FROM tb_member WHERE m_user = ?");
        $stmt->bind_param("s", $_POST['m_user']);
        $stmt->execute();
        $memberResult = $stmt->get_result();
        $memberData = $memberResult->fetch_assoc();
        $stmt->close();
    }

    if (!empty($_POST['b_id'])) {
        $stmt = $conn->prepare("SELECT * FROM tb_book WHERE b_id = ?");
        $stmt->bind_param("s", $_POST['b_id']);
        $stmt->execute();
        $bookResult = $stmt->get_result();
        $bookData = $bookResult->fetch_assoc();
        $stmt->close();
    }

    if (isset($_POST['confirm_borrow'])) {
        if ($memberData && $bookData) {

            $stmt_check = $conn->prepare("SELECT * FROM tb_borrow_book WHERE b_id = ? AND br_date_rt IS NULL");

            $stmt_check->bind_param("s", $bookData['b_id']);
            $stmt_check->execute();
            $borrowed_result = $stmt_check->get_result();
            $isBorrowed = $borrowed_result->num_rows > 0;
            $stmt_check->close();

            if (!$isBorrowed) {
                $br_date_br = date('Y-m-d');
                $br_date_rt = NULL;
                $br_fine = 0;

                $stmt = $conn->prepare("INSERT INTO tb_borrow_book (br_date_br, br_date_rt, b_id, me_user, br_fine) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssi", $br_date_br, $br_date_rt, $bookData['b_id'], $memberData['m_user'], $br_fine);

                if ($stmt->execute()) {
                    $message = "✅ ยืนยันการยืมสำเร็จ!";
                } else {
                    $message = "❌ เกิดข้อผิดพลาดในการยืนยันการยืม";
                }
                $stmt->close();
            } else {
                $message = "⚠️ หนังสือเล่มนี้ถูกยืมไปแล้วและยังไม่ได้คืน!";
            }
        } else {
            $message = "❌ ไม่สามารถยืนยันการยืมได้ (ข้อมูลไม่ครบถ้วน)";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบยืมคืนหนังสือ</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/fonts.css">
</head>

<body>
    <?php include_once("../components/nav.php"); ?>

    <div class="container mt-5">
        <div class="card mx-auto" style="width: 40rem;">
            <form action="borrow.php" method="post" class="m-5">
                <h2 class="mb-4">ระบบยืมหนังสือ</h2>

                <div class="mb-3">
                    <input type="text" class="form-control" name="m_user" placeholder="รหัสสมาชิก" value="<?= htmlspecialchars($_POST['m_user'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="b_id" placeholder="รหัสหนังสือ" value="<?= htmlspecialchars($_POST['b_id'] ?? '') ?>" required>
                </div>

                <button type="submit" class="btn btn-primary mb-4">ค้นหา</button>

                <?php if ($memberData || $bookData): ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>ชื่อสมาชิก</th>
                            <td><?= $memberData ? htmlspecialchars($memberData['m_name']) : "ไม่พบสมาชิก" ?></td>
                        </tr>
                        <tr>
                            <th>ชื่อหนังสือ</th>
                            <td><?= $bookData ? htmlspecialchars($bookData['b_name']) : "ไม่พบหนังสือ" ?></td>
                        </tr>
                    </table>

                    <?php if ($memberData && $bookData): ?>
                        <button type="submit" name="confirm_borrow" class="btn btn-success">✅ ยืนยันการยืม</button>
                    <?php endif; ?>
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