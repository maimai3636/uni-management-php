<?php
// models/SinhVien.php
class SinhVien {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM SinhVien ORDER BY MaSV");
        return $stmt->fetchAll();
    }
    
    public function getById($maSV) {
        $stmt = $this->db->prepare("SELECT * FROM SinhVien WHERE MaSV = ?");
        $stmt->execute([$maSV]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO SinhVien (MaSV, HoTen, NgaySinh, GioiTinh, SDT, DiaChi, MaLop, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['MaSV'],
            $data['HoTen'],
            $data['NgaySinh'],
            $data['GioiTinh'],
            $data['SDT'],
            $data['DiaChi'],
            $data['MaLop'],
            password_hash($data['password'] ?? '123456', PASSWORD_DEFAULT)
        ]);
    }
    
    public function update($maSV, $data) {
        $sql = "UPDATE SinhVien SET HoTen=?, NgaySinh=?, GioiTinh=?, SDT=?, DiaChi=?, MaLop=? WHERE MaSV=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['HoTen'],
            $data['NgaySinh'],
            $data['GioiTinh'],
            $data['SDT'],
            $data['DiaChi'],
            $data['MaLop'],
            $maSV
        ]);
    }
    
    public function delete($maSV) {
        $stmt = $this->db->prepare("DELETE FROM SinhVien WHERE MaSV = ?");
        return $stmt->execute([$maSV]);
    }
    
    public function login($maSV, $password) {
        $stmt = $this->db->prepare("SELECT * FROM SinhVien WHERE MaSV = ?");
        $stmt->execute([$maSV]);
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