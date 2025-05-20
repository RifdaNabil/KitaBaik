<?php
session_start();
include '../config/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $target_amount = $_POST['target_amount'];
    $deadline = $_POST['deadline'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $image_path = '';
    if ($_FILES['image']['name']) {
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    $sql = "INSERT INTO campaign (user_id, title, description, target_amount, deadline, category, image_path) 
            VALUES ('$user_id', '$title', '$description', '$target_amount', '$deadline', '$category', '$image_path')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Kampanye berhasil dibuat!');window.location='dashboard.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Kampanye</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css"> <!-- gunakan style kamu -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Buat Kampanye Donasi</h2>
        <form action="campaign_proses.php" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="title" class="form-label">Judul Kampanye</label>
    <input type="text" class="form-control" name="title" required>
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea class="form-control" name="description" rows="4" required></textarea>
  </div>
  <div class="mb-3">
    <label for="target_amount" class="form-label">Target Donasi (Rp)</label>
    <input type="number" step="0.01" class="form-control" name="target_amount" required>
  </div>
  <div class="mb-3">
    <label for="deadline" class="form-label">Tenggat Waktu</label>
    <input type="date" class="form-control" name="deadline" required>
  </div>
  <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Aksi Sosial">Aksi Sosial</option>
                <option value="Donasi Pasien">Donasi Pasien</option>
                <option value="Donasi Pohon">Donasi Pohon</option>
                <option value="Zakat">Zakat</option>
                <option value="Sedekah">Sedekah</option>
            </select>
        </div>
  <div class="mb-3">
    <label for="image" class="form-label">Unggah Gambar</label>
    <input type="file" class="form-control" name="image" required>
  </div>
  <button type="submit" class="btn btn-kb">Buat Kampanye</button>
</form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
