<h4><i class="fas fa-chart-line"></i> Tra cứu điểm theo lớp học phần</h4>
<hr>

<form method="GET" action="<?= url('/student/grades') ?>" class="row g-3 mb-4">
    <div class="col-md-5">
        <label class="form-label">Môn học</label>
        <select class="form-select" name="MaMH">
            <option value="">-- Tất cả môn học --</option>
            <?php foreach ($monHocList as $mh): ?>
            <option value="<?= htmlspecialchars($mh['MaMH']) ?>" <?= ($MaMH ?? '') === $mh['MaMH'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($mh['MaMH']) ?> - <?= htmlspecialchars($mh['TenMH']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-5">
        <label class="form-label">Lớp học phần</label>
        <select class="form-select" name="MaLHP">
            <option value="">-- Tất cả lớp học phần --</option>
            <?php foreach ($lopHocPhanList as $lhp): ?>
            <option value="<?= htmlspecialchars($lhp['MaLHP']) ?>" <?= ($MaLHP ?? '') === $lhp['MaLHP'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($lhp['MaLHP']) ?> - <?= htmlspecialchars($lhp['TenMH'] ?? $lhp['MaMH']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tra cứu</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Mã LHP</th>
                <th>Môn học</th>
                <th>Số TC</th>
                <th>Học kỳ</th>
                <th>Điểm CC</th>
                <th>Điểm GK</th>
                <th>Điểm CK</th>
                <th>Điểm TK (Hệ 10)</th>
                <th>Hệ 4</th>
                <th>Xếp loại</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ketQuaList as $kq): ?>
            <?php
                $he4 = KetQua::toHe4($kq['DiemTongKet']);
                $xl = KetQua::xepLoai($kq['DiemTongKet']);
                $bg = match(true) {
                    $kq['DiemTongKet'] >= 9 => 'success',
                    $kq['DiemTongKet'] >= 7 => 'primary',
                    $kq['DiemTongKet'] >= 5 => 'warning',
                    default => 'danger'
                };
            ?>
            <tr>
                <td><strong><?= htmlspecialchars($kq['MaLHP']) ?></strong></td>
                <td><?= htmlspecialchars($kq['monHoc']['TenMH'] ?? 'N/A') ?></td>
                <td class="text-center"><?= htmlspecialchars($kq['monHoc']['SoTinChi'] ?? 0) ?></td>
                <td><?= htmlspecialchars($kq['hocKy']['TenHK'] ?? '') ?> (<?= htmlspecialchars($kq['hocKy']['NamHoc'] ?? '') ?>)</td>
                <td><?= $kq['DiemChuyenCan'] ?></td>
                <td><?= $kq['DiemGiuaKy'] ?></td>
                <td><?= $kq['DiemCuoiKy'] ?></td>
                <td><strong class="text-primary"><?= $kq['DiemTongKet'] ?></strong></td>
                <td><strong><?= $he4 ?></strong></td>
                <td><span class="badge bg-<?= $bg ?>"><?= $xl ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($ketQuaList)): ?>
            <tr>
                <td colspan="10" class="text-center py-3 text-muted">Không có dữ liệu điểm</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>