<?php
require '../config/connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: admin/login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Cek apakah ada parameter 'campaign_id' di URL
if (isset($_GET['campaign_id'])) {
    $campaign_id = $_GET['campaign_id'];

    // Ambil data kampanye berdasarkan ID yang diterima
    $campaign_result = mysqli_query($connect, "SELECT campaign_id, title FROM campaign WHERE campaign_id = $campaign_id AND user_id = $user_id");

    if (mysqli_num_rows($campaign_result) == 0) {
        echo "<div class='alert alert-warning'>Kampanye tidak ditemukan.</div>";
        exit;
    }
    $campaign_data = mysqli_fetch_assoc($campaign_result);
} else {
    echo "<div class='alert alert-warning'>ID kampanye tidak ditemukan.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buat Update Kampanye | KitaBaik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body {
      background-color: #FFFDF4;
      font-family: 'Montserrat', sans-serif;
    }
    .form-section {
      background-color: #FAF6E9;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-kb {
      background-color: #DDEB9D;
      color: #000;
      border: none;
    }
    .btn-kb:hover {
      background-color: #cddc90;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="beranda.php">
      <img src="../assets/KitaBaik.jpg" alt="Logo" width="80" class="me-2">
    </a>
    <div class="d-flex">
      <a href="dashboard.php" class="btn btn-kb me-2">Dashboard</a>
      <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
  </div>
</nav>

<!-- Konten -->
<div class="container py-5">
  <div class="form-section mx-auto" style="max-width: 700px;">
    <h3 class="mb-4 text-center">Buat Update Kampanye</h3>
    <form action="proses_update_campaign.php" method="POST" enctype="multipart/form-data">
      <!-- Tidak perlu pilih kampanye, langsung tampilkan judul kampanye yang dipilih -->
      <div class="mb-3">
        <label for="campaign_id" class="form-label">Kampanye Terpilih</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($campaign_data['title']) ?>" disabled>
        <input type="hidden" name="campaign_id" value="<?= $campaign_data['campaign_id'] ?>">
      </div>

      <div class="mb-3">
        <label for="title" class="form-label">Judul Update</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Dana Sudah Disalurkan ke Penerima" required>
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">Isi Update</label>
        <textarea name="content" id="content" class="form-control" rows="6" placeholder="Tuliskan perkembangan terbaru..." required></textarea>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Unggah Gambar (opsional)</label>
        <input type="file" name="image" id="image" class="form-control">
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-kb px-4">Kirim Update</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
