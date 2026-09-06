<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info">
            <h5><i class="fas fa-user-shield"></i> Xin chào, Admin!</h5>
            <p class="mb-0">Hệ thống quản lý sinh viên - Phiên bản 1.0</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5><i class="fas fa-users"></i> Sinh viên</h5>
                <p class="display-6"><?= $sinhVienCount ?? 0 ?></p>
                <a href="<?= url('/admin/sinhvien') ?>" class="btn btn-light btn-sm">Quản lý</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5><i class="fas fa-chalkboard-teacher"></i> Giảng viên</h5>
                <p class="display-6"><?= $giangVienCount ?? 0 ?></p>
                <a href="<?= url('/admin/giangvien') ?>" class="btn btn-light btn-sm">Quản lý</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5><i class="fas fa-book"></i> Môn học</h5>
                <p class="display-6"><?= $monHocCount ?? 0 ?></p>
                <a href="<?= url('/admin/monhoc') ?>" class="btn btn-light btn-sm">Quản lý</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5><i class="fas fa-layer-group"></i> Lớp học phần</h5>
                <p class="display-6"><?= $lopHocPhanCount ?? 0 ?></p>
                <a href="<?= url('/admin/lophocphan') ?>" class="btn btn-light btn-sm">Quản lý</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5><i class="fas fa-clipboard-list"></i> Kết quả học tập</h5>
                <p class="display-6"><?= $ketQuaCount ?? 0 ?></p>
                <a href="<?= url('/admin/ketqua') ?>" class="btn btn-light btn-sm">Quản lý</a>
            </div>
        </div>
    </div>
</div>