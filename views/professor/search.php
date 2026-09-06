<h4><i class="fas fa-search"></i> Tra cứu sinh viên theo lớp / môn học</h4>
<hr>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="GET" action="<?= url('/professor/search') ?>" class="row g-3 mb-4">
    <div class="col-md-5">
        <label class="form-label">Môn học</label>
        <select class="form-control" name="MaMH">
            <option value="">-- Tất cả môn học --</option>
            <?php foreach ($monHocList as $mh): ?>
            <option value="<?= htmlspecialchars($mh['MaMH']) ?>" <?= ($MaMH ?? '') === $mh['MaMH'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($mh['MaMH']) ?> - <?= htmlspecialchars($mh['TenMH']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-5">
        <label class="form-label">Mã Lớp Học Phần</label>
        <input type="text" class="form-control" name="MaLHP" placeholder="Nhập mã LHP (VD: LHP01)" value="<?= htmlspecialchars($MaLHP ?? '') ?>">
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tìm kiếm</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Mã SV</th>
                <th>Họ và tên</th>
                <th>Lớp sinh hoạt</th>
                <th>Mã LHP</th>
                <th>Môn học</th>
                <th>Điểm CC</th>
                <th>Điểm GK</th>
                <th>Điểm CK</th>
                <th>Điểm TK</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $item): ?>
            <tr>
                <td><strong><?= htmlspecialchars($item['sinhVien']['MaSV'] ?? '') ?></strong></td>
                <td><?= htmlspecialchars($item['sinhVien']['HoTen'] ?? '') ?></td>
                <td><?= htmlspecialchars($item['sinhVien']['MaLop'] ?? '') ?></td>
                <td><span class="badge bg-secondary"><?= htmlspecialchars($item['MaLHP'] ?? '') ?></span></td>
                <td><?= htmlspecialchars($item['monHoc']['TenMH'] ?? '') ?></td>
                <td><?= htmlspecialchars($item['DiemChuyenCan'] ?? '') ?></td>
                <td><?= htmlspecialchars($item['DiemGiuaKy'] ?? '') ?></td>
                <td><?= htmlspecialchars($item['DiemCuoiKy'] ?? '') ?></td>
                <td><strong class="text-primary"><?= htmlspecialchars($item['DiemTongKet'] ?? '') ?></strong></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($results)): ?>
            <tr>
                <td colspan="9" class="text-center py-4 text-muted">
                    <?= (isset($MaMH) || isset($MaLHP)) ? 'Không tìm thấy kết quả phù hợp' : 'Vui lòng chọn môn học hoặc nhập mã lớp học phần để tra cứu' ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
