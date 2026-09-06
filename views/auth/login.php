<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h4><i class="fas fa-sign-in-alt"></i> Đăng nhập</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <form action="<?= url('/auth/login') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tài khoản</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="username" placeholder="MaSV, MaGV hoặc admin" required>
                        </div>
                        <small class="text-muted">Sinh viên: MaSV | Giảng viên: MaGV | Admin: admin</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </button>
                </form>
                <hr>
                <div class="text-center">
                    <small class="text-muted">
                        <strong>Demo:</strong><br>
                        Admin: admin / admin123<br>
                        GV: GV001 / 123456<br>
                        SV: SV001 / 123456
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>