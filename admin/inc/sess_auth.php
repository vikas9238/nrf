<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $link = "https";
else
    $link = "http";
$link .= "://";
$link .= $_SERVER['HTTP_HOST'];
$link .= $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['admindata']) && !strpos($link, 'login.php')) {
    redirect('admin/login.php');
}
if (isset($_SESSION['admindata']) && strpos($link, 'login.php') && $_SESSION['admindata']['loggedin'] ==  1) {
    redirect('admin/index.php');
}
$module = array('', 'admin');
if (isset($_SESSION['admindata']) && (strpos($link, 'index.php') || strpos($link, 'admin/')) && $_SESSION['admindata']['loggedin'] !=  1) {
    echo "<script>alert('Access Denied!');location.replace('" . base_url . $module[$_SESSION['admindata']['login_type']] . "');</script>";
    exit;
}
