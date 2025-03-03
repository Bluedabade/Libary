<?php
session_start();
include_once("./db/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแรก</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/fonts.css">
</head>

<body>
    <?php
    include_once("./components/nav.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="col d-flex mt-5 justify-content-center align-items-center">
                <?php
                if (!isset($_SESSION['a_id'])): ?>
                    <?php include_once("./components/login.php") ?>
                <?php else: ?>
                    <?php header('Location: pages/user_manage.php');
                    exit;
                    ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>