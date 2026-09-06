<?php
// middleware/auth.php

function isAuthenticated() {
    if (!isset($_SESSION['user'])) {
        redirect('/auth/login');
        exit;
    }
    return true;
}

function isAdmin() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $_SESSION['error'] = 'Bạn không có quyền truy cập';
        redirect('/auth/login');
        exit;
    }
    return true;
}

function isProfessor() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'professor') {
        $_SESSION['error'] = 'Bạn không có quyền truy cập';
        redirect('/auth/login');
        exit;
    }
    return true;
}

function isStudent() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
        $_SESSION['error'] = 'Bạn không có quyền truy cập';
        redirect('/auth/login');
        exit;
    }
    return true;
}
?>