<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if (!empty($foto)) {
        $uploadDir = "uploads/";
        $targetFile = $uploadDir . basename($foto);

        // pindahkan file ke folder uploads/
        if (move_uploaded_file($tmp, $targetFile)) {
            $query = "INSERT INTO foods (nama, kategori, deskripsi, harga, stok, foto)
                      VALUES ('$nama', '$kategori', '$deskripsi', '$harga', '$stok', '$foto')";
            mysqli_query($conn, $query);
            header("Location: index.php");
        } else {
            echo "Upload gagal, periksa folder uploads/";
        }
    } else {
        echo "Harap pilih foto!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        form { width: 400px; margin: auto; display: flex; flex-direction: column; gap: 10px; }
        label { font-weight: bold; }
        input, textarea { padding: 5px; }
        button { padding: 8px; background: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
<h2>Tambah Menu Makanan 🍛</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Nama:</label>
    <input type="text" name="nama" required>

    <label>Kategori:</label>
    <input type="text" name="kategori" required>

    <label>Deskripsi:</label>
    <textarea name="deskripsi" required></textarea>

    <label>Harga:</label>
    <input type="number" name="harga" required>

    <label>Stok:</label>
    <input type="number" name="stok" required>

    <label>Foto:</label>
    <input type="file" name="foto" accept="image/*" required>

    <button type="submit">Simpan</button>
</form>

</body>
</html>
