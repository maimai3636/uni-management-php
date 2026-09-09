<?php
// controllers/AdminController.php
require_once __DIR__ . '/../models/SinhVien.php';
require_once __DIR__ . '/../models/GiangVien.php';
require_once __DIR__ . '/../models/MonHoc.php';
require_once __DIR__ . '/../models/Hocky.php';
require_once __DIR__ . '/../models/LopHocPhan.php';
require_once __DIR__ . '/../models/Ketqua.php';

class AdminController {
    private $sinhVienModel;
    private $giangVienModel;
    private $monHocModel;
    private $hocKyModel;
    private $lopHocPhanModel;
    private $ketQuaModel;
    
    public function __construct($pdo) {
        $this->sinhVienModel = new SinhVien($pdo);
        $this->giangVienModel = new GiangVien($pdo);
        $this->monHocModel = new MonHoc($pdo);
        $this->hocKyModel = new HocKy($pdo);
        $this->lopHocPhanModel = new LopHocPhan($pdo);
        $this->ketQuaModel = new KetQua($pdo);
    }
    
    // === DASHBOARD ===
    public function dashboard() {
        $sinhVienCount = count($this->sinhVienModel->getAll());
        $giangVienCount = count($this->giangVienModel->getAll());
        $monHocCount = count($this->monHocModel->getAll());
        $lopHocPhanCount = count($this->lopHocPhanModel->getAll());
        $ketQuaCount = count($this->ketQuaModel->getAll());
        
        render('admin/dashboard', [
            'user' => $_SESSION['user'],
            'sinhVienCount' => $sinhVienCount,
            'giangVienCount' => $giangVienCount,
            'monHocCount' => $monHocCount,
            'lopHocPhanCount' => $lopHocPhanCount,
            'ketQuaCount' => $ketQuaCount
        ]);
    }
    
