<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-layer-group"></i> Quản lý lớp học phần</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Thêm lớp học phần
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
                <th>Mã LHP</th>
                <th>Mã MH</th>
                <th>Mã GV</th>
                <th>Mã HK</th>
                <th>Sĩ số</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lopHocPhanList as $lhp): ?>
            <tr>
                <td><strong><?= htmlspecialchars($lhp['MaLHP']) ?></strong></td>
                <td><?= htmlspecialchars($lhp['MaMH']) ?></td>
                <td><?= htmlspecialchars($lhp['MaGV']) ?></td>
                <td><span class="badge bg-secondary"><?= htmlspecialchars($lhp['MaHK']) ?></span></td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($lhp['SiSo'] ?? 0) ?></span></td>
                <td>
                    <a href="<?= url('/admin/lophocphan/delete/' . $lhp['MaLHP']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa lớp học phần này?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($lopHocPhanList)): ?>
            <tr>
                <td colspan="6" class="text-center py-3 text-muted">Chưa có dữ liệu lớp học phần</td>
                </tr>
                <?php endif; ?>
