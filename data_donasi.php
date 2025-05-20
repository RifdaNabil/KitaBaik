<?php
include '../config/connection.php';
session_start();

// Cek jika admin belum login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

// Ambil data donasi
$query = "SELECT d.donation_id, u.fullname AS donor_name, c.title AS campaign_title, d.amount, d.payment_method, d.payment_status, d.created_at
          FROM donation d
          JOIN users u ON d.user_id = u.user_id
          JOIN campaign c ON d.campaign_id = c.campaign_id
          ORDER BY d.created_at DESC";

$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Donasi - KitaBaik Admin</title>
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
        <h2 class="mb-4">Data Donasi</h2>
        <table class="table table-bordered admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Donatur</th>
                    <th>Kampanye</th>
                    <th>Jumlah Donasi</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Donasi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['donor_name']) ?></td>
                        <td><?= htmlspecialchars($row['campaign_title']) ?></td>
                        <td>Rp <?= number_format($row['amount'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['payment_method']) ?></td>
                        <td><?= ucfirst($row['payment_status']) ?></td>
                        <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
