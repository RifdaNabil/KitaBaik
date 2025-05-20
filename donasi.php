<?php
session_start();
require 'config/connection.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pengguna/login.php");
    exit;
}

// Cek apakah ID kampanye ada di URL
if (!isset($_GET['id_kampanye'])) {
    echo "<div class='alert alert-danger'>Kampanye tidak ditemukan.</div>";
    exit;
}

$campaign_id = $_GET['id_kampanye'];
$user_id = $_SESSION['user_id'];

// Ambil data kampanye
$sql = "SELECT * FROM campaign WHERE campaign_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $campaign_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='alert alert-danger'>Kampanye tidak ditemukan.</div>";
    exit;
}

$campaign = $result->fetch_assoc();

// Proses donasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donation_amount = $_POST['donation_amount'];
    $payment_method = $_POST['payment_method'];
    $payment_status = 'completed'; // Langsung diset completed
   
   // Ambil pesan dan status anonim
    $message = $_POST['message'] ?? '';
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    // Validasi jumlah donasi
    if ($donation_amount < 2000) {
        echo "<div class='alert alert-danger'>Jumlah donasi minimal adalah Rp 2.000.</div>";
    } else {
        // Update jumlah terkumpul
        $new_amount = $campaign['current_amount'] + $donation_amount;
        $update_sql = "UPDATE campaign SET current_amount = ? WHERE campaign_id = ?";
        $update_stmt = $connect->prepare($update_sql);
        $update_stmt->bind_param("di", $new_amount, $campaign_id);
        $update_stmt->execute();

        // Simpan riwayat donasi
        $donation_sql = "INSERT INTO donation (user_id, campaign_id, amount, payment_method, payment_status, message, is_anonymous)
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $donation_stmt = $connect->prepare($donation_sql);
        $donation_stmt->bind_param("iiisssi", $user_id, $campaign_id, $donation_amount, $payment_method, $payment_status, $message, $is_anonymous);
        $donation_stmt->execute();


        // Tampilkan pesan sukses dan lakukan pengalihan
        echo "
        <div class='alert alert-success text-center'>Donasi telah berhasil! Terimakasih sudah berkontribusi!</div>
        <script>
            setTimeout(function() {
                window.location.href = 'detail_campaign.php?id_kampanye=" . $campaign_id . "';
            }, 5000); // Pengalihan setelah 5 detik
        </script>
        ";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donasi | KitaBaik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <h2 class="text-center mb-4"><?= htmlspecialchars($campaign['title']) ?></h2>

    <p><strong>Target Donasi:</strong> Rp<?= number_format($campaign['target_amount'], 0, ',', '.') ?></p>
    <p><strong>Terkumpul:</strong> Rp<?= number_format($campaign['current_amount'], 0, ',', '.') ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($campaign['status']) ?></p>

    <!-- Formulir Donasi -->
<form method="POST">
    <div class="mb-3">
        <label for="donation_amount" class="form-label">Jumlah Donasi (Rp)</label>
        <input type="number" id="donation_amount" name="donation_amount" class="form-control" min="2000" required>
        <div class="form-text">Donasi minimal adalah Rp 2.000</div>
    </div>

    <div class="mb-3">
        <label for="payment_method" class="form-label">Metode Pembayaran</label>
        <select id="payment_method" name="payment_method" class="form-select" required>
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="E-Wallet">Gopay</option>
            <option value="E-Wallet">Dana</option>
        </select>
    </div>

    <div class="mb-3">
    <label for="message" class="form-label">Pesan untuk Penerima</label>
    <textarea id="message" name="message" class="form-control" rows="3" placeholder="Tulis pesan dukunganmu di sini..."></textarea>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="1" id="is_anonymous" name="is_anonymous">
    <label class="form-check-label" for="is_anonymous">
        Sembunyikan nama saya (donasi sebagai Anonim)
    </label>
</div>

    <button type="submit" class="btn btn-success w-100">Donasi Sekarang</button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
