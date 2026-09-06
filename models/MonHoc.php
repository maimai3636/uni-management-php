<?php
// models/MonHoc.php
class MonHoc {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM MonHoc ORDER BY MaMH");
        return $stmt->fetchAll();
    }
    
    public function getById($maMH) {
        $stmt = $this->db->prepare("SELECT * FROM MonHoc WHERE MaMH = ?");
        $stmt->execute([$maMH]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO MonHoc (MaMH, TenMH, SoTinChi) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['MaMH'], $data['TenMH'], $data['SoTinChi']]);
    }
    
    public function delete($maMH) {
        $stmt = $this->db->prepare("DELETE FROM MonHoc WHERE MaMH = ?");
        return $stmt->execute([$maMH]);
    }
}
?>