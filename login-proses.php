<?php
$valid_username = "admin";
$valid_password = "admin123";

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username !== "" && $password !== "") {
        if ($username === $valid_username && $password === $valid_password) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['login_time'] = time();
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect username or password.";
        }
    }
}
if ($error) {
    echo '<div class="text-danger mt-2 text-center">' . $error . '</div>';
}
?>