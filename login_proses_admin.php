<?php
session_start();
require_once '../config/connection.php'; // pastikan file ini sudah konek ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Cek apakah admin dengan email ini ada
    $query = "SELECT * FROM admins WHERE email = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika admin ditemukan
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            // Simpan data login ke session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['admins_id'];
            $_SESSION['admin_name'] = $admin['fullname'];

            header("Location: dashboard_admin.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Kata sandi salah.";
            header("Location: login_admin.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Email tidak ditemukan.";
        header("Location: login_admin.php");
        exit();
    }
} else {
    header("Location: login_admin.php");
    exit();
}
?>
