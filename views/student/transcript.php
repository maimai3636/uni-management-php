<h4><i class="fas fa-file-alt"></i> Bảng điểm tổng hợp</h4>
<hr>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>Họ tên:</strong> <?= htmlspecialchars($sinhVien['HoTen'] ?? '') ?></div>
            <div class="col-md-3"><strong>Mã SV:</strong> <?= htmlspecialchars($sinhVien['MaSV'] ?? '') ?></div>
            <div class="col-md-3"><strong>Ngày sinh:</strong> <?= formatDate($sinhVien['NgaySinh'] ?? '') ?></div>
            <div class="col-md-3"><strong>Lớp:</strong> <?= htmlspecialchars($sinhVien['MaLop'] ?? '') ?></div>
        </div>
    </div>
</div>

<!-- Bộ lọc theo học kỳ / cả năm -->
<form method="GET" action="<?= url('/student/transcript') ?>" class="row g-2 mb-3">
    <div class="col-md-4">
        <select class="form-select" name="MaHK">
            <option value="">-- Tất cả các kỳ (Cả khóa / Cả năm) --</option>
            <?php foreach ($hocKyList as $hk): ?>
            <option value="<?= htmlspecialchars($hk['MaHK']) ?>" <?= ($filterMaHK ?? '') === $hk['MaHK'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($hk['TenHK']) ?> (<?= htmlspecialchars($hk['NamHoc']) ?>)
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 d-flex gap-1">
        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
        <a href="<?= url('/student/transcript') ?>" class="btn btn-secondary">Xem tất cả</a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-primary">
            <tr>
                <th>STT</th>
                <th>Mã LHP</th>
                <th>Tên môn học</th>
                <th>Số tín chỉ</th>
                <th>Điểm CC</th>
                <th>Điểm GK</th>
                <th>Điểm CK</th>
                <th>Điểm TK (Hệ 10)</th>
                <th>Hệ 4</th>
                <th>Xếp loại</th>
                <th>Học kỳ</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; foreach ($transcriptData as $item): $i++; ?>
            <?php 
                $bg = match(true) {
                    $item['DiemTongKet'] >= 9 => 'success',
                    $item['DiemTongKet'] >= 7 => 'primary',
                    $item['DiemTongKet'] >= 5 => 'warning',
                    default => 'danger'
                };
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><strong><?= htmlspecialchars($item['MaLHP']) ?></strong></td>
                <td><?= htmlspecialchars($item['TenMH']) ?></td>
                <td class="text-center"><?= htmlspecialchars($item['SoTinChi']) ?></td>
                <td><?= $item['DiemChuyenCan'] ?></td>
                <td><?= $item['DiemGiuaKy'] ?></td>
                <td><?= $item['DiemCuoiKy'] ?></td>
                <td><strong class="text-primary"><?= $item['DiemTongKet'] ?></strong></td>
                <td><strong><?= $item['DiemHe4'] ?></strong></td>
                <td><span class="badge bg-<?= $bg ?>"><?= $item['XepLoai'] ?></span></td>
                <td><?= htmlspecialchars($item['hocKy']) ?> (<?= htmlspecialchars($item['NamHoc']) ?>)</td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($transcriptData)): ?>
            <tr>
                <td colspan="11" class="text-center py-3 text-muted">Chưa có dữ liệu kết quả học tập</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot class="table-secondary">
            <tr>
                <td colspan="3" class="text-end"><strong>Tổng kết:</strong></td>
                <td class="text-center"><strong><?= $totalCredits ?> tín chỉ</strong></td>
                <td colspan="3"></td>
                <td><strong>GPA 10: <?= $gpa10 ?></strong></td>
                <td><strong>GPA 4: <?= $gpa4 ?></strong></td>
                <td><strong><?= KetQua::xepLoai($gpa10) ?></strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>