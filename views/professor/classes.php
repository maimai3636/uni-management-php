<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-school"></i> Danh sách lớp học phần phụ trách</h4>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Mã LHP</th>
                <th>Tên môn học</th>
                <th>Số tín chỉ</th>
                <th>Học kỳ</th>
                <th>Sĩ số</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lopHocPhanList as $lhp): ?>
            <tr>
                <td><strong><?= htmlspecialchars($lhp['MaLHP']) ?></strong></td>
                <td><?= htmlspecialchars($lhp['monHoc']['TenMH'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($lhp['monHoc']['SoTinChi'] ?? 0) ?></td>
                <td><?= htmlspecialchars($lhp['hocKy']['TenHK'] ?? '') ?> (<?= htmlspecialchars($lhp['hocKy']['NamHoc'] ?? '') ?>)</td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($lhp['SiSo'] ?? 0) ?> sinh viên</span></td>
                <td>
                    <a href="<?= url('/professor/students/' . $lhp['MaLHP']) ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Quản lý điểm sinh viên
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($lopHocPhanList)): ?>
            <tr>
                <td colspan="6" class="text-center py-3 text-muted">Không có lớp học phần nào</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
