<?php
// seed/importData.php
require_once __DIR__ . '/../config/database.php';

echo "✅ Connected to MySQL\n";

// Xóa dữ liệu cũ
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE TABLE SinhVien");
$pdo->exec("TRUNCATE TABLE GiangVien");
$pdo->exec("TRUNCATE TABLE MonHoc");
$pdo->exec("TRUNCATE TABLE HocKy");
$pdo->exec("TRUNCATE TABLE LopHocPhan");
$pdo->exec("TRUNCATE TABLE KetQua");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
echo "🗑️ Cleared old data\n";

// Học Kỳ
$hocKyList = [
    ['MaHK' => 'HK1', 'TenHK' => 'Học kỳ 1', 'NamHoc' => '2024-2025'],
    ['MaHK' => 'HK2', 'TenHK' => 'Học kỳ 2', 'NamHoc' => '2024-2025'],
    ['MaHK' => 'HK3', 'TenHK' => 'Học kỳ 3', 'NamHoc' => '2024-2025']
];
foreach ($hocKyList as $hk) {
    $stmt = $pdo->prepare("INSERT INTO HocKy (MaHK, TenHK, NamHoc) VALUES (?, ?, ?)");
    $stmt->execute([$hk['MaHK'], $hk['TenHK'], $hk['NamHoc']]);
}
echo "✅ Created " . count($hocKyList) . " học kỳ\n";

// Môn Học
$monHocList = [
    ['MaMH' => 'MH01', 'TenMH' => 'Toán cao cấp', 'SoTinChi' => 3],
    ['MaMH' => 'MH02', 'TenMH' => 'Lập trình web', 'SoTinChi' => 4],
    ['MaMH' => 'MH03', 'TenMH' => 'Cơ sở dữ liệu', 'SoTinChi' => 3]
];
foreach ($monHocList as $mh) {
    $stmt = $pdo->prepare("INSERT INTO MonHoc (MaMH, TenMH, SoTinChi) VALUES (?, ?, ?)");
    $stmt->execute([$mh['MaMH'], $mh['TenMH'], $mh['SoTinChi']]);
}
echo "✅ Created " . count($monHocList) . " môn học\n";

