<?php
include '../config/connection.php';
session_start();

// Cek kalau belum login
if (!isset($_SESSION['admin_id'])) {
  header("Location: login_admin.php");
  exit;
}

// Proses hapus jika ada aksi
if (isset($_GET['hapus'])) {
  $user_id = intval($_GET['hapus']);

  // Cek apakah user punya campaign
  $check = mysqli_query($connect, "SELECT * FROM campaign WHERE user_id = $user_id");

  if (mysqli_num_rows($check) > 0) {
      echo "<div class='alert alert-danger'>Tidak bisa menghapus user karena masih memiliki campaign aktif.</div>";
  } else {
      mysqli_query($connect, "DELETE FROM users WHERE user_id = $user_id");
      header("Location: data_users.php");
      exit;
  }
}

// Ambil semua data pengguna
$query = mysqli_query($connect, "SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pengguna - KitaBaik Admin</title>
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
  <h2 class="mb-4">Data Pengguna</h2>
  <table class="table table-bordered admin-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Lengkap</th>
        <th>Email</th>
        <th>Tanggal Daftar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['fullname']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
          <td>
            <a href="?hapus=<?= $row['user_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus pengguna ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
