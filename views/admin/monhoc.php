<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-book"></i> Quản lý môn học</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Thêm môn học
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
                <th>Mã MH</th>
                <th>Tên môn học</th>
                <th>Số tín chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monHocList as $mh): ?>
            <tr>
                <td><strong><?= htmlspecialchars($mh['MaMH']) ?></strong></td>
                <td><?= htmlspecialchars($mh['TenMH']) ?></td>
                <td><span class="badge bg-primary"><?= htmlspecialchars($mh['SoTinChi']) ?> tín chỉ</span></td>
                <td>
                    <a href="<?= url('/admin/monhoc/delete/' . $mh['MaMH']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa môn học này?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($monHocList)): ?>
            <tr>
                <td colspan="4" class="text-center py-3 text-muted">Chưa có dữ liệu môn học</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal thêm môn học -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Thêm môn học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('/admin/monhoc/add') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã môn học <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="MaMH" placeholder="VD: MH04" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên môn học <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="TenMH" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số tín chỉ <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="SoTinChi" min="1" max="10" value="3" required>
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
