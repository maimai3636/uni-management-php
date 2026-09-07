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
