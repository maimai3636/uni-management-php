<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-calendar-alt"></i> Quản lý học kỳ</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Thêm học kỳ
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
                <th>Mã HK</th>
                <th>Tên học kỳ</th>
                <th>Năm học</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hocKyList as $hk): ?>
            <tr>
                <td><strong><?= htmlspecialchars($hk['MaHK']) ?></strong></td>
                <td><?= htmlspecialchars($hk['TenHK']) ?></td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($hk['NamHoc']) ?></span></td>
                <td>
                    <a href="<?= url('/admin/hocky/delete/' . $hk['MaHK']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa học kỳ này?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($hocKyList)): ?>
            <tr>
                <td colspan="4" class="text-center py-3 text-muted">Chưa có dữ liệu học kỳ</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal thêm học kỳ -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Thêm học kỳ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('/admin/hocky/add') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã học kỳ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="MaHK" placeholder="VD: HK4" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên học kỳ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="TenHK" placeholder="VD: Học kỳ 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Năm học <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="NamHoc" placeholder="VD: 2024-2025" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>
