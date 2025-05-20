<?php
session_start();
include '../config/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = isset($_POST['title']) ? mysqli_real_escape_string($connect, $_POST['title']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($connect, $_POST['description']) : '';
    $target_amount = isset($_POST['target_amount']) ? $_POST['target_amount'] : 0;
    $deadline = isset($_POST['deadline']) ? $_POST['deadline'] : null;
    $category = isset($_POST['category']) ? mysqli_real_escape_string($connect, $_POST['category']) : '';

    $image_path = '';
    $image_name = '';

    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $image_path = '../uploads/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    } else {
        echo "<script>alert('Gambar wajib diunggah!'); window.location='create_campaign.php';</script>";
        exit();
    }

    $sql = "INSERT INTO campaign 
        (user_id, title, description, target_amount, deadline, category, image_path, image) 
        VALUES 
        ('$user_id', '$title', '$description', '$target_amount', '$deadline', '$category', '$image_path', '$image_name')";

    if (mysqli_query($connect, $sql)) {
        echo "<script>alert('Kampanye berhasil dibuat!');window.location='dashboard.php';</script>";
    } else {
        echo "Gagal membuat kampanye: " . mysqli_error($connect);
    }
} else {
    header("Location: dashboard.php");
}
?>
