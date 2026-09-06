<h4><i class="fas fa-chart-line"></i> Tra cứu điểm</h4>
<hr>

<form method="GET" action="<?= url('/student/grades') ?>" class="row g-3 mb-4">
    <div class="col-md-5">
        <label class="form-label">Mã học phần</label>
        <select class="form-control" name="MaMH">
            <option value="">Tất cả</option>
            <?php foreach ($monHocList as $mh): ?>
            <option value="<?= $mh['MaMH'] ?>" <?= isset($MaMH) && $MaMH === $mh['MaMH'] ? 'selected' : '' ?>>
                <?= $mh['MaMH'] ?> - <?= $mh['TenMH'] ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-5">
        <label class="form-label">Mã lớp HP</label>
        <select class="form-control" name="MaLHP">
            <option value="">Tất cả</option>
            <?php foreach ($lopHocPhanList as $lhp): ?>
            <option value="<?= $lhp['MaLHP'] ?>" <?= isset($MaLHP) && $MaLHP === $lhp['MaLHP'] ? 'selected' : '' ?>>
                <?= $lhp['MaLHP'] ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tra cứu</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Mã LHP</th>
                <th>Môn học</th>
                <th>Học kỳ</th>
                <th>Điểm CC</th>
                <th>Điểm GK</th>
                <th>Điểm CK</th>
                <th>Điểm TK</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ketQuaList as $kq): ?>
            <tr>
                <td><?= $kq['MaLHP'] ?></td>
                <td><?= $kq['monHoc']['TenMH'] ?></td>
                <td><?= $kq['hocKy']['TenHK'] ?> (<?= $kq['hocKy']['NamHoc'] ?>)</td>
                <td><?= $kq['DiemChuyenCan'] ?></td>
                <td><?= $kq['DiemGiuaKy'] ?></td>
                <td><?= $kq['DiemCuoiKy'] ?></td>
                <td><strong class="text-primary"><?= $kq['DiemTongKet'] ?></strong></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($ketQuaList)): ?>
            <tr>
                <td colspan="7" class="text-center">Không có dữ liệu điểm</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>