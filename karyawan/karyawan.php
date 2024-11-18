<?php
include '../config.php';
session_start(); // Start the session

if (!isset($_SESSION['nama'])) {
    echo "Session 'nama' is not set. Redirecting to login.";
    header('Location: index.php');
    exit;
}

$query = "SELECT * FROM karyawan";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    // If the query fails, output an error message
    die("Error executing query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan</title>
    <!-- Link Bootstrap CSS -->
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
          <a class="nav-link text-light" href="">Karyawan</a>
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
    <h2 class="mb-4">Daftar Karyawan</h2>

    <!-- Tombol Tambah Karyawan -->
    <a href="tambah_karyawan.php" class="btn btn-primary mb-3">Tambah Karyawan</a>

    <!-- Tabel Data Karyawan -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Gambar</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Penjualan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
          <tr>
            <td><img src="karyawanupload/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Menu Image" width="100"></td>
            <td><?php echo htmlspecialchars($row['nik']); ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
            <td><?php echo htmlspecialchars($row['penjualan']); ?></td>
            <td>
                <a href="edit_karyawan.php?nik=<?php echo $row['nik']; ?>" class="btn btn-warning">Edit</a>
                <a href="hapus_karyawan.php?nik=<?php echo $row['nik']; ?>" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Link Bootstrap JS and dependencies (Optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Bootstrap 5 JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html> 