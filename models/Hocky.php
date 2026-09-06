<?php
// models/Hocky.php
class HocKy {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM HocKy ORDER BY NamHoc DESC, MaHK");
        return $stmt->fetchAll();
    }
    
    public function getById($maHK) {
        $stmt = $this->db->prepare("SELECT * FROM HocKy WHERE MaHK = ?");
        $stmt->execute([$maHK]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO HocKy (MaHK, TenHK, NamHoc) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['MaHK'], $data['TenHK'], $data['NamHoc']]);
    }
    
    public function delete($maHK) {
        $stmt = $this->db->prepare("DELETE FROM HocKy WHERE MaHK = ?");
        return $stmt->execute([$maHK]);
    }
}
?>