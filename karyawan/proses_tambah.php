<?php
include '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $nik = $conn->real_escape_string($_POST['nik']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $jabatan = $conn->real_escape_string($_POST['jabatan']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT); // Password hashing
    
    $upload_dir = __DIR__ . '/karyawanupload/';
    $gambar_name = "";

    // Check if an image is uploaded
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
    }

    // Insert into database
    $sql = "INSERT INTO karyawan (nik, nama, jabatan, password, gambar) 
            VALUES ('$nik', '$nama', '$jabatan', '$password', '$gambar_name')";

    if ($conn->query($sql) === TRUE) {
        header("Location: karyawan.php");
        exit();
    } else {
        echo "Error inserting record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
