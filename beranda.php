<?php
session_start();
$user = $_SESSION['fullname'] ?? null;
require 'config/connection.php';

// Ambil data kampanye aktif dari database
$sql = "SELECT * FROM campaign WHERE status = 'aktif' ORDER BY campaign_id DESC LIMIT 6";
$stmt = $connect->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KitaBaik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 shadow-sm">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center">
      <img src="assets/KitaBaik.jpg" alt="Logo" width="100" height="100" class="me-2">
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Navigasi -->
    <div class="collapse navbar-collapse show" id="mainNavbar">
      <ul class="navbar-nav flex-row gap-3">
        <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
      </ul>
    </div>

    <div class="d-flex align-items-center">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="pengguna/dashboard.php" class="btn btn-kb me-2">Galang Dana</a>
        <a href="pengguna/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
      <?php else: ?>
        <a href="pengguna/login.php" class="btn btn-kb">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Gambar bergeser -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel" style="height: 75vh; overflow: hidden;">
  <div class="carousel-inner h-100">

    <div class="carousel-item active h-100">
      <img src="assets/KitaBaik.png" class="d-block mx-auto h-100 carousel-image" alt="Logo KitaBaik">
    </div>

    <div class="carousel-item h-100">
      <img src="assets/donasi 1.jpg" class="d-block mx-auto h-100 carousel-image" alt="Anak-anak Belajar">
    </div>

    <div class="carousel-item h-100">
      <img src="assets/donasi 2.jpg" class="d-block mx-auto h-100 carousel-image" alt="Menanam Pohon">
    </div>

  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </button>
</div>


<!-- Kampanye Aktif -->
<div class="container py-5">
  <h2 class="text-center mb-4">Kampanye Donasi Terbaru</h2>

  <div class="row">
    <?php while ($campaign = $result->fetch_assoc()): ?>
      <div class="col-md-4 mb-4">
        <div class="card">
          <?php if (!empty($campaign['image_path'])): ?>
            <img src="uploads/<?= htmlspecialchars($campaign['image_path']) ?>" class="card-img-top" alt="Gambar Kampanye">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($campaign['title']) ?></h5>
            <p class="card-text"><?= substr(htmlspecialchars($campaign['description']), 0, 100) ?>...</p>
            <p><strong>Target:</strong> Rp<?= number_format($campaign['target_amount'], 0, ',', '.') ?></p>
            <div class="d-flex justify-content-between">
              <a href="detail_campaign.php?id_kampanye=<?= $campaign['campaign_id'] ?>" class="btn btn-kb">Lihat Detail</a>
              <a href="donasi.php?id_kampanye=<?= $campaign['campaign_id'] ?>" class="btn btn-kb">Donasi Sekarang</a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>
</div>
<!-- Footer -->
<footer class="bg-light text-center py-4">
  <p>&copy; 2023 KitaBaik. All rights reserved.</p>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
