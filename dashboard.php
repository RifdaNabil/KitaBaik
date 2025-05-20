<?php
session_start();
require '../config/connection.php'; // Tambahkan koneksi

// Cek login
if (!isset($_SESSION['fullname']) || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];

// Ambil campaign milik user
$sql = "SELECT * FROM campaign WHERE user_id = ? ORDER BY campaign_id DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Donatur | KitaBaik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center">
      <img src="../assets/KitaBaik.jpg" alt="Logo" width="100" height="100" class="me-2">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse show" id="mainNavbar">
      <ul class="navbar-nav flex-row gap-3">
        <li class="nav-item"><a class="nav-link" href="../beranda.php">Beranda</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <div class="text-center mb-4">
    <h2>Hai, <?= htmlspecialchars($fullname) ?> 👋</h2>
    <p>Selamat datang di dashboard KitaBaik</p>
  </div>

  <div class="row g-4 justify-content-center">
    <!-- Buat Kampanye -->
    <div class="col-md-3">
      <div class="card p-4 text-center">
        <h5 class="mb-3">Buat Kampanye</h5>
        <a href="create_campaign.php" class="btn btn-kb w-100">Mulai</a>
      </div>
    </div>

    <!-- Riwayat Donasi -->
    <div class="col-md-3">
      <div class="card p-4 text-center">
        <h5 class="mb-3">Riwayat Donasi</h5>
        <a href="riwayat_donasi.php" class="btn btn-kb w-100">Lihat</a>
      </div>
    </div>

    <!-- Edit Profil -->
    <div class="col-md-3">
      <div class="card p-4 text-center">
        <h5 class="mb-3">Edit Profil</h5>
        <a href="edit_profil.php" class="btn btn-kb w-100">Ubah</a>
      </div>
    </div>
        <!-- Logout -->
    <div class="col-md-3">
      <div class="card p-4 text-center">
        <h5 class="mb-3">Logout</h5>
        <a href="logout.php" class="btn btn-danger w-100">Keluar</a>
      </div>
    </div>
  </div> <!-- Tutup row g-4 -->
</div> <!-- Tutup container py-5 -->

<!-- Kampanye User -->
<div class="container py-5">
  <h4 class="mb-4">Kampanye Kamu</h4>
  <div class="row">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($row['image_path'])): ?>
              <img src="<?= htmlspecialchars($row['image_path']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($row['title']) ?>">
            <?php endif; ?>
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                <p class="card-text"><?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...</p>
                <p class="mb-1"><strong>Target:</strong> Rp<?= number_format($row['target_amount'], 0, ',', '.') ?></p>
                <p class="mb-1"><strong>Terkumpul:</strong> Rp<?= number_format($row['current_amount'], 0, ',', '.') ?></p>
                <p class="mb-3"><strong>Status:</strong> <?= htmlspecialchars($row['status'] ?? '') ?></p>  
              </div>

              <!-- Baris 1: Tombol utama -->
              <div class="d-grid mb-2">
                <a href="../detail_campaign.php?id_kampanye=<?= $row['campaign_id'] ?>" class="btn btn-kb w-100">Lihat Detail</a>
              </div>

              <!-- Baris 2: Tombol edit, update, hapus -->
              <div class="d-flex gap-2">
                <a href="edit_campaign.php?id=<?= $row['campaign_id'] ?>" class="btn btn-outline-secondary btn-sm w-100">Edit</a>
                <a href="update_campaign.php?campaign_id=<?= $row['campaign_id'] ?>" class="btn btn-outline-success btn-sm w-100">Update</a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted">Belum ada kampanye yang kamu buat.</p>
    <?php endif; ?>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
