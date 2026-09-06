<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Hệ thống quản lý sinh viên' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('/css/style.css') ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= url('/') ?>">
                <i class="fas fa-graduation-cap"></i> Quản lý sinh viên
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <span class="nav-link text-white">
                            <i class="fas fa-user-circle"></i> 
                            <?= $_SESSION['user']['hoTen'] ?> (<?= $_SESSION['user']['role'] ?>)
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('/auth/logout') ?>">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('/auth/login') ?>">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <?php if (isset($_SESSION['user'])): ?>
            <div class="col-md-3">
                <div class="sidebar">
                    <h5 class="mb-3"><i class="fas fa-arrow-right"></i> Menu</h5>
                    <hr>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="<?= url('/admin/dashboard') ?>" class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <a href="<?= url('/admin/sinhvien') ?>" class="nav-link <?= ($active ?? '') === 'sinhvien' ? 'active' : '' ?>">
                            <i class="fas fa-users"></i> Sinh viên
                        </a>
                        <a href="<?= url('/admin/giangvien') ?>" class="nav-link <?= ($active ?? '') === 'giangvien' ? 'active' : '' ?>">
                            <i class="fas fa-chalkboard-teacher"></i> Giảng viên
                        </a>
                        <a href="<?= url('/admin/monhoc') ?>" class="nav-link <?= ($active ?? '') === 'monhoc' ? 'active' : '' ?>">
                            <i class="fas fa-book"></i> Môn học
                        </a>
                        <a href="<?= url('/admin/hocky') ?>" class="nav-link <?= ($active ?? '') === 'hocky' ? 'active' : '' ?>">
                            <i class="fas fa-calendar-alt"></i> Học kỳ
                        </a>
                        <a href="<?= url('/admin/lophocphan') ?>" class="nav-link <?= ($active ?? '') === 'lophocphan' ? 'active' : '' ?>">
                            <i class="fas fa-layer-group"></i> Lớp học phần
                        </a>
                        <a href="<?= url('/admin/ketqua') ?>" class="nav-link <?= ($active ?? '') === 'ketqua' ? 'active' : '' ?>">
                            <i class="fas fa-clipboard-list"></i> Kết quả
                        </a>
                    <?php elseif ($_SESSION['user']['role'] === 'professor'): ?>
                        <a href="<?= url('/professor/dashboard') ?>" class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <a href="<?= url('/professor/classes') ?>" class="nav-link <?= ($active ?? '') === 'classes' ? 'active' : '' ?>">
                            <i class="fas fa-school"></i> Lớp của tôi
                        </a>
                        <a href="<?= url('/professor/search') ?>" class="nav-link <?= ($active ?? '') === 'search' ? 'active' : '' ?>">
                            <i class="fas fa-search"></i> Tra cứu
                        </a>
                    <?php elseif ($_SESSION['user']['role'] === 'student'): ?>
                        <a href="<?= url('/student/dashboard') ?>" class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <a href="<?= url('/student/profile') ?>" class="nav-link <?= ($active ?? '') === 'profile' ? 'active' : '' ?>">
                            <i class="fas fa-id-card"></i> Thông tin
                        </a>
                        <a href="<?= url('/student/grades') ?>" class="nav-link <?= ($active ?? '') === 'grades' ? 'active' : '' ?>">
                            <i class="fas fa-chart-line"></i> Tra cứu điểm
                        </a>
                        <a href="<?= url('/student/transcript') ?>" class="nav-link <?= ($active ?? '') === 'transcript' ? 'active' : '' ?>">
                            <i class="fas fa-file-alt"></i> Bảng điểm
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-9">
                <div class="content">
                    <?= $content ?? '' ?>
                </div>
            </div>
            <?php else: ?>
            <div class="col-12">
                <?= $content ?? '' ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>