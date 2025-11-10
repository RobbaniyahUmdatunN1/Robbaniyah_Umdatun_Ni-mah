<?php
include 'koneksi.php';

$id = $_GET['id'] ?? null;

$query = mysqli_query($conn, "SELECT * FROM foods WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $name = $_POST['nama'];
    $harga = $_POST['harga'];

    $old_image = $data['foto'];
    $folder = "uploads/";

    if (!empty($_FILES['foto']['nama'])) {
        $image_name = $_FILES['foto']['nama'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, $folder . $image_name);

        if ($old_image && file_exists($folder . $old_image)) {
            unlink($folder . $old_image);
        }

        $query_update = "UPDATE foods SET nama='$name', harga='$price', foto='$image_name' WHERE id='$id'";
    } else {
        $query_update = "UPDATE foods SET nama='$name', harga='$price' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Menu</title>
  <style>
    body { font-family: Arial; margin: 30px; }
    form { width: 350px; background: #f8f8f8; padding: 20px; border-radius: 10px; }
    input[type=text], input[type=number], input[type=file] {
      width: 100%;
      padding: 8px;
      margin: 6px 0;
    }
    button {
      background: #4CAF50; color: white; border: none;
      padding: 10px; border-radius: 5px; cursor: pointer;
    }
    img { border-radius: 8px; margin-top: 10px; }
  </style>
</head>
<body>

<h2>Edit Menu</h2>
<form action="" method="POST" enctype="multipart/form-data">
  <label>Nama Menu:</label>
  <input type="text" name="name" value="<?php echo $data['nama']; ?>" required>

  <label>Harga:</label>
  <input type="number" name="price" value="<?php echo $data['harga']; ?>" required>

  <label>Foto:</label>
  <input type="file" name="image">
  <?php if ($data['foto']) { ?>
    <br><img src="uploads/<?php echo $data['foto']; ?>" width="120">
  <?php } ?>

  <button type="submit" name="update">Update</button>
</form>

</body>
</html>