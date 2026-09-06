<?php
// routes/index.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../controllers/ProfessorController.php';
require_once __DIR__ . '/../controllers/StudentController.php';
require_once __DIR__ . '/../middleware/auth.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (defined('BASE_URL') && BASE_URL !== '' && str_starts_with($uri, BASE_URL)) {
    $uri = substr($uri, strlen(BASE_URL));
}
if ($uri === '' || $uri === false) {
    $uri = '/';
}
$method = $_SERVER['REQUEST_METHOD'];

// Khởi tạo controllers
$authController = new AuthController($pdo);
$adminController = new AdminController($pdo);
$professorController = new ProfessorController($pdo);
$studentController = new StudentController($pdo);

// === AUTH ===
if ($uri === '/auth/login' && $method === 'GET') {
    $authController->showLogin();
} elseif ($uri === '/auth/login' && $method === 'POST') {
    $authController->login();
} elseif ($uri === '/auth/logout') {
    $authController->logout();
}

// === ADMIN ===
elseif (str_starts_with($uri, '/admin')) {
    isAdmin();
    
    if ($uri === '/admin/dashboard') {
        $adminController->dashboard();
    } elseif ($uri === '/admin/sinhvien' && $method === 'GET') {
        $adminController->sinhVien();
    } elseif ($uri === '/admin/sinhvien/add' && $method === 'POST') {
        $adminController->addSinhVien();
    } elseif (preg_match('/\/admin\/sinhvien\/delete\/(.+)/', $uri, $matches)) {
        $adminController->deleteSinhVien($matches[1]);
    } elseif ($uri === '/admin/giangvien' && $method === 'GET') {
        $adminController->giangVien();
    } elseif ($uri === '/admin/giangvien/add' && $method === 'POST') {
        $adminController->addGiangVien();
    } elseif (preg_match('/\/admin\/giangvien\/delete\/(.+)/', $uri, $matches)) {
        $adminController->deleteGiangVien($matches[1]);
    } elseif ($uri === '/admin/monhoc' && $method === 'GET') {
        $adminController->monHoc();
    } elseif ($uri === '/admin/monhoc/add' && $method === 'POST') {
        $adminController->addMonHoc();
    } elseif (preg_match('/\/admin\/monhoc\/delete\/(.+)/', $uri, $matches)) {
        $adminController->deleteMonHoc($matches[1]);
    } elseif ($uri === '/admin/hocky' && $method === 'GET') {
        $adminController->hocKy();
    } elseif ($uri === '/admin/hocky/add' && $method === 'POST') {
        $adminController->addHocKy();
    } elseif (preg_match('/\/admin\/hocky\/delete\/(.+)/', $uri, $matches)) {
        $adminController->deleteHocKy($matches[1]);
    } elseif ($uri === '/admin/lophocphan' && $method === 'GET') {
        $adminController->lopHocPhan();
    } elseif ($uri === '/admin/lophocphan/add' && $method === 'POST') {
        $adminController->addLopHocPhan();
    } elseif (preg_match('/\/admin\/lophocphan\/delete\/(.+)/', $uri, $matches)) {
        $adminController->deleteLopHocPhan($matches[1]);
    } elseif ($uri === '/admin/ketqua' && $method === 'GET') {
        $adminController->ketQua();
    } elseif ($uri === '/admin/ketqua/add' && $method === 'POST') {
        $adminController->addKetQua();
    } elseif (preg_match('/\/admin\/ketqua\/delete\/(.+)\/(.+)/', $uri, $matches)) {
        $adminController->deleteKetQua($matches[1], $matches[2]);
    }
}

// === PROFESSOR ===
elseif (str_starts_with($uri, '/professor')) {
    isProfessor();
    
    if ($uri === '/professor/dashboard') {
        $professorController->dashboard();
    } elseif ($uri === '/professor/classes') {
        $professorController->getClasses();
    } elseif (preg_match('/\/professor\/students\/(.+)/', $uri, $matches)) {
        $professorController->getClassStudents($matches[1]);
    } elseif ($uri === '/professor/update-score' && $method === 'POST') {
        $professorController->updateScore();
    } elseif ($uri === '/professor/search') {
        $professorController->searchStudents();
    }
}

// === STUDENT ===
elseif (str_starts_with($uri, '/student')) {
    isStudent();
    
    if ($uri === '/student/dashboard') {
        $studentController->dashboard();
    } elseif ($uri === '/student/profile') {
        $studentController->getProfile();
    } elseif ($uri === '/student/grades') {
        $studentController->getGrades();
    } elseif ($uri === '/student/transcript') {
        $studentController->getTranscript();
    }
}

// === HOME ===
elseif ($uri === '/' || $uri === '') {
    if (isset($_SESSION['user'])) {
        $role = $_SESSION['user']['role'];
        if ($role === 'admin') redirect('/admin/dashboard');
        elseif ($role === 'professor') redirect('/professor/dashboard');
        elseif ($role === 'student') redirect('/student/dashboard');
    } else {
        redirect('/auth/login');
    }
}

// === 404 ===
else {
    http_response_code(404);
    render('error', [
        'title' => '404 - Không tìm thấy',
        'message' => 'Trang bạn yêu cầu không tồn tại'
    ]);
}
?>