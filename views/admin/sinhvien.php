<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-users"></i> Danh sách sinh viên</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Thêm sinh viên
    </button>
</div>

<?php if (isset($success)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $success ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $error ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>SDT</th>
                <th>Địa chỉ</th>
                <th>Mã lớp</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sinhVienList as $sv): ?>
            <tr>
                <td><strong><?= $sv['MaSV'] ?></strong></td>
                <td><?= $sv['HoTen'] ?></td>
                <td><?= formatDate($sv['NgaySinh']) ?></td>
                <td><span class="badge <?= $sv['GioiTinh'] === 'Nam' ? 'bg-primary' : 'bg-pink' ?>"><?= $sv['GioiTinh'] ?></span></td>
                <td><?= $sv['SDT'] ?></td>
                <td><?= $sv['DiaChi'] ?></td>
                <td><?= $sv['MaLop'] ?></td>
                <td>
                    <a href="<?= url('/admin/sinhvien/delete/' . $sv['MaSV']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sinh viên này?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($sinhVienList)): ?>
            <tr>
                <td colspan="8" class="text-center">Chưa có dữ liệu sinh viên</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal thêm sinh viên -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus"></i> Thêm sinh viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('/admin/sinhvien/add') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã SV <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="MaSV" required>
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
                        <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                        <select class="form-control" name="GioiTinh" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SDT</label>
                        <input type="text" class="form-control" name="SDT">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="DiaChi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã lớp</label>
                        <input type="text" class="form-control" name="MaLop">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu (mặc định: 123456)</label>
                        <input type="password" class="form-control" name="password" placeholder="Để trống để dùng mặc định">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>