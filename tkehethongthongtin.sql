-- Tạo database
CREATE DATABASE IF NOT EXISTS university_management;
USE university_management;

-- Bảng SinhVien
CREATE TABLE SinhVien (
    MaSV VARCHAR(20) PRIMARY KEY,
    HoTen VARCHAR(100) NOT NULL,
    NgaySinh DATE NOT NULL,
    GioiTinh ENUM('Nam', 'Nữ') NOT NULL,
    SDT VARCHAR(15),
    DiaChi VARCHAR(200),
    MaLop VARCHAR(20),
    password VARCHAR(255) NOT NULL
);

INSERT INTO SinhVien (MaSV, HoTen, NgaySinh, GioiTinh, SDT, DiaChi, MaLop, password)
VALUES
('SV001', 'Nguyễn Văn A', '2002-05-12', 'Nam', '0987654321', 'Hà Nội', 'CNTT01', '123456'),
('SV002', 'Trần Thị B', '2003-08-20', 'Nữ', '0978123456', 'Hồ Chí Minh', 'CNTT02', '123456'),
('SV003', 'Lê Văn C', '2002-11-15', 'Nam', '0965432187', 'Đà Nẵng', 'CNTT01', '123456');

-- Bảng GiangVien
CREATE TABLE GiangVien (
    MaGV VARCHAR(20) PRIMARY KEY,
    HoTen VARCHAR(100) NOT NULL,
    NgaySinh DATE NOT NULL,
    SDT VARCHAR(15),
    MaHK VARCHAR(20),
    password VARCHAR(255) NOT NULL
);

INSERT INTO GiangVien (MaGV, HoTen, NgaySinh, SDT, MaHK, password)
VALUES
('GV001', 'Trần Văn B', '1980-08-15', '0912345678', 'HK1', '123456'),
('GV002', 'Phạm Thị D', '1975-03-20', '0923456789', 'HK2', '123456');

-- Bảng MonHoc
CREATE TABLE MonHoc (
    MaMH VARCHAR(20) PRIMARY KEY,
    TenMH VARCHAR(100) NOT NULL,
    SoTinChi INT NOT NULL
);

-- Bảng HocKy
CREATE TABLE HocKy (
    MaHK VARCHAR(20) PRIMARY KEY,
    TenHK VARCHAR(100) NOT NULL,
    NamHoc VARCHAR(20) NOT NULL
);

-- Bảng LopHocPhan
CREATE TABLE LopHocPhan (
    MaLHP VARCHAR(20) PRIMARY KEY,
    MaMH VARCHAR(20),
    MaGV VARCHAR(20),
    MaHK VARCHAR(20),
    SiSo INT DEFAULT 0,
    FOREIGN KEY (MaMH) REFERENCES MonHoc(MaMH),
    FOREIGN KEY (MaGV) REFERENCES GiangVien(MaGV),
    FOREIGN KEY (MaHK) REFERENCES HocKy(MaHK)
);

-- Bảng KetQua (COMPOSITE KEY)
CREATE TABLE KetQua (
    MaSV VARCHAR(20),
    MaLHP VARCHAR(20),
    DiemChuyenCan FLOAT DEFAULT 0,
    DiemGiuaKy FLOAT DEFAULT 0,
    DiemCuoiKy FLOAT DEFAULT 0,
    DiemTongKet FLOAT DEFAULT 0,
    PRIMARY KEY (MaSV, MaLHP),
    FOREIGN KEY (MaSV) REFERENCES SinhVien(MaSV),
    FOREIGN KEY (MaLHP) REFERENCES LopHocPhan(MaLHP)
);

INSERT INTO HocKy (MaHK, TenHK, NamHoc)
VALUES
('HK1', 'Học kỳ 1', '2024-2025'),
('HK2', 'Học kỳ 2', '2024-2025'),
('HK3', 'Học kỳ 3', '2024-2025');

INSERT INTO MonHoc (MaMH, TenMH, SoTinChi)
VALUES
('MH01', 'Toán cao cấp', 3),
('MH02', 'Lập trình web', 4),
('MH03', 'Cơ sở dữ liệu', 3);

INSERT INTO LopHocPhan (MaLHP, MaMH, MaGV, MaHK, SiSo)
VALUES
('LHP01', 'MH01', 'GV001', 'HK1', 30),
('LHP02', 'MH02', 'GV001', 'HK1', 25),
('LHP03', 'MH03', 'GV002', 'HK2', 28);

INSERT INTO KetQua (MaSV, MaLHP, DiemChuyenCan, DiemGiuaKy, DiemCuoiKy, DiemTongKet)
VALUES
('SV001', 'LHP01', 9, 8, 7, 8),
('SV001', 'LHP02', 8, 7, 6, 7),
('SV002', 'LHP01', 7, 6, 5, 6),
('SV003', 'LHP01', 10, 9, 8, 9),
('SV003', 'LHP03', 8, 7, 6, 7);