<?php
// models/Ketqua.php
class KetQua {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT kq.*, sv.HoTen as TenSV, mh.TenMH, mh.SoTinChi, lhp.MaHK
            FROM KetQua kq
            JOIN SinhVien sv ON kq.MaSV = sv.MaSV
            JOIN LopHocPhan lhp ON kq.MaLHP = lhp.MaLHP
            JOIN MonHoc mh ON lhp.MaMH = mh.MaMH
            ORDER BY kq.MaSV, kq.MaLHP
        ");
        return $stmt->fetchAll();
    }

    // Lọc theo MaSV, MaLHP, MaHK
    public function getFiltered($maSV = null, $maLHP = null, $maHK = null) {
        $sql = "
            SELECT kq.*, sv.HoTen as TenSV, mh.TenMH, mh.SoTinChi, lhp.MaHK, hk.TenHK, hk.NamHoc
            FROM KetQua kq
            JOIN SinhVien sv ON kq.MaSV = sv.MaSV
            JOIN LopHocPhan lhp ON kq.MaLHP = lhp.MaLHP
            JOIN MonHoc mh ON lhp.MaMH = mh.MaMH
            JOIN HocKy hk ON lhp.MaHK = hk.MaHK
            WHERE 1=1
        ";
        $params = [];
        if ($maSV) {
            $sql .= " AND kq.MaSV LIKE ?";
            $params[] = '%' . $maSV . '%';
        }
        if ($maLHP) {
            $sql .= " AND kq.MaLHP = ?";
            $params[] = $maLHP;
        }
        if ($maHK) {
            $sql .= " AND lhp.MaHK = ?";
            $params[] = $maHK;
        }
        $sql .= " ORDER BY kq.MaSV, kq.MaLHP";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    // COMPOSITE KEY: MaSV + MaLHP
    public function getByKey($maSV, $maLHP) {
        $stmt = $this->db->prepare("SELECT * FROM KetQua WHERE MaSV = ? AND MaLHP = ?");
        $stmt->execute([$maSV, $maLHP]);
        return $stmt->fetch();
    }
    
    public function getByStudent($maSV) {
        $stmt = $this->db->prepare("
            SELECT kq.*, mh.TenMH, mh.SoTinChi, lhp.MaMH, lhp.MaHK
            FROM KetQua kq
            JOIN LopHocPhan lhp ON kq.MaLHP = lhp.MaLHP
            JOIN MonHoc mh ON lhp.MaMH = mh.MaMH
            WHERE kq.MaSV = ?
        ");
        $stmt->execute([$maSV]);
        return $stmt->fetchAll();
    }
    
    public function getByClass($maLHP) {
        $stmt = $this->db->prepare("
            SELECT kq.*, sv.HoTen as TenSV
            FROM KetQua kq
            JOIN SinhVien sv ON kq.MaSV = sv.MaSV
            WHERE kq.MaLHP = ?
        ");
        $stmt->execute([$maLHP]);
        return $stmt->fetchAll();
    }

    // Lọc kết quả theo lớp + học kỳ cho giảng viên
    public function getByClassAndSemester($maLHP = null, $maHK = null, $maGV = null) {
        $sql = "
            SELECT kq.*, sv.HoTen as TenSV, mh.TenMH, mh.SoTinChi, lhp.MaHK, hk.TenHK
            FROM KetQua kq
            JOIN SinhVien sv ON kq.MaSV = sv.MaSV
            JOIN LopHocPhan lhp ON kq.MaLHP = lhp.MaLHP
            JOIN MonHoc mh ON lhp.MaMH = mh.MaMH
            JOIN HocKy hk ON lhp.MaHK = hk.MaHK
            WHERE 1=1
        ";
        $params = [];
        if ($maGV) {
            $sql .= " AND lhp.MaGV = ?";
            $params[] = $maGV;
        }
        if ($maLHP) {
            $sql .= " AND kq.MaLHP = ?";
            $params[] = $maLHP;
        }
        if ($maHK) {
            $sql .= " AND lhp.MaHK = ?";
            $params[] = $maHK;
        }
        $sql .= " ORDER BY kq.MaSV";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function createOrUpdate($data) {
        $existing = $this->getByKey($data['MaSV'], $data['MaLHP']);
        // Công thức: CC*10% + GK*30% + CK*60%
        $diemTK = round(
            $data['DiemChuyenCan'] * 0.1 +
            $data['DiemGiuaKy'] * 0.3 +
            $data['DiemCuoiKy'] * 0.6,
            2
        );
        
        if ($existing) {
            $sql = "UPDATE KetQua 
                    SET DiemChuyenCan = ?, DiemGiuaKy = ?, DiemCuoiKy = ?, DiemTongKet = ? 
                    WHERE MaSV = ? AND MaLHP = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['DiemChuyenCan'],
                $data['DiemGiuaKy'],
                $data['DiemCuoiKy'],
                $diemTK,
                $data['MaSV'],
                $data['MaLHP']
            ]);
        } else {
            $sql = "INSERT INTO KetQua (MaSV, MaLHP, DiemChuyenCan, DiemGiuaKy, DiemCuoiKy, DiemTongKet) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['MaSV'],
                $data['MaLHP'],
                $data['DiemChuyenCan'],
                $data['DiemGiuaKy'],
                $data['DiemCuoiKy'],
                $diemTK
            ]);
        }
    }
    
    public function delete($maSV, $maLHP) {
        $stmt = $this->db->prepare("DELETE FROM KetQua WHERE MaSV = ? AND MaLHP = ?");
        return $stmt->execute([$maSV, $maLHP]);
    }

    // Tính điểm hệ 4
    public static function toHe4($diem10) {
        if ($diem10 >= 9.0) return 4.0;
        if ($diem10 >= 8.5) return 3.7;
        if ($diem10 >= 8.0) return 3.5;
        if ($diem10 >= 7.5) return 3.0;
        if ($diem10 >= 7.0) return 2.5;
        if ($diem10 >= 6.5) return 2.0;
        if ($diem10 >= 6.0) return 1.5;
        if ($diem10 >= 5.0) return 1.0;
        return 0.0;
    }

    // Xếp loại theo hệ 10
    public static function xepLoai($diem10) {
        if ($diem10 >= 9.0) return 'Xuất sắc';
        if ($diem10 >= 8.0) return 'Giỏi';
        if ($diem10 >= 7.0) return 'Khá';
        if ($diem10 >= 6.0) return 'Trung bình khá';
        if ($diem10 >= 5.0) return 'Trung bình';
        return 'Yếu/Kém';
    }
}
?>