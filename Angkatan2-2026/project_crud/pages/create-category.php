<?php
include "config/koneksi.php";
$query = mysqli_query($koneksi, "SELECT categories.category_name as category_name, categories.* FROM categories LEFT JOIN categories as category ON category.id = categories.id ORDER BY categories.id DESC");

$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_POST['create'])) {
    $category_name =  htmlspecialchars($_POST['category_name']);
    $status = htmlspecialchars($_POST['is_active']);

    $cek = mysqli_query($koneksi, "SELECT * FROM categories WHERE category_name='$category_name'");
    if (mysqli_num_rows($cek) > 0) {
        header('location:?page=create-category&status=category-exists');
        exit();
    }
    $update = mysqli_query($koneksi, "INSERT INTO categories (category_name, is_active) VALUES ('$category_name','$status')");

    if ($update) {
        header('location:?page=category&status=success');
        exit();
    }
}

$id = $_GET['edit'] ?? '';
// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';
$selectCategories = mysqli_query($koneksi, "SELECT * FROM categories WHERE id='$id'");
$edit = mysqli_fetch_assoc($selectCategories);

if (isset($_POST['edit'])) {
    $category_name = $_POST['category_name'];
    $is_active = $_POST['is_active'];

    $queryCek = mysqli_query($koneksi, "SELECT * FROM categories 
    WHERE category_name='$category_name' AND id != '$id'");

    if (mysqli_num_rows($queryCek) > 0) {
        header("location:?page=create-category&edit=$   id&status=category-exist");
        exit();
    }

    $query = mysqli_query($koneksi,  "UPDATE categories SET 
    category_name='$category_name',
    is_active='$is_active'
    WHERE id='$id'");

    if ($query) {
        header('location:?page=category&status=edited');
    }
}
// if (isset($_POST['save'])) {
//     $category_name =  htmlspecialchars($_POST['category_name']);
//     $status = htmlspecialchars($_POST['is_active']);

//     $cek = mysqli_query($koneksi, "SELECT * FROM categories WHERE category_name='$category_name'");
//     if (mysqli_num_rows($cek) > 0) {
//         header('location:?page=create-category&status=category-exists');
//         exit();
//     }
//     $update = mysqli_query($koneksi, "UPDATE categories SET category_name='$category_name', is_active='$status' WHERE id='$id'");

//     if ($update) {
//         header('location:?page=category&status=success');
//         exit();
//     }
// }

?>

<div class="card">
    <h5 class="card-header">
        <?= isset($_GET['edit']) ? 'Edit' : 'Create New' ?> Category
    </h5>
    <div class="card-body">
        <form action="" method="post">

            <div class="row">
                <div class="col-6">
                    <label for="" class="form-label">Name *</label>
                    <input type="text" name="category_name" class="form-control" value="<?= isset($_GET['edit']) ? $edit['category_name'] : '' ?>" placeholder="Name" required>
                    <?php
                    if (isset($_GET['status']) && $_GET['status'] == 'category-exists') {
                        $status = "Category name is already exists";
                        echo inputFailed($status);
                    }
                    ?>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Status *</label>
                    <?php $activeStatus = $edit['is_active'] ?? 0 ?>
                    <select class="form-select mb-3" aria-label="Default select" name="is_active">
                        <option>Status Select</option>
                        <option value="1" <?= ($activeStatus == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= ($activeStatus  == 0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class=" row mt-3">

            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'create' ?>"><?= isset($_GET['edit']) ? 'Save' : 'Create' ?></button>
                <a href="?page=category" class="btn btn-secondary">Back</a>
            </div>

        </form>
    </div>
</div>