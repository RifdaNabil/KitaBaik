<?php
session_start();
//masukan file koneksi
require "../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    //ambil nilai dari input email dan password
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    //cek apakah input email dan password tidak kosong
    if (empty($email) || empty($password)){
        $_SESSION['login_eror'] = "Email or Password are requreid";
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
        exit();
    }

    // cek email dan passsword yg dikirimkan database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connect, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        //kondisi email dan password valid
        //bawa id dan fullname user yang login ke database.php
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['fullname'] = $user['fullname'];
        echo "<meta http-equiv='refresh' content='1;url=../beranda.php'>";
    } else {
        //kondisi email dan password tidak valid
        $_SESSION['login_error'] = "invalid email or password";
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    }
}
?>