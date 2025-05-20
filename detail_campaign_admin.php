<?php
include '../config/connection.php';
session_start();

// Cek jika belum login
if (!isset($_SESSION['admin_id'])) {
  header("Location: login_admin.php");
  exit;
}

// Ambil ID kampanye dari parameter URL
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $query = mysqli_query($connect, "SELECT * FROM campaign WHERE campaign_id = $id");
  $kampanye = mysqli_fetch_assoc($query);

  if (!$kampanye) {
    echo "Kampanye tidak ditemukan.";
    exit;
  }
} else {
  echo "ID kampanye tidak valid.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Kampanye - KitaBaik Admin</title>
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

<div class="content">
  <h2 class="mb-4">Detail Kampanye: <?= htmlspecialchars($kampanye['title']) ?></h2>

  <div class="card mb-4">
    <div class="card-header">Informasi Kampanye</div>
    <div class="card-body">
      <p><strong>Judul Kampanye:</strong> <?= htmlspecialchars($kampanye['title']) ?></p>
      <p><strong>Kategori:</strong> <?= htmlspecialchars($kampanye['category']) ?></p>
      <p><strong>Deskripsi:</strong> <?= nl2br(htmlspecialchars($kampanye['description'])) ?></p>
      <p><strong>Target Donasi:</strong> Rp <?= number_format($kampanye['target_amount'], 0, ',', '.') ?></p>
      <p><strong>Terkumpul:</strong> Rp <?= number_format($kampanye['current_amount'], 0, ',', '.') ?></p>
      <p><strong>Tanggal Akhir:</strong> <?= date('d M Y', strtotime($kampanye['deadline'])) ?></p>
      <p><strong>Status:</strong> <?= ucfirst($kampanye['status']) ?></p>
      <p><strong>Gambar:</strong></p>
      <?php if ($kampanye['image']) : ?>
        <img src="../uploads/<?= htmlspecialchars($kampanye['image']) ?>" alt="Image" class="img-fluid" width="300">
      <?php else : ?>
        <span>No Image</span>
      <?php endif; ?>
    </div>
  </div>

  <a href="data_campaign.php" class="btn btn-primary">Kembali ke Daftar Kampanye</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
