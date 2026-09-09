<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-users"></i> Danh sách sinh viên - <?= htmlspecialchars($MaLHP) ?></h4>
</div>
<h6><?= htmlspecialchars($lopHocPhan['monHoc']['TenMH'] ?? '') ?> (<?= htmlspecialchars($lopHocPhan['MaMH'] ?? '') ?>) - <?= htmlspecialchars($lopHocPhan['hocKy']['TenHK'] ?? '') ?></h6>
<hr>

<?php if (isset($success)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Bộ lọc Lớp & Học kỳ -->
<div class="card mb-3 p-3 bg-light">
    <div class="row g-2 align-items-center">
        <div class="col-md-5">
            <label class="form-label small fw-bold">Chọn lớp học phần:</label>
            <select class="form-select" onchange="if(this.value) window.location.href='<?= url('/professor/students/') ?>' + this.value;">
                <?php foreach ($lopHocPhanList as $lhp): ?>
                <option value="<?= htmlspecialchars($lhp['MaLHP']) ?>" <?= $MaLHP === $lhp['MaLHP'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($lhp['MaLHP']) ?> - <?= htmlspecialchars($lhp['TenMH'] ?? $lhp['MaMH']) ?> (<?= htmlspecialchars($lhp['TenHK'] ?? $lhp['MaHK']) ?>)
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-5">
            <form method="GET" action="<?= url('/professor/students/' . $MaLHP) ?>" class="row g-2">
                <div class="col-8">
                    <label class="form-label small fw-bold">Lọc theo học kỳ:</label>
                    <select name="MaHK" class="form-select">
                        <option value="">-- Tất cả học kỳ --</option>
                        <?php foreach ($hocKyList as $hk): ?>
                        <option value="<?= htmlspecialchars($hk['MaHK']) ?>" <?= ($filterMaHK ?? '') === $hk['MaHK'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($hk['TenHK']) ?> (<?= htmlspecialchars($hk['NamHoc']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Lọc</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Điểm CC</th>
                <th>Điểm GK</th>
                <th>Điểm CK</th>
                <th>Điểm TK</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ketQuaList as $kq): ?>
            <tr>
                <td><strong><?= htmlspecialchars($kq['MaSV']) ?></strong></td>
                <td><?= htmlspecialchars($kq['sinhVien']['HoTen'] ?? $kq['TenSV'] ?? '') ?></td>
                <td>
                    <input type="number" step="0.1" class="form-control form-control-sm diem-cc" 
                           value="<?= $kq['DiemChuyenCan'] ?>" min="0" max="10" style="width:80px">
                </td>
                <td>
                    <input type="number" step="0.1" class="form-control form-control-sm diem-gk" 
                           value="<?= $kq['DiemGiuaKy'] ?>" min="0" max="10" style="width:80px">
                </td>
                <td>
                    <input type="number" step="0.1" class="form-control form-control-sm diem-ck" 
                           value="<?= $kq['DiemCuoiKy'] ?>" min="0" max="10" style="width:80px">
                </td>
                <td><strong class="text-primary"><?= $kq['DiemTongKet'] ?></strong></td>
                <td>
                    <button class="btn btn-success btn-sm btn-update" 
                            data-masv="<?= htmlspecialchars($kq['MaSV']) ?>" data-malhp="<?= htmlspecialchars($kq['MaLHP']) ?>">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($ketQuaList)): ?>
            <tr>
                <td colspan="7" class="text-center py-3 text-muted">Chưa có sinh viên trong lớp này</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
document.querySelectorAll('.btn-update').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('tr');
        const MaSV = this.dataset.masv;
        const MaLHP = this.dataset.malhp;
        const DiemChuyenCan = row.querySelector('.diem-cc').value;
        const DiemGiuaKy = row.querySelector('.diem-gk').value;
        const DiemCuoiKy = row.querySelector('.diem-ck').value;
        
        const formData = new FormData();
        formData.append('MaSV', MaSV);
        formData.append('MaLHP', MaLHP);
        formData.append('DiemChuyenCan', DiemChuyenCan);
        formData.append('DiemGiuaKy', DiemGiuaKy);
        formData.append('DiemCuoiKy', DiemCuoiKy);
        
        fetch('<?= url('/professor/update-score') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cập nhật điểm thành công!');
                location.reload();
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            alert('Có lỗi xảy ra khi lưu điểm');
        });
    });
});
</script>