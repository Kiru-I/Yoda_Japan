<?php
include '../config.php';
session_start();

if (!isset($_SESSION['nama'])) {
    echo "Session 'nama' is not set. Redirecting to login.";
    header('Location: index.php');
    exit;
}
// Check if 'nik' is in the URL
if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Query to get data for editing using NIK
    $result = $conn->query("SELECT * FROM karyawan WHERE nik='$nik'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Handle case when no record is found
        echo "<div class='alert alert-danger' role='alert'>No karyawan found with this NIK.</div>";
        exit();
    }
} else {
    // Handle case when nik is not in the URL
    echo "<div class='alert alert-danger' role='alert'>No NIK provided.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-secondary">
  <div class="container-fluid">
    <a class="navbar-brand text-light ms-3" href="../dashboard.php">Cafekita</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link text-light" href="../dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="../menu/menu.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="karyawan.php">Karyawan</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown" style="margin-right: 6rem;">
          <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['nama']; ?>
          </a>
          <ul class="dropdown-menu bg-dark">
            <li><a class="dropdown-item text-light" href="../index.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
    <h2 class="mb-4">Edit Karyawan</h2>

    <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="original_nik" value="<?php echo $row['nik']; ?>">
    
    <div class="form-group mb-3">
        <label for="nama">Nama:</label>
        <input type="text" class="form-control" name="nama" value="<?php echo $row['nama']; ?>" required>
    </div>
    
    <div class="form-group mb-3">
        <label for="jabatan">Jabatan:</label>
        <select name="jabatan" class="form-control" required>
            <option value="admin" <?php if($row['jabatan']=='admin') echo 'selected'; ?>>Admin</option>
            <option value="kasir" <?php if($row['jabatan']=='kasir') echo 'selected'; ?>>Kasir</option>
            <option value="koki" <?php if($row['jabatan']=='koki') echo 'selected'; ?>>Koki</option>
        </select>
    </div>
    
    <div class="form-group mb-3">
        <label for="penjualan">Penjualan:</label>
        <input type="text" class="form-control" name="penjualan" value="<?php echo $row['penjualan']; ?>" required>
    </div>
    
    <div class="form-group mb-3">
        <label for="gambar">Gambar Karyawan:</label>
        <input type="file" class="form-control" name="gambar">
        <?php if (!empty($row['gambar'])): ?>
            <img src="/karyawanupload/<?php echo $row['gambar']; ?>" alt="Karyawan Image" style="max-width: 150px; margin-top: 10px;">
        <?php endif; ?>
    </div>
    
    <button type="submit" class="btn btn-primary mr-2">Update</button>
    <a href="karyawan.php" class="btn btn-secondary ml-2">Batal</a>
</form>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>