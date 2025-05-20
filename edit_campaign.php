<?php
session_start();
require '../config/connection.php'; // Tambahkan koneksi

// Cek login
if (!isset($_SESSION['fullname']) || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Cek apakah ada ID kampanye
if (isset($_GET['id'])) {
    $campaign_id = $_GET['id'];

    // Ambil data kampanye dari database
    $sql = "SELECT * FROM campaign WHERE campaign_id = ? AND user_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $campaign_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $campaign = $result->fetch_assoc();
    } else {
        echo "<script>alert('Kampanye tidak ditemukan.'); window.location='dashboard.php';</script>";
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}

// Proses update jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $description = mysqli_real_escape_string($connect, $_POST['description']);
    $target_amount = $_POST['target_amount'];
    $deadline = $_POST['deadline'];
    $category = mysqli_real_escape_string($connect, $_POST['category']);

    $image_path = $campaign['image_path']; // Default gambar lama

    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $new_image_path = '../uploads/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $new_image_path);
        $image_path = $new_image_path;
    }

    $sql = "UPDATE campaign SET title=?, description=?, target_amount=?, deadline=?, category=?, image_path=? WHERE campaign_id=? AND user_id=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssisssii", $title, $description, $target_amount, $deadline, $category, $image_path, $campaign_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Kampanye berhasil diperbarui!'); window.location='dashboard.php';</script>";
        exit;
    } else {
        echo "Gagal memperbarui kampanye: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kampanye</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Kampanye Donasi</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Judul Kampanye</label>
            <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($campaign['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="description" rows="4" required><?= htmlspecialchars($campaign['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="target_amount" class="form-label">Target Donasi (Rp)</label>
            <input type="number" step="0.01" class="form-control" name="target_amount" value="<?= $campaign['target_amount'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Tenggat Waktu</label>
            <input type="date" class="form-control" name="deadline" value="<?= $campaign['deadline'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select class="form-select" name="category" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Aksi Sosial" <?= $campaign['category'] == 'Aksi Sosial' ? 'selected' : '' ?>>Aksi Sosial</option>
                <option value="Donasi Pasien" <?= $campaign['category'] == 'Donasi Pasien' ? 'selected' : '' ?>>Donasi Pasien</option>
                <option value="Donasi Pohon" <?= $campaign['category'] == 'Donasi Pohon' ? 'selected' : '' ?>>Donasi Pohon</option>
                <option value="Zakat" <?= $campaign['category'] == 'Zakat' ? 'selected' : '' ?>>Zakat</option>
                <option value="Sedekah" <?= $campaign['category'] == 'Sedekah' ? 'selected' : '' ?>>Sedekah</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Ubah Gambar (opsional)</label>
            <input type="file" class="form-control" name="image">
            <?php if (!empty($campaign['image_path'])): ?>
                <img src="<?= htmlspecialchars($campaign['image_path']) ?>" alt="Gambar Lama" class="img-thumbnail mt-2" style="max-height: 150px;">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-kb">Simpan Perubahan</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
