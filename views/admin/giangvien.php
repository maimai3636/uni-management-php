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
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($giangVienList)): ?>
            <tr>
                <td colspan="6" class="text-center py-3 text-muted">Chưa có dữ liệu giảng viên</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal thêm giảng viên -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus"></i> Thêm giảng viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('/admin/giangvien/add') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã GV <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="MaGV" placeholder="VD: GV003" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="HoTen" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="NgaySinh" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="SDT">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Học kỳ phụ trách <span class="text-danger">*</span></label>
                        <select class="form-control" name="MaHK" required>
                            <option value="">Chọn học kỳ</option>
                            <?php foreach ($hocKyList as $hk): ?>
                            <option value="<?= htmlspecialchars($hk['MaHK']) ?>"><?= htmlspecialchars($hk['TenHK']) ?> (<?= htmlspecialchars($hk['NamHoc']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu ban đầu</label>
                        <input type="password" class="form-control" name="password" placeholder="Mặc định: 123456">
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
