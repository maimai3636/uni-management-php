<h4><i class="fas fa-id-card"></i> Thông tin cá nhân</h4>
<hr>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user"></i> Hồ sơ sinh viên</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted"><i class="fas fa-barcode"></i> Mã sinh viên:</div>
                    <div class="col-sm-8"><strong><?= htmlspecialchars($sinhVien['MaSV'] ?? '') ?></strong></div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted"><i class="fas fa-user-tag"></i> Họ và tên:</div>
                    <div class="col-sm-8"><strong><?= htmlspecialchars($sinhVien['HoTen'] ?? '') ?></strong></div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted"><i class="fas fa-birthday-cake"></i> Ngày sinh:</div>
                    <div class="col-sm-8"><?= formatDate($sinhVien['NgaySinh'] ?? '') ?></div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted"><i class="fas fa-venus-mars"></i> Giới tính:</div>
                    <div class="col-sm-8">
                        <span class="badge 
    <?= ($sinhVien['GioiTinh'] ?? '') === 'Nam' 
        ? 'bg-primary' 
        : (($sinhVien['GioiTinh'] ?? '') === 'Nữ' ? 'bg-danger' : 'bg-secondary') ?>">
    <?= htmlspecialchars($sinhVien['GioiTinh'] ?? '') ?>
</span>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted"><i class="fas fa-users"></i> Lớp sinh hoạt:</div>
                    <div class="col-sm-8"><span class="badge bg-secondary"><?= htmlspecialchars($sinhVien['MaLop'] ?? 'Chưa cập nhật') ?></span></div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted"><i class="fas fa-phone"></i> Số điện thoại:</div>
                    <div class="col-sm-8"><?= htmlspecialchars($sinhVien['SDT'] ?? 'Chưa cập nhật') ?></div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted"><i class="fas fa-map-marker-alt"></i> Địa chỉ:</div>
                    <div class="col-sm-8"><?= htmlspecialchars($sinhVien['DiaChi'] ?? 'Chưa cập nhật') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
