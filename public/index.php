<?php

$page = $_GET['page'] ?? 'accueil';

switch ($page) {

    case 'dictionnaire':
        require_once __DIR__ . '/../controllers/MotController.php';
        break;

   // case 'admin':
    //    require_once __DIR__ . '/../controllers/AdminController.php';
     //   break;

    default:
        require_once __DIR__ . '/../views/home.php';
        break;
}