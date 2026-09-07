<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-chalkboard-teacher"></i> Quản lý giảng viên</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Thêm giảng viên
    </button>
</div>
<hr>
<?php if (isset($success)): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if (isset($error)): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Mã GV</th>
                <th>Họ và tên</th>
                <th>Ngày sinh</th>
                <th>Số điện thoại</th>
                <th>Mã học kỳ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($giangVienList as $gv): ?>
            <tr>
                <td><strong><?= htmlspecialchars($gv['MaGV']) ?></strong></td>
                <td><?= htmlspecialchars($gv['HoTen']) ?></td>
                <td><?= formatDate($gv['NgaySinh']) ?></td>
                <td><?= htmlspecialchars($gv['SDT'] ?? '') ?></td>
                <td><span class="badge bg-secondary"><?= htmlspecialchars($gv['MaHK'] ?? '') ?></span></td>
                <td>
                    <a href="<?= url('/admin/giangvien/delete/' . $gv['MaGV']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa giảng viên này?')">
