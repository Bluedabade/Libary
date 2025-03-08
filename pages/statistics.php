<?php
session_start();
include_once("../db/db.php");

$pagename = "borrow_manage.php";
unset($_SESSION['m_name']);
unset($_SESSION['b_name']);

$borrow_chart_query = $conn->query("
    SELECT br_date_br AS date, COUNT(*) AS total_borrow
    FROM tb_borrow_book
    GROUP BY br_date_br
    ORDER BY br_date_br
");

$return_chart_query = $conn->query("
    SELECT br_date_rt AS date, COUNT(*) AS total_return
    FROM tb_borrow_book
    WHERE br_date_rt IS NOT NULL
    GROUP BY br_date_rt
    ORDER BY br_date_rt
");

$data_chart = [];

while ($row = $borrow_chart_query->fetch_assoc()) {
    $date = $row['date'];
    $data_chart[$date]['borrow'] = $row['total_borrow'];
    $data_chart[$date]['return'] = 0; 
}

while ($row = $return_chart_query->fetch_assoc()) {
    $date = $row['date'];
    if (!isset($data_chart[$date])) {
        $data_chart[$date]['borrow'] = 0; 
    }
    $data_chart[$date]['return'] = $row['total_return'];
}

$dates = array_keys($data_chart);
$borrow_counts = array_column($data_chart, 'borrow');
$return_counts = array_column($data_chart, 'return');

$total_books = $conn->query("SELECT COUNT(*) AS total FROM tb_book")->fetch_assoc()['total'];
$total_members = $conn->query("SELECT COUNT(*) AS total FROM tb_member")->fetch_assoc()['total'];
$total_borrowed = $conn->query("SELECT COUNT(*) AS total FROM tb_borrow_book")->fetch_assoc()['total'];
$total_not_returned = $conn->query("SELECT COUNT(*) AS total FROM tb_borrow_book WHERE br_date_rt IS NULL")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สรุปข้อมูลโดยรวมและกราฟ</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/fonts.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include_once("../components/nav.php"); ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h3>สรุปข้อมูลโดยรวม</h3>
            </div>
            <div class="col-md-6 text-end">
                <a href="borrow_manage.php" class="btn btn-primary">กลับ</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white mb-3">
                    <div class="card-body">
                        <h5>จำนวนหนังสือทั้งหมด</h5>
                        <h2><?= $total_books ?> เล่ม</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <h5>จำนวนผู้ใช้ทั้งหมด</h5>
                        <h2><?= $total_members ?> คน</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark mb-3">
                    <div class="card-body">
                        <h5>จำนวนการยืมทั้งหมด</h5>
                        <h2><?= $total_borrowed ?> ครั้ง</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white mb-3">
                    <div class="card-body">
                        <h5>หนังสือที่ยังไม่คืน</h5>
                        <h2><?= $total_not_returned ?> เล่ม</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <h4>จำนวนผู้ยืมหนังสือในแต่ละวัน</h4>
                <canvas id="borrowChart" height="120"></canvas>
            </div>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('borrowChart').getContext('2d');
        const borrowChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($dates) ?>,
                datasets: [{
                        label: 'จำนวนการยืมหนังสือ (ครั้ง)',
                        data: <?= json_encode($borrow_counts) ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'จำนวนการคืนหนังสือ (ครั้ง)',
                        data: <?= json_encode($return_counts) ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>