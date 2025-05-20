<?php
require '../config/connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: pengguna/login.php");
  exit;
}

$campaign_id = $_POST['campaign_id'];
$title = mysqli_real_escape_string($connect, $_POST['title']);
$content = mysqli_real_escape_string($connect, $_POST['content']);

// Upload gambar
$image_path = '';
if (!empty($_FILES['image']['name'])) {
  $upload_folder = "../uploads/";
  $image_name = time() . '_' . basename($_FILES["image"]["name"]);
  $target_file = $upload_folder . $image_name;

  // Pindahkan file ke folder uploads
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $image_path = $image_name; // Simpan hanya nama filenya
  }
}

// Simpan ke database
$query = "INSERT INTO campaign_update (campaign_id, title, content, image_path, update_date) VALUES (?, ?, ?, ?, NOW())";
$stmt = $connect->prepare($query);
$stmt->bind_param("isss", $campaign_id, $title, $content, $image_path);
$stmt->execute();

// Redirect ke halaman detail kampanye
header("Location: ../detail_campaign.php?id_kampanye=$campaign_id");
exit;
?>
