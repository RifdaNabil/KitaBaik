<?php
session_start();
require '../config/connection.php';

$user_id = $_SESSION['user_id'] ?? null; // Ambil user_id dari session

if (!$user_id) {
    echo "<div class='alert alert-warning'>Anda belum login.</div>";
    exit;
}

// Ambil riwayat donasi dari database
$sql = "SELECT d.donation_id, c.title AS campaign_title, d.amount, d.payment_method, d.payment_status, d.created_at
        FROM donation d
        JOIN campaign c ON d.campaign_id = c.campaign_id
        WHERE d.user_id = ? ORDER BY d.created_at DESC";

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
  <title>KitaBaik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 shadow-sm">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center">
      <img src="../assets/KitaBaik.jpg" alt="Logo" width="100" height="100" class="me-2">
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
        <a href="admin/dashboard.php" class="btn btn-kb me-2">Galang Dana</a>
        <a href="admin/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
      <?php else: ?>
        <a href="admin/login.php" class="btn btn-kb">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container py-5">
    <h2 class="mb-4">Riwayat Donasi Anda</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kampanye</th>
                    <th>Jumlah Donasi</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Donasi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($donation = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($donation['campaign_title']) ?></td>
                        <td>Rp<?= number_format($donation['amount'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($donation['payment_method']) ?></td>
                        <td>
                            <?php
                                if ($donation['payment_status'] == 'pending') {
                                    echo "<span class='text-warning'>Pending</span>";
                                } elseif ($donation['payment_status'] == 'completed') {
                                    echo "<span class='text-success'>Completed</span>";
                                } else {
                                    echo "<span class='text-danger'>Failed</span>";
                                }
                            ?>
                        </td>
                        <td><?= date('d-m-Y H:i', strtotime($donation['created_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Belum ada donasi yang dilakukan.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
