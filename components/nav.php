<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ห้องสมุด</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo $acive = $pagename == "user_manage.php" ? "active" : "" ?>" aria-current="page" href="user_manage.php">จัดการรายชื่อสมาชิก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $acive = $pagename == "book_manage.php" ? "active" : "" ?>" href="book_manage.php">จัดการหนังสือ</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $acive = $pagename == "borrow_manage.php" ? "active" : "" ?>" href="borrow_manage.php" aria-disabled="true">จัดการการยืม - คืน</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">ค้นหา</button>
            </form>
        </div>
    </div>
</nav>