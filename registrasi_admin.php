<?php
// Sertakan koneksi database
include '../config/connection.php'; // Pastikan file koneksi.php ada dan benar lokasi file-nya

// Proses pendaftaran admin baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Enkripsi password

    // Query untuk menyimpan data admin baru
    $query = "INSERT INTO admins (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
    
    // Mengeksekusi query
    if (mysqli_query($connect, $query)) {
        // Menampilkan pesan berhasil
        echo "<div class='alert alert-success'>Admin berhasil dibuat. <a href='login.php' class='alert-link'>Silakan login di sini</a>.</div>";
    } else {
        // Menampilkan pesan gagal
        echo "<div class='alert alert-danger'>Gagal membuat akun admin: " . mysqli_error($connect) . "</div>";
    }
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Admin Baru - KitaBaik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #FFFDF4;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .card {
      border: none;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
      background-color: #ffffff;
    }

    h3 {
      font-weight: 700;
      color: #333;
      text-align: center;
    }

    .form-label {
      font-weight: 600;
      color: #555;
    }

    .btn-kb {
      background-color: #6FBF73;
      color: white;
      font-weight: 600;
      border: none;
    }

    .btn-kb:hover {
      background-color: #5ca961;
    }

    small.text-danger {
      font-size: 0.9rem;
    }

    .text-muted {
      font-size: 0.9rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-8 col-md-5 col-lg-4">
        <div class="card">
          <h3>Buat Akun Admin Baru</h3>
          
          <!-- Pesan sukses atau error -->
          <?php if (isset($message)): ?>
            <div class="alert alert-success"><?= $message ?></div>
          <?php endif; ?>

          <form action="" method="POST" class="mt-4">
            <div class="mb-3">
              <label for="fullname" class="form-label">Nama Lengkap</label>
              <input type="text" name="fullname" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email Admin</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Kata Sandi</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-kb">Buat Akun Admin</button>
            </div>
          </form>

          <p class="text-center text-muted mt-4 mb-0" style="font-size: 0.9rem;">
            Hanya untuk administrator resmi KitaBaik
          </p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
