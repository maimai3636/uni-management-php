<h4><i class="fas fa-file-alt"></i> Bảng điểm tổng hợp</h4>
<hr>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>Họ tên:</strong> <?= $sinhVien['HoTen'] ?></div>
            <div class="col-md-3"><strong>Mã SV:</strong> <?= $sinhVien['MaSV'] ?></div>
            <div class="col-md-3"><strong>Ngày sinh:</strong> <?= formatDate($sinhVien['NgaySinh']) ?></div>
            <div class="col-md-3"><strong>Lớp:</strong> <?= $sinhVien['MaLop'] ?></div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>STT</th>
                <th>Mã LHP</th>
                <th>Tên môn học</th>
                <th>Số tín chỉ</th>
                <th>Điểm CC</th>
                <th>Điểm GK</th>
                <th>Điểm CK</th>
                <th>Điểm TK</th>
                <th>Học kỳ</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; foreach ($transcriptData as $item): $i++; ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $item['MaLHP'] ?></td>
                <td><?= $item['TenMH'] ?></td>
                <td class="text-center"><?= $item['SoTinChi'] ?></td>
                <td><?= $item['DiemChuyenCan'] ?></td>
                <td><?= $item['DiemGiuaKy'] ?></td>
                <td><?= $item['DiemCuoiKy'] ?></td>
                <td><strong class="text-primary"><?= $item['DiemTongKet'] ?></strong></td>
                <td><?= $item['hocKy'] ?> (<?= $item['NamHoc'] ?>)</td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($transcriptData)): ?>
            <tr>
                <td colspan="9" class="text-center">Chưa có dữ liệu</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot class="table-secondary">
            <tr>
                <td colspan="3" class="text-end"><strong>Tổng kết:</strong></td>
                <td><strong><?= $totalCredits ?></strong></td>
                <td colspan="4"></td>
                <td><strong>GPA: <?= $gpa ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div>