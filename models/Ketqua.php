<?php
// models/Ketqua.php
class KetQua {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT kq.*, sv.HoTen as TenSV, mh.TenMH 
            FROM KetQua kq
            JOIN SinhVien sv ON kq.MaSV = sv.MaSV
            JOIN LopHocPhan lhp ON kq.MaLHP = lhp.MaLHP
            JOIN MonHoc mh ON lhp.MaMH = mh.MaMH
            ORDER BY kq.MaSV, kq.MaLHP
        ");
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
            SELECT kq.*, mh.TenMH, mh.SoTinChi, lhp.MaMH 
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
    
    public function createOrUpdate($data) {
        // Kiểm tra tồn tại (Composite Key)
        $existing = $this->getByKey($data['MaSV'], $data['MaLHP']);
        
        $diemTK = round(($data['DiemChuyenCan'] + $data['DiemGiuaKy'] + $data['DiemCuoiKy']) / 3, 2);
        
        if ($existing) {
            // UPDATE
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
            // INSERT
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
}
?>