<?php
// models/LopHocPhan.php
class LopHocPhan {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function getAll() {
    $stmt = $this->db->query("
        SELECT 
            lhp.*,
            gv.HoTen AS TenGV
        FROM LopHocPhan lhp
        LEFT JOIN GiangVien gv ON lhp.MaGV = gv.MaGV
        ORDER BY lhp.MaLHP
    ");
    return $stmt->fetchAll();
}
    
    public function getById($maLHP) {
        $stmt = $this->db->prepare("SELECT * FROM LopHocPhan WHERE MaLHP = ?");
        $stmt->execute([$maLHP]);
        return $stmt->fetch();
    }
    
    public function getByProfessor($maGV) {
        $stmt = $this->db->prepare("SELECT * FROM LopHocPhan WHERE MaGV = ? ORDER BY MaLHP");
        $stmt->execute([$maGV]);
        return $stmt->fetchAll();
    }
    
    public function getBySubject($maMH) {
        $stmt = $this->db->prepare("SELECT * FROM LopHocPhan WHERE MaMH = ?");
        $stmt->execute([$maMH]);
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $sql = "INSERT INTO LopHocPhan (MaLHP, MaMH, MaGV, MaHK, SiSo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['MaLHP'],
            $data['MaMH'],
            $data['MaGV'],
            $data['MaHK'],
            $data['SiSo']
        ]);
    }
    
    public function delete($maLHP) {
        $stmt = $this->db->prepare("DELETE FROM LopHocPhan WHERE MaLHP = ?");
        return $stmt->execute([$maLHP]);
    }
}
?>