    // === SINH VIÊN ===
    public function sinhVien() {
        $sinhVienList = $this->sinhVienModel->getAll();
        render('admin/sinhvien', [
            'user' => $_SESSION['user'],
            'sinhVienList' => $sinhVienList,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
    
    public function addSinhVien() {
        $data = [
            'MaSV' => $_POST['MaSV'],
            'HoTen' => $_POST['HoTen'],
            'NgaySinh' => $_POST['NgaySinh'],
            'GioiTinh' => $_POST['GioiTinh'],
            'SDT' => $_POST['SDT'] ?? '',
            'DiaChi' => $_POST['DiaChi'] ?? '',
            'MaLop' => $_POST['MaLop'] ?? '',
            'password' => $_POST['password'] ?? '123456'
        ];
        
        if ($this->sinhVienModel->create($data)) {
            $_SESSION['success'] = 'Thêm sinh viên thành công';
        } else {
            $_SESSION['error'] = 'Thêm sinh viên thất bại';
        }
        redirect('/admin/sinhvien');
    }
    
    public function deleteSinhVien($maSV) {
        if ($this->sinhVienModel->delete($maSV)) {
            $_SESSION['success'] = 'Xóa sinh viên thành công';
        } else {
            $_SESSION['error'] = 'Xóa sinh viên thất bại';
        }
        redirect('/admin/sinhvien');
    }
    
    // === GIẢNG VIÊN ===
    public function giangVien() {
        $giangVienList = $this->giangVienModel->getAll();
        $hocKyList = $this->hocKyModel->getAll();
        render('admin/giangvien', [
            'user' => $_SESSION['user'],
            'giangVienList' => $giangVienList,
            'hocKyList' => $hocKyList,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
    
    public function addGiangVien() {
        $data = [
            'MaGV' => $_POST['MaGV'],
            'HoTen' => $_POST['HoTen'],
            'NgaySinh' => $_POST['NgaySinh'] ?? '1990-01-01',
            'SDT' => $_POST['SDT'] ?? '',
            'MaHK' => $_POST['MaHK'] ?? 'HK1',
            'password' => $_POST['password'] ?? '123456'
        ];
        
        if ($this->giangVienModel->create($data)) {
            $_SESSION['success'] = 'Thêm giảng viên thành công';
        } else {
            $_SESSION['error'] = 'Thêm giảng viên thất bại';
        }
        redirect('/admin/giangvien');
    }
    
    public function deleteGiangVien($maGV) {
        if ($this->giangVienModel->delete($maGV)) {
            $_SESSION['success'] = 'Xóa giảng viên thành công';
        } else {
            $_SESSION['error'] = 'Xóa giảng viên thất bại';
        }
        redirect('/admin/giangvien');
    }
    
    // === HỌC KỲ ===
    public function hocKy() {
        $hocKyList = $this->hocKyModel->getAll();
        render('admin/hocky', [
            'user' => $_SESSION['user'],
            'hocKyList' => $hocKyList,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
    
    public function addHocKy() {
        $data = [
            'MaHK' => $_POST['MaHK'],
            'TenHK' => $_POST['TenHK'],
            'NamHoc' => $_POST['NamHoc']
        ];
        
        if ($this->hocKyModel->create($data)) {
            $_SESSION['success'] = 'Thêm học kỳ thành công';
        } else {
            $_SESSION['error'] = 'Thêm học kỳ thất bại';
        }
        redirect('/admin/hocky');
    }
    
    public function deleteHocKy($maHK) {
        if ($this->hocKyModel->delete($maHK)) {
            $_SESSION['success'] = 'Xóa học kỳ thành công';
        } else {
            $_SESSION['error'] = 'Xóa học kỳ thất bại';
        }
        redirect('/admin/hocky');
    }
    
    // === MÔN HỌC ===
    public function monHoc() {
        $monHocList = $this->monHocModel->getAll();
        render('admin/monhoc', [
            'user' => $_SESSION['user'],
            'monHocList' => $monHocList,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
    
    public function addMonHoc() {
        $data = [
            'MaMH' => $_POST['MaMH'],
            'TenMH' => $_POST['TenMH'],
            'SoTinChi' => (int)$_POST['SoTinChi']
        ];
        
        if ($this->monHocModel->create($data)) {
            $_SESSION['success'] = 'Thêm môn học thành công';
        } else {
            $_SESSION['error'] = 'Thêm môn học thất bại';
        }
        redirect('/admin/monhoc');
    }
    
    public function deleteMonHoc($maMH) {
        if ($this->monHocModel->delete($maMH)) {
            $_SESSION['success'] = 'Xóa môn học thành công';
        } else {
            $_SESSION['error'] = 'Xóa môn học thất bại';
        }
        redirect('/admin/monhoc');
    }
    
    // === LỚP HỌC PHẦN ===
    public function lopHocPhan() {
        $lopHocPhanList = $this->lopHocPhanModel->getAll();
        $monHocList = $this->monHocModel->getAll();
        $giangVienList = $this->giangVienModel->getAll();
        $hocKyList = $this->hocKyModel->getAll();
        
        render('admin/lophocphan', [
            'user' => $_SESSION['user'],
            'lopHocPhanList' => $lopHocPhanList,
            'monHocList' => $monHocList,
            'giangVienList' => $giangVienList,
            'hocKyList' => $hocKyList,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
    
    public function addLopHocPhan() {
        $data = [
            'MaLHP' => $_POST['MaLHP'],
            'MaMH' => $_POST['MaMH'],
            'MaGV' => $_POST['MaGV'],
            'MaHK' => $_POST['MaHK'],
            'SiSo' => (int)($_POST['SiSo'] ?? 0)
        ];
        
        if ($this->lopHocPhanModel->create($data)) {
            $_SESSION['success'] = 'Thêm lớp học phần thành công';
        } else {
            $_SESSION['error'] = 'Thêm lớp học phần thất bại';
        }
        redirect('/admin/lophocphan');
    }
    
    public function deleteLopHocPhan($maLHP) {
        if ($this->lopHocPhanModel->delete($maLHP)) {
            $_SESSION['success'] = 'Xóa lớp học phần thành công';
        } else {
            $_SESSION['error'] = 'Xóa lớp học phần thất bại';
        }
        redirect('/admin/lophocphan');
    }
    
    // === KẾT QUẢ (COMPOSITE KEY) ===
    public function ketQua() {
        $maSV  = trim($_GET['MaSV']  ?? '');
        $maLHP = trim($_GET['MaLHP'] ?? '');
        $maHK  = trim($_GET['MaHK']  ?? '');

        $ketQuaList     = $this->ketQuaModel->getFiltered(
            $maSV  ?: null,
            $maLHP ?: null,
            $maHK  ?: null
        );
        $sinhVienList   = $this->sinhVienModel->getAll();
        $lopHocPhanList = $this->lopHocPhanModel->getAll();
        $hocKyList      = $this->hocKyModel->getAll();

        render('admin/ketqua', [
            'user'           => $_SESSION['user'],
            'ketQuaList'     => $ketQuaList,
            'sinhVienList'   => $sinhVienList,
            'lopHocPhanList' => $lopHocPhanList,
            'hocKyList'      => $hocKyList,
            'filterMaSV'     => $maSV,
            'filterMaLHP'    => $maLHP,
            'filterMaHK'     => $maHK,
            'success'        => $_SESSION['success'] ?? null,
            'error'          => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
    
    public function addKetQua() {
        $data = [
            'MaSV' => $_POST['MaSV'],
            'MaLHP' => $_POST['MaLHP'],
            'DiemChuyenCan' => (float)($_POST['DiemChuyenCan'] ?? 0),
            'DiemGiuaKy' => (float)($_POST['DiemGiuaKy'] ?? 0),
            'DiemCuoiKy' => (float)($_POST['DiemCuoiKy'] ?? 0)
        ];
        
        if ($this->ketQuaModel->createOrUpdate($data)) {
            $_SESSION['success'] = 'Thêm/Cập nhật kết quả thành công';
        } else {
            $_SESSION['error'] = 'Thêm/Cập nhật kết quả thất bại';
        }
        redirect('/admin/ketqua');
    }
    
    public function deleteKetQua($maSV, $maLHP) {
        if ($this->ketQuaModel->delete($maSV, $maLHP)) {
            $_SESSION['success'] = 'Xóa kết quả thành công';
        } else {
            $_SESSION['error'] = 'Xóa kết quả thất bại';
        }
        redirect('/admin/ketqua');
    }
}
?>