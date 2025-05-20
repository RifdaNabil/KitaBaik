<?php
require 'config/connection.php';
session_start();

if (!isset($_GET['id_kampanye'])) {
    echo "<div class='alert alert-warning'>ID kampanye tidak ditemukan.</div>";
    exit;
}

$campaign_id = $_GET['id_kampanye']; 

// Ambil data kampanye
$sql = "SELECT c.*, u.fullname FROM campaign c JOIN users u ON c.user_id = u.user_id WHERE c.campaign_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $campaign_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='alert alert-danger'>Kampanye tidak ditemukan.</div>";
    exit;
}

$campaign = $result->fetch_assoc();

// Ambil update kampanye
$sql_updates = "SELECT * FROM campaign_update WHERE campaign_id = ? ORDER BY update_date DESC";
$stmt_updates = $connect->prepare($sql_updates);
$stmt_updates->bind_param("i", $campaign_id);
$stmt_updates->execute();
$updates = $stmt_updates->get_result();

//Ambil Pesan dari donatur
$donations = $connect->prepare("SELECT d.*, u.fullname FROM donation d JOIN users u ON d.user_id = u.user_id WHERE d.campaign_id = ? ORDER BY d.donation_id DESC");
$donations->bind_param("i", $campaign_id);
$donations->execute();
$donation_result = $donations->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Kampanye | KitaBaik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center">
                <img src="assets/KitaBaik.jpg" alt="Logo" width="100" height="100" class="me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
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

    <div class="container py-5">
        <h2 class="mb-4"><?= htmlspecialchars($campaign['title']) ?></h2>
        <?php if (!empty($campaign['image_path'])): ?>
            <img src="uploads/<?= htmlspecialchars($campaign['image_path']) ?>" class="img-fluid mb-3" alt="Gambar Kampanye" style="max-height: 400px; object-fit: cover;">
        <?php endif; ?>
        <p><strong>Dibuat oleh:</strong> <?= htmlspecialchars($campaign['fullname']) ?></p>
        <p><strong>Kategori:</strong> <?= htmlspecialchars($campaign['category']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($campaign['status']) ?></p>
        <p><strong>Target Donasi:</strong> Rp<?= number_format($campaign['target_amount'], 0, ',', '.') ?></p>
        <p><strong>Terkumpul:</strong> Rp<?= number_format($campaign['current_amount'], 0, ',', '.') ?></p>
        <p><strong>Batas Waktu:</strong> <?= htmlspecialchars($campaign['deadline']) ?></p>
        <hr>
        <p><?= nl2br(htmlspecialchars($campaign['description'])) ?></p>

        <a href="donasi.php?id_kampanye=<?= $campaign['campaign_id'] ?>" class="btn btn-success mt-3">Donasi Sekarang</a>

        <hr>
        <h5>Update Kampanye</h5>
        <?php if ($updates->num_rows > 0): ?>
            <?php while ($update = $updates->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title"><?= htmlspecialchars($update['title']) ?></h6>
                        <p class="card-text"><?= nl2br(htmlspecialchars($update['content'])) ?></p>
                        <p class="text-muted small">Diposting pada <?= date("d M Y H:i", strtotime($update['update_date'])) ?></p>
                        <img src="uploads/<?= htmlspecialchars($update['image_path']) ?>" class="img-fluid mb-3" style="max-height:300px;" alt="Update Gambar">
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada update untuk kampanye ini.</p>
        <?php endif; ?>
    </div>

    <!-- Tambahkan container baru untuk pesan donatur -->
    <div class="container mb-5">
        <h4 class="mt-5">Pesan dari Para Donatur</h4>
        <?php while ($d = $donation_result->fetch_assoc()): ?>
            <div class="border rounded p-3 mb-2">
                <strong><?= $d['is_anonymous'] ? 'Anonim' : htmlspecialchars($d['fullname']) ?></strong>
                <p><?= nl2br(htmlspecialchars($d['message'])) ?></p>
                <small>Donasi: Rp<?= number_format($d['amount'], 0, ',', '.') ?></small>
            </div>
        <?php endwhile; ?>
    </div>


</body>
</html>
