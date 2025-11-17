<?php
session_start();
require_once 'config/koneksi.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    // reCAPTCHA verification
    $recaptcha_secret = '6LfjCwwsAAAAACBE-UNXlYCy-zjCaneZ5XDXxtpb';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_keys = json_decode($response, true);

    if (intval($response_keys["success"]) !== 1) {
        header('Location: login.php?error=2');
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($password == $row['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header('Location: index.php'); // Redirect to a dashboard or home page
        } else {
            header('Location: login.php?error=1');
        }
    } else {
        header('Location: login.php?error=1');
    }
} else {
    header('Location: login.php');
}
?>