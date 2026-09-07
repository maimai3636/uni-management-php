<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info">
            <h5><i class="fas fa-chalkboard-teacher"></i> Xin chào, Giảng viên <?= htmlspecialchars($giangVien['HoTen'] ?? $user['hoTen'] ?? '') ?>!</h5>
            <p class="mb-0">Mã giảng viên: <strong><?= htmlspecialchars($giangVien['MaGV'] ?? '') ?></strong> | SĐT: <strong><?= htmlspecialchars($giangVien['SDT'] ?? '') ?></strong></p>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5><i class="fas fa-school"></i> Lớp học phần phụ trách</h5>
                <p class="display-6"><?= count($lopHocPhanList) ?></p>
                <a href="<?= url('/professor/classes') ?>" class="btn btn-light btn-sm">Xem danh sách lớp</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5><i class="fas fa-search"></i> Tra cứu & Nhập điểm</h5>
                <p class="display-6"><i class="fas fa-edit"></i></p>
                <a href="<?= url('/professor/classes') ?>" class="btn btn-light btn-sm">Vào lớp để nhập điểm</a>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-layer-group"></i> Các lớp học phần đang giảng dạy</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã LHP</th>
                        <th>Môn học</th>
                        <th>Số tín chỉ</th>
                        <th>Học kỳ</th>
                        <th>Sĩ số</th>
