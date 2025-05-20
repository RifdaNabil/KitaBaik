<?php
session_start();
$error = $_SESSION['error'] ?? [];
$old = $_SESSION['old'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar Akun - KitaBaik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #FFFDF4;
    }
    .btn-kb {
      background-color: #6FBF73;
      color: white;
    }
    .btn-kb:hover {
      background-color: #5ca961;
    }
    .card {
      border: none;
      border-radius: 1rem;
    }
    h3 {
      font-weight: 700;
    }
    .form-label {
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-lg p-4">
        <div class="card-body">
          <h3 class="text-center mb-4">Buat Akun Baru</h3>
          <form action="register_proses.php" method="POST">

            <div class="mb-3">
              <label for="fullname" class="form-label">Nama Lengkap</label>
              <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
              <?php if(isset($error['fullname'])): ?>
                <small class="text-danger"><?= $error['fullname'] ?></small>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
              <?php if(isset($error['email'])): ?>
                <small class="text-danger"><?= $error['email'] ?></small>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="birthdate" class="form-label">Tanggal Lahir</label>
              <input type="date" name="birthdate" class="form-control" value="<?= htmlspecialchars($old['birthdate'] ?? '') ?>">
              <?php if(isset($error['birthdate'])): ?>
                <small class="text-danger"><?= $error['birthdate'] ?></small>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Kata Sandi</label>
              <input type="password" name="password" class="form-control">
              <?php if(isset($error['password'])): ?>
                <small class="text-danger"><?= $error['password'] ?></small>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="password_confirm" class="form-label">Konfirmasi Kata Sandi</label>
              <input type="password" name="password_confirm" class="form-control">
              <?php if(isset($error['password_confirm'])): ?>
                <small class="text-danger"><?= $error['password_confirm'] ?></small>
              <?php endif; ?>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-kb">Daftar</button>
            </div>
          </form>

          <div class="text-center mt-3">
            Sudah punya akun? <a href="login.php" class="text-decoration-none fw-semibold" style="color: #6FBF73;">Masuk</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
