<?php
include "config/koneksi.php";
$selectCategories = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY id DESC");
$rowCategories = mysqli_fetch_all($selectCategories, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'] ?? 0;

    $delete = mysqli_query($koneksi, "DELETE FROM categories WHERE id='$id'");
    if ($delete) {
        header("location:?page=category");
        exit();
    }
}
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-header">
            Manage Category
        </h5>
    </div>
    <div class="card-body">
        <div class="mb-2 d-flex justify-content-end">
            <a href="?page=create-category" class="btn btn-primary">Create Category</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Data Berhasil ditambah!";
                $location = "?page=category";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rowCategories as $index => $v) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $v['category_name'] ?></td>
                            <td>
                                <a href="?page=create-category&edit=<?= base64_encode($v['id']) ?>" class="btn btn-success">Edit</a>
                                <form action="?page=category&delete=<?= $v['id'] ?>" method="post" class="d-inline">
                                    <button class="btn btn-danger" onclick="return confirm('Yakin ingin hapus ?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>