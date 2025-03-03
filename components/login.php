<div class="card d-flex" style="width: 25rem;">
    <form action="./php/login.php" method="post" class="m-5">
        <h1>เข้าสู่ระบบ</h1>
        <div class="mb-3 mt-2">
            <label for="exampleInputEmail1" class="form-label">ชื่อผู้ใช้</label>
            <input name="username" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">รหัสผ่าน</label>
            <input name="pass" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit d-flex" name="submit" class="btn btn-primary">ยืนยัน</button>
    </form>
</div>