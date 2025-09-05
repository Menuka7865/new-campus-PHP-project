<?php
session_start();
// Simple router
// Default to 'home' so the initial page is app/pages/home.php
$page = $_GET['page'] ?? 'home';
// pages that require authentication
$authRequired = ['dashboard','students','colors','assignments','reports','profile','logout'];
if(in_array($page,$authRequired) && !isset($_SESSION['user'])){
    header('Location: ?page=login');
    exit;
}
require_once __DIR__ . '/../app/helpers.php';
switch($page){
    case 'login': include __DIR__ . '/../app/pages/login.php'; break;
    case 'signup': include __DIR__ . '/../app/pages/signup.php'; break;
    case 'home': include __DIR__ . '/../app/pages/home.php'; break;
    case 'logout': session_destroy(); header('Location: ?page=login'); break;
    case 'dashboard': include __DIR__ . '/../app/pages/dashboard.php'; break;
    case 'students': include __DIR__ . '/../app/pages/students.php'; break;
    case 'colors': include __DIR__ . '/../app/pages/colors.php'; break;
    case 'assignments': include __DIR__ . '/../app/pages/assignments.php'; break;
    case 'reports': include __DIR__ . '/../app/pages/reports.php'; break;
    case 'profile': include __DIR__ . '/../app/pages/profile.php'; break;
    default: echo 'Page not found';
}