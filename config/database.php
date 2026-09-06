<?php
// config/database.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tự động nhận diện BASE_URL theo thư mục cài đặt
if (!defined('BASE_URL')) {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $base = preg_replace('#/(public/)?index\.php$#', '', $scriptName);
    $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if ($base !== '' && str_starts_with($requestUri, $base . '/public')) {
        $base .= '/public';
    }
    define('BASE_URL', rtrim($base, '/'));
}

$host = 'localhost';
$dbname = 'university_management';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Kết nối database thất bại: " . $e->getMessage());
}

// Helper để tạo URL chuẩn
function url($path = '') {
    $base = defined('BASE_URL') ? BASE_URL : '';
    if ($path === '' || $path === '/') {
        return $base ?: '/';
    }
    return ($base ? $base : '') . '/' . ltrim($path, '/');
}

// Helper function để render view
function render($view, $data = []) {
    global $pdo;
    extract($data);
    
    // Kiểm tra view tồn tại
    $viewFile = __DIR__ . '/../views/' . $view . '.php';
    if (!file_exists($viewFile)) {
        die("View không tồn tại: " . $view);
    }
    
    ob_start();
    include $viewFile;
    $content = ob_get_clean();
    
    // Kiểm tra layout
    $layoutFile = __DIR__ . '/../views/layouts/main.php';
    if (file_exists($layoutFile)) {
        include $layoutFile;
    } else {
        echo $content;
    }
}

// Helper để redirect
function redirect($url) {
    if (defined('BASE_URL') && !str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
        $url = url($url);
    }
    header('Location: ' . $url);
    exit;
}

// Helper để format date
function formatDate($date) {
    if (!$date) return '';
    $d = new DateTime($date);
    return $d->format('d/m/Y');
}
?>