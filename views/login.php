<?php
// Sử dụng biến $title từ controller
$page_title = $title ?? "Đăng nhập - Shop Điện Tử";
require_once './views/layout/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4">Đăng nhập</h1>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập hoặc Email</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">Đăng nhập</button>
                        </div>
                        
                        <div class="text-center mb-3">
                            <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
                        </div>
                    </form>
                    
                    <div class="separator my-4">
                        <div class="line"></div>
                        <span class="mx-3">hoặc đăng nhập với</span>
                        <div class="line"></div>
                    </div>
                    
                    <div class="row social-login">
                        <div class="col-6">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class="fab fa-facebook-f me-2"></i>Facebook
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-outline-danger w-100">
                                <i class="fab fa-google me-2"></i>Google
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p>Chưa có tài khoản? <a href="<?php echo BASE_URL; ?>?act=register">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .separator {
        display: flex;
        align-items: center;
        text-align: center;
        color: #6c757d;
    }
    
    .separator .line {
        flex: 1;
        height: 1px;
        background-color: #dee2e6;
    }
</style>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

<?php require_once './views/layout/footer.php'; ?>