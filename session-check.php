<?php
session_start();
$timeout = 1800; //seconds
if (!isset($_SESSION['username'])) {
        include 'logout-process.php';
} else {
    if ((time() - $_SESSION['login_time']) > $timeout) {
        include 'logout-process.php';
    }
}
?>