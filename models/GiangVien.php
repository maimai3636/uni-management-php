<?php
// models/GiangVien.php
class GiangVien {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM GiangVien ORDER BY MaGV");
        return $stmt->fetchAll();
    }
    
    public function getById($maGV) {
        $stmt = $this->db->prepare("SELECT * FROM GiangVien WHERE MaGV = ?");
        $stmt->execute([$maGV]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO GiangVien (MaGV, HoTen, NgaySinh, SDT, MaHK, password) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['MaGV'],
            $data['HoTen'],
            $data['NgaySinh'] ?? '1990-01-01',
            $data['SDT'] ?? '',
            $data['MaHK'] ?? 'HK1',
            password_hash($data['password'] ?? '123456', PASSWORD_DEFAULT)
        ]);
    }
    
    public function delete($maGV) {
        $stmt = $this->db->prepare("DELETE FROM GiangVien WHERE MaGV = ?");
        return $stmt->execute([$maGV]);
    }
    
    public function login($maGV, $password) {
        $stmt = $this->db->prepare("SELECT * FROM GiangVien WHERE MaGV = ?");
        $stmt->execute([$maGV]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        $storedPassword = $user['password'] ?? '';
        if (password_verify($password, $storedPassword) || $storedPassword === $password) {
            return $user;
        }
        return false;
    }
}
?>