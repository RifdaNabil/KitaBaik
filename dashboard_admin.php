<?php include '../config/connection.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - KitaBaik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/stylee.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar text-center">
  <div class="mb-4">
    <img src="../assets/KitaBaik.jpg" alt="KitaBaik Logo" width="100" style="margin-bottom: 10px;">
  </div>

  <div style="position: absolute; bottom: 20px; width: 100%; text-align: center;">
  <a href="logout_admin.php" class="btn btn-admin">Logout</a>
</div>

  <a href="data_users.php">📋 Data Pengguna</a>
  <a href="data_campaign.php">📣 Data Kampanye</a>
  <a href="data_donasi.php">💰 Data Donasi</a>
</div>

<!-- Konten -->
<div class="content">
  <h2>Selamat Datang di Dashboard Admin</h2>
  <p>Silakan pilih menu di sebelah kiri untuk mengelola data.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
