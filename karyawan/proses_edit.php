<?php
include '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $original_nik = $conn->real_escape_string($_POST['original_nik']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $jabatan = $conn->real_escape_string($_POST['jabatan']);
    $penjualan = $conn->real_escape_string($_POST['penjualan']);
    $upload_dir = __DIR__ . '/karyawanupload/';
    $gambar_name = "";

    // Check if a new image is uploaded
    if (!empty($_FILES['gambar']['name'])) {
        $gambar_name = time() . "_" . basename($_FILES['gambar']['name']);
        $target_file = $upload_dir . $gambar_name;

        // Ensure uploads directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Validate and move the uploaded file
        if (is_uploaded_file($_FILES['gambar']['tmp_name'])) {
            if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                echo "Failed to upload the image.";
                exit();
            }
        } else {
            echo "No valid file uploaded.";
            exit();
        }

        // Optional: Remove old image if it exists
        $old_image_result = $conn->query("SELECT gambar FROM karyawan WHERE nik='$original_nik'");
        if ($old_image_result && $old_image = $old_image_result->fetch_assoc()) {
            $old_image_path = $upload_dir . $old_image['gambar'];
            if (file_exists($old_image_path) && !empty($old_image['gambar'])) {
                unlink($old_image_path);
            }
        }
    }

    // Update database
    $sql = "UPDATE karyawan SET 
                nama='$nama', 
                jabatan='$jabatan', 
                penjualan='$penjualan'";

    // Add the image column update if a new image is uploaded
    if (!empty($gambar_name)) {
        $sql .= ", gambar='$gambar_name'";
    }

    $sql .= " WHERE nik='$original_nik'";

    if ($conn->query($sql) === TRUE) {
        header("Location: karyawan.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
