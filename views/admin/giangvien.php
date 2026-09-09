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
        </tbody>
    </table>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?= url('/admin/giangvien/add') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm giảng viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã giảng viên</label>
                        <input type="text" name="MaGV" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="HoTen" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="NgaySinh" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="SDT" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Học kỳ</label>
                        <select name="MaHK" class="form-select">
                            <?php foreach ($hocKyList as $hk): ?>
                                <option value="<?= htmlspecialchars($hk['MaHK']) ?>">
                                    <?= htmlspecialchars($hk['MaHK']) ?> - <?= htmlspecialchars($hk['TenHK']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" value="123456">
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
