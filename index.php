
<?php
include_once 'config/db.php';
session_start();
$page = isset($_GET['page']) ? $_GET['page'] :"home";
function loadPage($page){
    if ($page === 'home'){
      include 'file_/home.php';
    }else if ($page === 'login'){
      include 'file_/login.php';
    }else if ($page === 'logout'){
      include 'file_/logout.php';
    } else if ($page === 'register'){
      include 'file_/register.php';
    }else if ($page === 'about'){
      include 'file_/about.php';
    }else if ($page === 'user_dashboard' && isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
      include 'file_/user_dashboard.php'; // Buat file ini
  }else if ($page === 'manage_users' && isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
      include 'file_/manage_users.php'; // Buat file ini
  } else {
      include 'file_/404/error.php';  
    }
}
  

include '_parcials/_template/header.php';
loadPage(page: $page);?>