<?php
// controllers/StudentController.php
require_once __DIR__ . '/../models/SinhVien.php';
require_once __DIR__ . '/../models/Ketqua.php';
require_once __DIR__ . '/../models/LopHocPhan.php';
require_once __DIR__ . '/../models/MonHoc.php';
require_once __DIR__ . '/../models/Hocky.php';

class StudentController {
    private $sinhVienModel;
    private $ketQuaModel;
    private $lopHocPhanModel;
    private $monHocModel;
    private $hocKyModel;
    
    public function __construct($pdo) {
        $this->sinhVienModel = new SinhVien($pdo);
        $this->ketQuaModel = new KetQua($pdo);
        $this->lopHocPhanModel = new LopHocPhan($pdo);
        $this->monHocModel = new MonHoc($pdo);
        $this->hocKyModel = new HocKy($pdo);
    }
    
    // === DASHBOARD ===
    public function dashboard() {
        $maSV = $_SESSION['user']['maSV'];
        $sinhVien = $this->sinhVienModel->getById($maSV);
        
        $ketQuaList = $this->ketQuaModel->getByStudent($maSV);
        $populatedList = [];
        foreach ($ketQuaList as $kq) {
            $lopHocPhan = $this->lopHocPhanModel->getById($kq['MaLHP']);
            $monHoc = $this->monHocModel->getById($lopHocPhan['MaMH']);
            $hocKy = $this->hocKyModel->getById($lopHocPhan['MaHK']);
            $populatedList[] = array_merge($kq, [
                'monHoc' => $monHoc,
                'hocKy' => $hocKy
            ]);
        }
        
        render('student/dashboard', [
            'user' => $_SESSION['user'],
            'sinhVien' => $sinhVien,
            'ketQuaList' => $populatedList
        ]);
    }
    
    // === XEM THÔNG TIN CÁ NHÂN ===
    public function getProfile() {
        $maSV = $_SESSION['user']['maSV'];
        $sinhVien = $this->sinhVienModel->getById($maSV);
        
        render('student/profile', [
            'user' => $_SESSION['user'],
            'sinhVien' => $sinhVien
        ]);
    }
    
    // === TRA CỨU ĐIỂM ===
    public function getGrades() {
        $maSV = $_SESSION['user']['maSV'];
        $MaMH = $_GET['MaMH'] ?? null;
        $MaLHP = $_GET['MaLHP'] ?? null;
        
        $ketQuaList = $this->ketQuaModel->getByStudent($maSV);
        
        // Lọc theo MaLHP
        if ($MaLHP) {
            $ketQuaList = array_filter($ketQuaList, function($kq) use ($MaLHP) {
                return $kq['MaLHP'] === $MaLHP;
            });
        }
        
        // Lọc theo MaMH
        if ($MaMH) {
            $filtered = [];
            foreach ($ketQuaList as $kq) {
                $lopHocPhan = $this->lopHocPhanModel->getById($kq['MaLHP']);
                if ($lopHocPhan && $lopHocPhan['MaMH'] === $MaMH) {
                    $filtered[] = $kq;
                }
            }
            $ketQuaList = $filtered;
        }
        
        $populatedList = [];
        foreach ($ketQuaList as $kq) {
            $lopHocPhan = $this->lopHocPhanModel->getById($kq['MaLHP']);
            $monHoc = $this->monHocModel->getById($lopHocPhan['MaMH']);
            $hocKy = $this->hocKyModel->getById($lopHocPhan['MaHK']);
            $populatedList[] = array_merge($kq, [
                'monHoc' => $monHoc,
                'hocKy' => $hocKy
            ]);
        }
        
        $lopHocPhanList = $this->lopHocPhanModel->getAll();
        $monHocList = $this->monHocModel->getAll();
        
        render('student/grades', [
            'user' => $_SESSION['user'],
            'ketQuaList' => $populatedList,
            'lopHocPhanList' => $lopHocPhanList,
            'monHocList' => $monHocList,
            'MaMH' => $MaMH,
            'MaLHP' => $MaLHP
        ]);
    }
    
    // === XEM BẢNG ĐIỂM ===
    public function getTranscript() {
        $maSV = $_SESSION['user']['maSV'];
        $sinhVien = $this->sinhVienModel->getById($maSV);
        
        $ketQuaList = $this->ketQuaModel->getByStudent($maSV);
        $transcriptData = [];
        
        foreach ($ketQuaList as $kq) {
            $lopHocPhan = $this->lopHocPhanModel->getById($kq['MaLHP']);
            $monHoc = $this->monHocModel->getById($lopHocPhan['MaMH']);
            $hocKy = $this->hocKyModel->getById($lopHocPhan['MaHK']);
            $transcriptData[] = [
                'MaLHP' => $kq['MaLHP'],
                'TenMH' => $monHoc['TenMH'] ?? 'N/A',
                'SoTinChi' => $monHoc['SoTinChi'] ?? 0,
                'DiemTongKet' => $kq['DiemTongKet'],
                'DiemChuyenCan' => $kq['DiemChuyenCan'],
                'DiemGiuaKy' => $kq['DiemGiuaKy'],
                'DiemCuoiKy' => $kq['DiemCuoiKy'],
                'hocKy' => $hocKy['TenHK'] ?? 'N/A',
                'NamHoc' => $hocKy['NamHoc'] ?? 'N/A'
            ];
        }
        
        // Tính GPA
        $totalCredits = 0;
        $totalScore = 0;
        foreach ($transcriptData as $item) {
            $totalCredits += $item['SoTinChi'];
            $totalScore += $item['DiemTongKet'] * $item['SoTinChi'];
        }
        $gpa = $totalCredits > 0 ? round($totalScore / $totalCredits, 2) : 0;
        
        render('student/transcript', [
            'user' => $_SESSION['user'],
            'sinhVien' => $sinhVien,
            'transcriptData' => $transcriptData,
            'gpa' => $gpa,
            'totalCredits' => $totalCredits
        ]);
    }
}
?>