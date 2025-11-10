<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($conn, "SELECT foto FROM foods WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);
    $foto = $data['foto'];
    $folder = "uploads/";

    if ($foto && file_exists($folder . $foto)) {
        unlink($folder . $foto);
    }

    $delete = mysqli_query($conn, "DELETE FROM foods WHERE id='$id'");

    if ($delete) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='index.php';</script>";
}
?>
