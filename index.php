<?php 
session_start(); // เริ่มต้นเซสชัน
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Banphai Hospital</title>

    <!-- Favicon -->
    <link rel="icon" href="photo/รพ.png" type="image/png">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/auth.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Theme Initialization -->
    <script src="assets/static/js/initTheme.js"></script>

    <div id="auth">
        <div class="row h-100">
            <!-- Left Column -->
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <!-- Logo -->
                    <div class="auth_logo">
                        <a href="index.php">
                            <img src="photo/รพ.png" alt="Logo" style="width: 100px; height: 100px;">
                        </a>
                    </div>

                    <!-- Title -->
                    <h1 class="auth-title">Banphai Hospital</h1>
                    <p class="auth-subtitle mb-5">เข้าสู่ระบบด้วยหมายเลขบัตรประชาชน 13 หลักและหมายเลขเบอร์โทรศัพท์</p>

                    <!-- Login Form -->
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

            <!-- Right Column -->
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <img src="photo/bp.jpg" alt="Background Image" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Notification -->
    <?php if (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '<?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>',
                confirmButtonText: 'ตกลง'
            });
            <?php unset($_SESSION['error']); // Clear error session ?>
        </script>
    <?php endif; ?>
</body>

</html>
