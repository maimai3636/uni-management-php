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

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?= url('/admin/hocky/add') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm học kỳ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã học kỳ</label>
                        <input type="text" name="MaHK" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tên học kỳ</label>
                        <input type="text" name="TenHK" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Năm học</label>
                        <input type="text" name="NamHoc" class="form-control"
                               placeholder="VD: 2026-2027" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
        </tbody>
    </table>
</div>
