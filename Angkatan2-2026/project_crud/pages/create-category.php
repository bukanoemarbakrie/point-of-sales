<?php
include "config/koneksi.php";
if (isset($_POST['simpan'])) {
    $category_name = htmlspecialchars($_POST['category_name']);
    //CEK CATEGORIES :
    $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name='$category_name'");
    if (mysqli_num_rows($cek) > 0) {
        header("location:?page=create-category&status=category-exist");
        exit();
    }
    // END CEK CATEGORIES
    $query = mysqli_query($koneksi, "INSERT INTO categories (category_name) VALUES ('$category_name')");
    if ($query) {
        header("location:?page=category&status=success");
        exit();
    }
}
if (isset($_GET['edit'])) {
    $id = base64_decode($_GET['edit']) ?? '';
    $select = mysqli_query($koneksi, "SELECT * FROM categories WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($select);
    if (isset($_POST['edit'])) {
        $category_name = htmlspecialchars($_POST['category_name']);
        // CEK CATEGORIES :
        $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name='$category_name'");
        if (mysqli_num_rows($cek) > 0) {
            header("location:?page=create-category&edit=" . $_GET['edit'] . "&status=category-exist");
            exit();
        }
        // END CEK CATEGORIES
        $update = mysqli_query($koneksi, "UPDATE categories SET category_name='$category_name' WHERE id='$id'");
        if ($update) {
            header("location:?page=category&status=success");
            exit();
        }
    }
}


?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Create Category</h5>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <label for="" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="category_name" value="<?= isset($id) ? $rowEdit['category_name'] : '' ?>" required>
            <?php
            $status = '';
            if (isset($_GET['status']) && $_GET['status'] == 'category-exist') {
                $status = "Category Name Already Exist!";
            }
            echo inputFailed($status);
            ?>
            <br>
            <button type="submit" name="<?= isset($id) ? 'edit' : 'simpan' ?>" class="btn btn-primary mt-2"><?= isset($id) ? 'Update' : 'Create' ?></button>
            <a href="?page=category" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </div>
</div>