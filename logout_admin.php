<?php
session_start();
session_destroy();  // Hapus sesi
header("Location: login_admin.php");  // Arahkan ke halaman login setelah logout
exit;
?>
