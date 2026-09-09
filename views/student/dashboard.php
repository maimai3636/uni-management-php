<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-primary">
            <h5><i class="fas fa-user-graduate"></i> Xin chào, <?= htmlspecialchars($sinhVien['HoTen'] ?? $user['hoTen'] ?? 'Sinh viên') ?>!</h5>
            <p class="mb-0">Mã sinh viên: <strong><?= htmlspecialchars($sinhVien['MaSV'] ?? '') ?></strong> | Lớp: <strong><?= htmlspecialchars($sinhVien['MaLop'] ?? '') ?></strong></p>
        </div>
    </div>
</div>
<?php
$totalCourses = count($ketQuaList);
$totalCredits = 0;
$totalPoints = 0;
foreach ($ketQuaList as $item) {
    $credits = $item['monHoc']['SoTinChi'] ?? 0;
    $grade = $item['DiemTongKet'] ?? 0;
    $totalCredits += $credits;
    $totalPoints += $credits * $grade;
}
$gpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
$he4 = KetQua::toHe4($gpa);
$xepLoai = KetQua::xepLoai($gpa);
?>
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h6><i class="fas fa-book-open"></i> Học phần đã học</h6>
                <h3 class="display-6"><?= $totalCourses ?></h3>
                <a href="<?= url('/student/grades') ?>" class="btn btn-light btn-sm mt-2">Xem chi tiết</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h6><i class="fas fa-award"></i> Tổng tín chỉ tích lũy</h6>
                <h3 class="display-6"><?= $totalCredits ?></h3>
                <a href="<?= url('/student/transcript') ?>" class="btn btn-light btn-sm mt-2">Xem bảng điểm</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h6><i class="fas fa-star"></i> Điểm TB tích lũy (GPA)</h6>
                <h3 class="display-6"><?= $gpa ?> <small style="font-size: 16px;">(Hệ 4: <?= $he4 ?>)</small></h3>
                <span class="badge bg-light text-dark mt-2"><?= $xepLoai ?></span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-list-alt"></i> Các lớp học phần đã tham gia</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã LHP</th>
                        <th>Môn học</th>
                        <th>Số tín chỉ</th>
                        <th>Học kỳ</th>
                        <th>Điểm tổng kết</th>
                        <th>Xếp loại</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ketQuaList as $kq): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($kq['MaLHP']) ?></strong></td>
                        <td><?= htmlspecialchars($kq['monHoc']['TenMH'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($kq['monHoc']['SoTinChi'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($kq['hocKy']['TenHK'] ?? '') ?> (<?= htmlspecialchars($kq['hocKy']['NamHoc'] ?? '') ?>)</td>
                        <td><strong class="text-primary"><?= $kq['DiemTongKet'] ?></strong></td>
                        <td>
                            <?php 
                                $xl = KetQua::xepLoai($kq['DiemTongKet']);
                                $bg = match(true) {
                                    $kq['DiemTongKet'] >= 9 => 'success',
                                    $kq['DiemTongKet'] >= 7 => 'primary',
                                    $kq['DiemTongKet'] >= 5 => 'warning',
                                    default => 'danger'
                                };
                            ?>
                            <span class="badge bg-<?= $bg ?>"><?= $xl ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($ketQuaList)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-3 text-muted">Chưa có dữ liệu học phần</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
