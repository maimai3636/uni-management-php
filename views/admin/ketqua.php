<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-clipboard-list"></i> Quản lý kết quả học tập</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Thêm/Cập nhật kết quả
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

<!-- Bộ lọc -->
<form method="GET" action="<?= url('/admin/ketqua') ?>" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="text" class="form-control" name="MaSV" placeholder="Mã sinh viên..."
               value="<?= htmlspecialchars($filterMaSV ?? '') ?>">
    </div>
    <div class="col-md-3">
        <select class="form-select" name="MaLHP">
            <option value="">-- Tất cả lớp HP --</option>
            <?php foreach ($lopHocPhanList as $lhp): ?>
            <option value="<?= htmlspecialchars($lhp['MaLHP']) ?>"
                <?= ($filterMaLHP ?? '') === $lhp['MaLHP'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($lhp['MaLHP']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-select" name="MaHK">
            <option value="">-- Tất cả học kỳ --</option>
            <?php foreach ($hocKyList as $hk): ?>
            <option value="<?= htmlspecialchars($hk['MaHK']) ?>"
                <?= ($filterMaHK ?? '') === $hk['MaHK'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($hk['TenHK']) ?> (<?= htmlspecialchars($hk['NamHoc']) ?>)
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 d-flex gap-1">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Lọc</button>
        <a href="<?= url('/admin/ketqua') ?>" class="btn btn-secondary w-100">Xóa</a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Mã LHP</th>
                <th>Môn học</th>
                <th>Tín chỉ</th>
                <th>Điểm CC</th>
                <th>Điểm GK</th>
                <th>Điểm CK</th>
                <th>Tổng kết</th>
                <th>Hệ 4</th>
                <th>Xếp loại</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ketQuaList as $kq): ?>
            <?php
                $he4    = KetQua::toHe4($kq['DiemTongKet']);
                $xepLoai = KetQua::xepLoai($kq['DiemTongKet']);
                $badgeClass = match(true) {
                    $kq['DiemTongKet'] >= 9  => 'success',
                    $kq['DiemTongKet'] >= 7  => 'primary',
                    $kq['DiemTongKet'] >= 5  => 'warning',
                    default                  => 'danger',
                };
            ?>
            <tr>
                <td><strong><?= htmlspecialchars($kq['MaSV']) ?></strong></td>
                <td><?= htmlspecialchars($kq['TenSV']) ?></td>
                <td><?= htmlspecialchars($kq['MaLHP']) ?></td>
                <td><?= htmlspecialchars($kq['TenMH']) ?></td>
                <td class="text-center"><?= htmlspecialchars($kq['SoTinChi']) ?></td>
                <td><?= $kq['DiemChuyenCan'] ?></td>
                <td><?= $kq['DiemGiuaKy'] ?></td>
                <td><?= $kq['DiemCuoiKy'] ?></td>
                <td><strong class="text-primary"><?= $kq['DiemTongKet'] ?></strong></td>
                <td><?= $he4 ?></td>
                <td><span class="badge bg-<?= $badgeClass ?>"><?= $xepLoai ?></span></td>
                <td>
                    <a href="<?= url('/admin/ketqua/delete/' . $kq['MaSV'] . '/' . $kq['MaLHP']) ?>"
                       class="btn btn-danger btn-sm" onclick="return confirm('Xóa kết quả này?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($ketQuaList)): ?>
            <tr>
                <td colspan="12" class="text-center">Chưa có dữ liệu kết quả</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal thêm kết quả (COMPOSITE KEY) -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Thêm/Cập nhật kết quả</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('/admin/ketqua/add') ?>" method="POST">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Khóa chính: <strong>Mã SV + Mã LHP</strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã SV <span class="text-danger">*</span></label>
                        <select class="form-control" name="MaSV" required>
                            <option value="">Chọn sinh viên</option>
                            <?php foreach ($sinhVienList as $sv): ?>
                            <option value="<?= $sv['MaSV'] ?>"><?= $sv['MaSV'] ?> - <?= $sv['HoTen'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã LHP <span class="text-danger">*</span></label>
                        <select class="form-control" name="MaLHP" required>
                            <option value="">Chọn lớp học phần</option>
                            <?php foreach ($lopHocPhanList as $lhp): ?>
                            <option value="<?= $lhp['MaLHP'] ?>"><?= $lhp['MaLHP'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm chuyên cần</label>
                        <input type="number" step="0.1" class="form-control" name="DiemChuyenCan" min="0" max="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm giữa kỳ</label>
                        <input type="number" step="0.1" class="form-control" name="DiemGiuaKy" min="0" max="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Điểm cuối kỳ</label>
                        <input type="number" step="0.1" class="form-control" name="DiemCuoiKy" min="0" max="10">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>