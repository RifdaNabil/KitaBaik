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
if (isset($_GET['id_kampanye'])) {
    $campaign_id = $_GET['id_kampanye'];

    // Query untuk memastikan kampanye yang ingin dihapus milik user
    $sql = "SELECT * FROM campaign WHERE campaign_id = ? AND user_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $campaign_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika kampanye ditemukan dan milik user
    if ($result->num_rows > 0) {
        // Query untuk menghapus kampanye
        $delete_sql = "DELETE FROM campaign WHERE campaign_id = ?";
        $delete_stmt = $connect->prepare($delete_sql);
        $delete_stmt->bind_param("i", $campaign_id);

        if ($delete_stmt->execute()) {
            // Redirect ke dashboard setelah berhasil menghapus
            header('Location: dashboard.php');
            exit();
        } else {
            echo "<div class='alert alert-danger'>Terjadi kesalahan saat menghapus kampanye.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Kampanye tidak ditemukan atau tidak milik Anda.</div>";
    }
}
?>
