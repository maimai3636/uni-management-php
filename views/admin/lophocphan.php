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
        </tbody>
    </table>
</div>

<!-- Modal thêm lớp học phần -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Thêm lớp học phần</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('/admin/lophocphan/add') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã LHP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="MaLHP" placeholder="VD: LHP04" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Môn học <span class="text-danger">*</span></label>
                        <select class="form-control" name="MaMH" required>
                            <option value="">-- Chọn môn học --</option>
                            <?php foreach ($monHocList as $mh): ?>
                            <option value="<?= htmlspecialchars($mh['MaMH']) ?>"><?= htmlspecialchars($mh['MaMH']) ?> - <?= htmlspecialchars($mh['TenMH']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giảng viên phụ trách <span class="text-danger">*</span></label>
                        <select class="form-control" name="MaGV" required>
                            <option value="">-- Chọn giảng viên --</option>
                            <?php foreach ($giangVienList as $gv): ?>
                            <option value="<?= htmlspecialchars($gv['MaGV']) ?>"><?= htmlspecialchars($gv['MaGV']) ?> - <?= htmlspecialchars($gv['HoTen']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Học kỳ <span class="text-danger">*</span></label>
                        <select class="form-control" name="MaHK" required>
                            <option value="">-- Chọn học kỳ --</option>
                            <?php foreach ($hocKyList as $hk): ?>
                            <option value="<?= htmlspecialchars($hk['MaHK']) ?>"><?= htmlspecialchars($hk['MaHK']) ?> - <?= htmlspecialchars($hk['TenHK']) ?> (<?= htmlspecialchars($hk['NamHoc']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sĩ số</label>
                        <input type="number" class="form-control" name="SiSo" min="1" max="200" value="30">
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
