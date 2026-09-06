<?php
// controllers/ProfessorController.php
require_once __DIR__ . '/../models/LopHocPhan.php';
require_once __DIR__ . '/../models/Ketqua.php';
require_once __DIR__ . '/../models/SinhVien.php';
require_once __DIR__ . '/../models/MonHoc.php';
require_once __DIR__ . '/../models/GiangVien.php';
require_once __DIR__ . '/../models/Hocky.php';

class ProfessorController {
    private $lopHocPhanModel;
    private $ketQuaModel;
    private $sinhVienModel;
    private $monHocModel;
    private $giangVienModel;
    private $hocKyModel;
    
    public function __construct($pdo) {
        $this->lopHocPhanModel = new LopHocPhan($pdo);
        $this->ketQuaModel = new KetQua($pdo);
        $this->sinhVienModel = new SinhVien($pdo);
        $this->monHocModel = new MonHoc($pdo);
        $this->giangVienModel = new GiangVien($pdo);
        $this->hocKyModel = new HocKy($pdo);
    }
    
    // === DASHBOARD ===
    public function dashboard() {
        $maGV = $_SESSION['user']['maGV'];
        $giangVien = $this->giangVienModel->getById($maGV);
        
        $lopHocPhanList = $this->lopHocPhanModel->getByProfessor($maGV);
        $populatedList = [];
        foreach ($lopHocPhanList as $lhp) {
            $monHoc = $this->monHocModel->getById($lhp['MaMH']);
            $hocKy = $this->hocKyModel->getById($lhp['MaHK']);
            $populatedList[] = array_merge($lhp, [
                'monHoc' => $monHoc,
                'hocKy' => $hocKy
            ]);
        }
        
        render('professor/dashboard', [
            'user' => $_SESSION['user'],
            'giangVien' => $giangVien,
            'lopHocPhanList' => $populatedList
        ]);
    }
    
    // === XEM DANH SÁCH LỚP ===
    public function getClasses() {
        $maGV = $_SESSION['user']['maGV'];
        $lopHocPhanList = $this->lopHocPhanModel->getByProfessor($maGV);
        $populatedList = [];
        foreach ($lopHocPhanList as $lhp) {
            $monHoc = $this->monHocModel->getById($lhp['MaMH']);
            $hocKy = $this->hocKyModel->getById($lhp['MaHK']);
            $populatedList[] = array_merge($lhp, [
                'monHoc' => $monHoc,
                'hocKy' => $hocKy
            ]);
        }
        
        render('professor/classes', [
            'user' => $_SESSION['user'],
            'lopHocPhanList' => $populatedList
        ]);
    }
    
    // === XEM SINH VIÊN TRONG LỚP ===
    public function getClassStudents($maLHP) {
        $lopHocPhan = $this->lopHocPhanModel->getById($maLHP);
        if (!$lopHocPhan) {
            $_SESSION['error'] = 'Không tìm thấy lớp học phần';
            redirect('/professor/classes');
            return;
        }
        
        $ketQuaList = $this->ketQuaModel->getByClass($maLHP);
        $populatedList = [];
        foreach ($ketQuaList as $kq) {
            $sinhVien = $this->sinhVienModel->getById($kq['MaSV']);
            $populatedList[] = array_merge($kq, [
                'sinhVien' => $sinhVien
            ]);
        }
        
        $monHoc = $this->monHocModel->getById($lopHocPhan['MaMH']);
        $hocKy = $this->hocKyModel->getById($lopHocPhan['MaHK']);
        
        render('professor/students', [
            'user' => $_SESSION['user'],
            'ketQuaList' => $populatedList,
            'lopHocPhan' => array_merge($lopHocPhan, [
                'monHoc' => $monHoc,
                'hocKy' => $hocKy
            ]),
            'MaLHP' => $maLHP,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
    
    // === NHẬP/SỬA ĐIỂM ===
    public function updateScore() {
        $data = [
            'MaSV' => $_POST['MaSV'],
            'MaLHP' => $_POST['MaLHP'],
            'DiemChuyenCan' => (float)($_POST['DiemChuyenCan'] ?? 0),
            'DiemGiuaKy' => (float)($_POST['DiemGiuaKy'] ?? 0),
            'DiemCuoiKy' => (float)($_POST['DiemCuoiKy'] ?? 0)
        ];
        
        if ($this->ketQuaModel->createOrUpdate($data)) {
            $_SESSION['success'] = 'Cập nhật điểm thành công';
        } else {
            $_SESSION['error'] = 'Cập nhật điểm thất bại';
        }
        redirect('/professor/students/' . $data['MaLHP']);
    }
    
    // === TRA CỨU SINH VIÊN ===
    public function searchStudents() {
        $maMH = $_GET['MaMH'] ?? null;
        $maLHP = $_GET['MaLHP'] ?? null;
        $maGV = $_SESSION['user']['maGV'];
        
        $results = [];
        
        if ($maLHP) {
            $lopHocPhan = $this->lopHocPhanModel->getById($maLHP);
            if ($lopHocPhan && $lopHocPhan['MaGV'] === $maGV) {
                $ketQuaList = $this->ketQuaModel->getByClass($maLHP);
                foreach ($ketQuaList as $kq) {
                    $sinhVien = $this->sinhVienModel->getById($kq['MaSV']);
                    $lhp = $this->lopHocPhanModel->getById($kq['MaLHP']);
                    $monHoc = $this->monHocModel->getById($lhp['MaMH']);
                    $results[] = array_merge($kq, [
                        'sinhVien' => $sinhVien,
                        'monHoc' => $monHoc
                    ]);
                }
            }
        } elseif ($maMH) {
            $lopHocPhanList = $this->lopHocPhanModel->getBySubject($maMH);
            $maLHPList = array_column($lopHocPhanList, 'MaLHP');
            foreach ($maLHPList as $lhp) {
                $ketQuaList = $this->ketQuaModel->getByClass($lhp);
                foreach ($ketQuaList as $kq) {
                    $sinhVien = $this->sinhVienModel->getById($kq['MaSV']);
                    $lhpObj = $this->lopHocPhanModel->getById($kq['MaLHP']);
                    $monHoc = $this->monHocModel->getById($lhpObj['MaMH']);
                    $results[] = array_merge($kq, [
                        'sinhVien' => $sinhVien,
                        'monHoc' => $monHoc
                    ]);
                }
            }
        }
        
        $monHocList = $this->monHocModel->getAll();
        
        render('professor/search', [
            'user' => $_SESSION['user'],
            'results' => $results,
            'MaMH' => $maMH,
            'MaLHP' => $maLHP,
            'monHocList' => $monHocList,
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['error']);
    }
}
?>