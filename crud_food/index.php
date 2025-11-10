<?php
include 'koneksi.php';

$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : "";
$where = "";
if (!empty($search)) {
    $where = "WHERE nama LIKE '%$search%'";
}

$countQuery = "SELECT COUNT(*) AS total FROM foods $where";
$countResult = mysqli_query($conn, $countQuery);
$totalData = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalData / $limit);

$query = "SELECT * FROM foods $where LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food List</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f5f5f5; }
        h2 { text-align: center; }
        table { border-collapse: collapse; width: 90%; margin: auto; background: #fff; box-shadow: 0 0 6px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f0b27a; color: white; }
        img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
        .search-box { text-align: center; margin-bottom: 20px; }
        .pagination { text-align: center; margin-top: 20px; }
        .pagination a {
            margin: 0 5px; padding: 5px 10px; text-decoration: none;
            border: 1px solid #ccc; color: #333; background: #fff;
        }
        .pagination a.active {
            background: #f0b27a; color: white; border: 1px solid #f0b27a;
        }
        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }
        .btn-add { background: #28a745; margin-left: 5%; display: inline-block; margin-bottom: 10px;}
        .aksi {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn-edit, .btn-hapus {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
        .btn-edit {
            background-color: #007bff;
        }
        .btn-hapus {
            background-color: #e74c3c;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }
        .btn-hapus:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<h2>List Menu Makanan</h2>

<div class="search-box">
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by name..." value="<?= $search ?>">
        <button type="submit">Search</button>
    </form>
</div>

<a href="add.php" class="btn btn-add">+ Tambah Menu</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Deskripsi</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Foto</th>
        <th>Aksi</th>
    </tr>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['kategori'] ?></td>
            <td><?= $row['deskripsi'] ?></td>
            <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <?php if (!empty($row['foto'])): ?>
                    <img src="uploads/<?= $row['foto'] ?>" alt="<?= $row['nama'] ?>">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>
            <td>
                <div class="aksi">
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin mau hapus data ini?')">Hapus</a>
                </div>
            </td>

        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="8">No data found.</td></tr>
    <?php endif; ?>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&search=<?= $search ?>">Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a class="<?= ($i == $page) ? 'active' : '' ?>" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= $search ?>">Next</a>
    <?php endif; ?>
</div>

</body>
</html>