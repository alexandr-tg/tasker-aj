<?php
session_start();
require_once 'vendor/autoload.php';

if($_SESSION['user_id']){
    require_once 'view/main.php';
} else {
    require_once 'view/auth.php';
}
