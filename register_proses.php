<?php
    session_start();
//Masukkan file connection.php
require '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
//Ambil nilai input fullname
    $fullname= htmlspecialchars($_POST['fullname']);
//Ambil nilai input email
    $email= htmlspecialchars($_POST['email']);
//Ambil nilai input birthdate
    $birthdate= htmlspecialchars($_POST['birthdate']);
//Ambil nilai input password
    $password= htmlspecialchars($_POST['password']);
//Ambil nilai input confirm password
    $password_confirm= htmlspecialchars($_POST['password_confirm']);

//Variabel menampung error validasi
    $error=[];
//Pengecekkan input fullname tidak boleh kosong
    if (empty($fullname)) {
        $error['fullname'] = "Fullname is required";
    }
//Pengecekkan input email tidak boleh kosong
    if (empty($email)) {
        $error['email'] = "Email is required";
    }
//Pengecekkan input birthday tidak boleh kosong
    if (empty($birthdate)) {
        $error['birthdate'] = "Birthday is required";
    }
//Pengecekkan input password tidak boleh kosong
    if (empty($password)) {
        $error['password'] = "Password is required";
    }
//Pengecekkan input confirm password tidak boleh kosong
    if (empty($password_confirm)) {
        $error['password_confirm'] = "Confirm Password is required";
    }

//Pengecekkan apakah input password dan confirm password sama
    if ($password !== $password_confirm) {
        $error['password_confirm'] = "Password and Confirm Password do not match";
    }

//Apabila ada error, kirim data error ke index.php
if (!empty($error)) {
    $_SESSION['error'] = $error;
    $_SESSION['old']=[
        "fullname"=> $fullname,
        "email"=> $email,
        "birthdate"=> $birthdate,
    ];
    echo"<meta http-equiv='refresh' content='1;url=dashboard.php'>";
    exit();
}

//Jika tidak ada error disetiap inpput simpan data register ke table users
if (empty($error)) {
//Mengubah password yang di inputkan menjadi random sebanyak 255 karakter
    $hash_password= password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users(fullname, email, birthdate, password) VALUES ('$fullname','$email','$birthdate','$hash_password')";
//Simpan data dengan memproses query di atas 
if (mysqli_query($connect, $query)) {
    echo"<meta http-equiv='refresh' content='1;url=login.php'>";
}else{
    echo"ERROR :" . mysqli_error($connect);
}
}
}
?>