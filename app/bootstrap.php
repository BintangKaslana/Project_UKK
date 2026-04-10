<?php
 
//[path]
$rootPath = dirname(__DIR__);
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $rootPath);
}
if (!defined('APP_PATH')) {
    define('APP_PATH', ROOT_PATH . '/app');
}
if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', ROOT_PATH . '/views');
}
if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', ROOT_PATH . '/public');
}
if (!defined('BASE_PATH')) {
    $basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    define('BASE_PATH', $basePath === '' ? '' : $basePath);
}

//env
error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set('Asia/Makassar');

//session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//database connection (provides $conn)
require_once PUBLIC_PATH . '/connection.php';