// Giảng Viên
$giangVienList = [
    ['MaGV' => 'GV001', 'HoTen' => 'Trần Văn B', 'NgaySinh' => '1980-08-15', 'SDT' => '0912345678', 'MaHK' => 'HK1', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    ['MaGV' => 'GV002', 'HoTen' => 'Phạm Thị D', 'NgaySinh' => '1975-03-20', 'SDT' => '0923456789', 'MaHK' => 'HK2', 'password' => password_hash('123456', PASSWORD_DEFAULT)]
];
foreach ($giangVienList as $gv) {
    $stmt = $pdo->prepare("INSERT INTO GiangVien (MaGV, HoTen, NgaySinh, SDT, MaHK, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$gv['MaGV'], $gv['HoTen'], $gv['NgaySinh'], $gv['SDT'], $gv['MaHK'], $gv['password']]);
}
echo "✅ Created " . count($giangVienList) . " giảng viên\n";

// Sinh Viên
$sinhVienList = [
    ['MaSV' => 'SV001', 'HoTen' => 'Nguyễn Văn A', 'NgaySinh' => '2002-05-12', 'GioiTinh' => 'Nam', 'SDT' => '0987654321', 'DiaChi' => 'Hà Nội', 'MaLop' => 'CNTT01', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    ['MaSV' => 'SV002', 'HoTen' => 'Trần Thị B', 'NgaySinh' => '2003-08-20', 'GioiTinh' => 'Nữ', 'SDT' => '0978123456', 'DiaChi' => 'Hồ Chí Minh', 'MaLop' => 'CNTT02', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    ['MaSV' => 'SV003', 'HoTen' => 'Lê Văn C', 'NgaySinh' => '2002-11-15', 'GioiTinh' => 'Nam', 'SDT' => '0965432187', 'DiaChi' => 'Đà Nẵng', 'MaLop' => 'CNTT01', 'password' => password_hash('123456', PASSWORD_DEFAULT)]
];
foreach ($sinhVienList as $sv) {
    $stmt = $pdo->prepare("INSERT INTO SinhVien (MaSV, HoTen, NgaySinh, GioiTinh, SDT, DiaChi, MaLop, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$sv['MaSV'], $sv['HoTen'], $sv['NgaySinh'], $sv['GioiTinh'], $sv['SDT'], $sv['DiaChi'], $sv['MaLop'], $sv['password']]);
}
echo "✅ Created " . count($sinhVienList) . " sinh viên\n";

// Lớp Học Phần
$lopHocPhanList = [
    ['MaLHP' => 'LHP01', 'MaMH' => 'MH01', 'MaGV' => 'GV001', 'MaHK' => 'HK1', 'SiSo' => 30],
    ['MaLHP' => 'LHP02', 'MaMH' => 'MH02', 'MaGV' => 'GV001', 'MaHK' => 'HK1', 'SiSo' => 25],
    ['MaLHP' => 'LHP03', 'MaMH' => 'MH03', 'MaGV' => 'GV002', 'MaHK' => 'HK2', 'SiSo' => 28]
];
foreach ($lopHocPhanList as $lhp) {
    $stmt = $pdo->prepare("INSERT INTO LopHocPhan (MaLHP, MaMH, MaGV, MaHK, SiSo) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$lhp['MaLHP'], $lhp['MaMH'], $lhp['MaGV'], $lhp['MaHK'], $lhp['SiSo']]);
}
echo "✅ Created " . count($lopHocPhanList) . " lớp học phần\n";

// Kết Quả (COMPOSITE KEY)
$ketQuaList = [
    ['MaSV' => 'SV001', 'MaLHP' => 'LHP01', 'DiemChuyenCan' => 9, 'DiemGiuaKy' => 8, 'DiemCuoiKy' => 7],
    ['MaSV' => 'SV001', 'MaLHP' => 'LHP02', 'DiemChuyenCan' => 8, 'DiemGiuaKy' => 7, 'DiemCuoiKy' => 6],
    ['MaSV' => 'SV002', 'MaLHP' => 'LHP01', 'DiemChuyenCan' => 7, 'DiemGiuaKy' => 6, 'DiemCuoiKy' => 5],
    ['MaSV' => 'SV003', 'MaLHP' => 'LHP01', 'DiemChuyenCan' => 10, 'DiemGiuaKy' => 9, 'DiemCuoiKy' => 8],
    ['MaSV' => 'SV003', 'MaLHP' => 'LHP03', 'DiemChuyenCan' => 8, 'DiemGiuaKy' => 7, 'DiemCuoiKy' => 6]
];
foreach ($ketQuaList as $kq) {
    $diemTK = round(($kq['DiemChuyenCan'] + $kq['DiemGiuaKy'] + $kq['DiemCuoiKy']) / 3, 2);
    $stmt = $pdo->prepare("INSERT INTO KetQua (MaSV, MaLHP, DiemChuyenCan, DiemGiuaKy, DiemCuoiKy, DiemTongKet) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$kq['MaSV'], $kq['MaLHP'], $kq['DiemChuyenCan'], $kq['DiemGiuaKy'], $kq['DiemCuoiKy'], $diemTK]);
}
echo "✅ Created " . count($ketQuaList) . " kết quả học tập\n";

echo "\n🎉 SEED COMPLETED SUCCESSFULLY!\n";
echo "\n📝 Tài khoản đăng nhập:\n";
echo "👤 Admin: admin / admin123\n";
echo "👨‍🏫 Giảng viên: GV001 / 123456\n";
echo "👨‍🏫 Giảng viên: GV002 / 123456\n";
echo "👨‍🎓 Sinh viên: SV001 / 123456\n";
echo "👨‍🎓 Sinh viên: SV002 / 123456\n";
echo "👨‍🎓 Sinh viên: SV003 / 123456\n";
echo "\n🌐 Truy cập: http://localhost/uni-management-php/public/\n";
?>