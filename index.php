<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Banphai Hospital</title>
    
    <link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/auth.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth_logo">
                        <a href="index.php">
                            <img src="photo/รพ.png" alt="Logo" style="width: 100px; height: 100px;">
                        </a>
                    </div>
                    <h1 class="auth-title">Banphai Hospital</h1>
                    <p class="auth-subtitle mb-5">เข้าสู่ระบบด้วยหมายเลขบัตรประชาชน 13 หลักและหมายเลขเบอร์โทรศัพท์</p>

                    <!-- ฟอร์มการล็อกอิน -->
                    <form autocomplete="off" action="login_process.php" method="post">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="username" placeholder="Username" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <!-- เพิ่มรูปภาพ -->
                    <img src="photo/bp.jpg" alt="Background Image" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <!-- แสดงข้อความแจ้งเตือนในกรณีที่เกิดข้อผิดพลาด -->
    <?php if (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '<?= $_SESSION['error'] ?>',
                confirmButtonText: 'ตกลง'
            });
            <?php unset($_SESSION['error']); // Clear error session ?>
        </script>
    <?php endif; ?>
</body>

</html>
