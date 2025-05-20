<?php
session_start();
require '../config/connection.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

// Ambil data user saat ini
$sql = "SELECT fullname, email FROM users WHERE user_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $email);
$stmt->fetch();
$stmt->close();

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_fullname = trim($_POST['fullname']);
    $new_email = trim($_POST['email']);
    $new_password = trim($_POST['password']);

    // Validasi dasar
    if (empty($new_fullname) || empty($new_email)) {
        $message = "Nama lengkap dan email tidak boleh kosong.";
    } else {
        // Update query
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $connect->prepare("UPDATE users SET fullname = ?, email = ?, password = ? WHERE user_id = ?");
            $update->bind_param("sssi", $new_fullname, $new_email, $hashed_password, $user_id);
        } else {
            $update = $connect->prepare("UPDATE users SET fullname = ?, email = ? WHERE user_id = ?");
            $update->bind_param("ssi", $new_fullname, $new_email, $user_id);
        }

        if ($update->execute()) {
            $_SESSION['fullname'] = $new_fullname; // Update session
            $message = "Profil berhasil diperbarui!";
        } else {
            $message = "Gagal memperbarui profil: " . $connect->error;
        }

        $update->close();
    }
    echo"<meta http-equiv='refresh' content='1;url=dashboard.php'>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - KitaBaik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body style="background-color: #FFFDF4; font-family: 'Montserrat', sans-serif;">

<div class="container py-5">
    <h2 class="mb-4 text-center">Edit Profil</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label for="fullname" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($fullname) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi Baru <small>(Kosongkan jika tidak diubah)</small></label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-kb">Simpan Perubahan</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
