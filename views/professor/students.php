<h4><i class="fas fa-users"></i> Danh sách sinh viên - <?= $MaLHP ?></h4>
<h6><?= $lopHocPhan['monHoc']['TenMH'] ?> (<?= $lopHocPhan['MaMH'] ?>) - <?= $lopHocPhan['hocKy']['TenHK'] ?></h6>
<hr>

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
                <td><strong><?= $kq['MaSV'] ?></strong></td>
                <td><?= $kq['sinhVien']['HoTen'] ?></td>
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
                            data-masv="<?= $kq['MaSV'] ?>" data-malhp="<?= $kq['MaLHP'] ?>">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($ketQuaList)): ?>
            <tr>
                <td colspan="7" class="text-center">Chưa có sinh viên trong lớp này</td>
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
            alert('Có lỗi xảy ra');
        });
    });
});
</script>