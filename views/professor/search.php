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
