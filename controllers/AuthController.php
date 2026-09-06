<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/SinhVien.php';
require_once __DIR__ . '/../models/GiangVien.php';

class AuthController {
    private $sinhVienModel;
    private $giangVienModel;
    
    public function __construct($pdo) {
        $this->sinhVienModel = new SinhVien($pdo);
        $this->giangVienModel = new GiangVien($pdo);
    }
    
    public function showLogin() {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION['user']['role'];
            if ($role === 'admin') redirect('/admin/dashboard');
            elseif ($role === 'professor') redirect('/professor/dashboard');
            elseif ($role === 'student') redirect('/student/dashboard');
        }
        render('auth/login', ['error' => $_SESSION['error'] ?? null]);
        unset($_SESSION['error']);
    }
    
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập tài khoản và mật khẩu';
            redirect('/auth/login');
            return;
        }
        
        // 1. Kiểm tra Admin
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['user'] = [
                'username' => 'admin',
                'role' => 'admin',
                'hoTen' => 'Administrator'
            ];
            redirect('/admin/dashboard');
            return;
        }
        
        // 2. Kiểm tra Giảng viên
        $giangVien = $this->giangVienModel->login($username, $password);
        if ($giangVien) {
            $_SESSION['user'] = [
                'username' => $giangVien['MaGV'],
                'role' => 'professor',
                'maGV' => $giangVien['MaGV'],
                'maSV' => null,
                'hoTen' => $giangVien['HoTen']
            ];
            redirect('/professor/dashboard');
            return;
        }
        
        // 3. Kiểm tra Sinh viên
        $sinhVien = $this->sinhVienModel->login($username, $password);
        if ($sinhVien) {
            $_SESSION['user'] = [
                'username' => $sinhVien['MaSV'],
                'role' => 'student',
                'maGV' => null,
                'maSV' => $sinhVien['MaSV'],
                'hoTen' => $sinhVien['HoTen']
            ];
            redirect('/student/dashboard');
            return;
        }
        
        $_SESSION['error'] = 'Sai tài khoản hoặc mật khẩu';
        redirect('/auth/login');
    }
    
    public function logout() {
        session_destroy();
        redirect('/auth/login');
    }
}
?>