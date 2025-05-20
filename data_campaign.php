<?php
include '../config/connection.php';
session_start();

// Cek jika belum login
if (!isset($_SESSION['admin_id'])) {
  header("Location: login_admin.php");
  exit;
}

// Proses hapus kampanye
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);

  // Hapus data terkait dari tabel campaign_update
  mysqli_query($connect, "DELETE FROM campaign_update WHERE campaign_id = $id");

  // Hapus donasi terkait
  mysqli_query($connect, "DELETE FROM donation WHERE campaign_id = $id");

  // Hapus kampanye setelah data terkait dihapus
  $delete_campaign = mysqli_query($connect, "DELETE FROM campaign WHERE campaign_id = $id");

  if ($delete_campaign) {
    echo "<script>
      alert('Kampanye dan semua data terkait berhasil dihapus.');
      window.location.href='data_campaign.php';
    </script>";
  } else {
    echo "<script>
      alert('Gagal menghapus kampanye.');
      window.location.href='data_campaign.php';
    </script>";
  }
  exit;
}

// Proses update status kampanye
if (isset($_POST['update_status'])) {
  $campaign_id = intval($_POST['campaign_id']);
  $new_status = $_POST['status'];

  // Update status kampanye
  $update_query = mysqli_query($connect, "UPDATE campaign SET status='$new_status' WHERE campaign_id=$campaign_id");

  if ($update_query) {
    header("Location: data_campaign.php");
    exit;
  } else {
    echo "Gagal memperbarui status kampanye.";
  }
}

// Ambil data kampanye
$query = mysqli_query($connect, "SELECT * FROM campaign ORDER BY deadline DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Kampanye - KitaBaik Admin</title>
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
  <h2 class="mb-4">Data Kampanye</h2>
  <table class="table table-bordered admin-table">
  <thead>
    <tr>
      <th>No</th>
      <th>Judul Kampanye</th>
      <th>Kategori</th>
      <th>Target Donasi</th>
      <th>Terkumpul</th>
      <th>Status</th>
      <th>Tanggal Akhir</th>
      <th>Gambar</th> <!-- Kolom untuk menampilkan gambar -->
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= htmlspecialchars($row['title']) ?></td>
  <td><?= htmlspecialchars($row['category']) ?></td>
  <td>Rp <?= number_format($row['target_amount'], 0, ',', '.') ?></td>
  <td>Rp <?= number_format($row['current_amount'], 0, ',', '.') ?></td>

  <!-- FORM STATUS DI SINI -->
  <td>
    <form method="POST" action="">
      <input type="hidden" name="campaign_id" value="<?= $row['campaign_id'] ?>">
      <select name="status" class="form-select form-select-sm d-inline w-auto">
        <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="aktif" <?= $row['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
        <option value="selesai" <?= $row['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
        <option value="ditolak" <?= $row['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
      </select>
      <button type="submit" name="update_status" class="btn btn-sm btn-primary">✔</button>
    </form>
  </td>

  <td><?= date('d M Y', strtotime($row['deadline'])) ?></td>
  <td>
    <?php if ($row['image']) : ?>
      <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="Image" width="50">
    <?php else : ?>
      <span>No Image</span>
    <?php endif; ?>
  </td>
  <td>
    <a href="?hapus=<?= $row['campaign_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus kampanye ini?')">Hapus</a>
    <a href="detail_campaign_admin.php?id=<?= $row['campaign_id'] ?>" class="btn btn-sm btn-info">Detail</a>
  </td>
</tr>
<?php endwhile; ?>

  </tbody>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
