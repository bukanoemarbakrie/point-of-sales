<?php
include "config/koneksi.php";

if (isset($_POST['add'])) {
    $name = htmlspecialchars($_POST['name']);
    $is_active = htmlspecialchars($_POST['status']);
    $description = $_POST['description'];

    mysqli_query($koneksi, "INSERT INTO roles (name,is_active,description) VALUES ('$name','$is_active','$description')");
    header('location:?page=role&status=success');
    exit();
}

// membuat parameter status untuk alert status
$is_active = $_GET['is_active'] ?? '';

$id = $_GET['edit'] ?? '';
$selectRole = mysqli_query($koneksi, "SELECT * FROM roles WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($selectRole);

if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $is_active = htmlspecialchars($_POST['status']);
    $description = $_POST['description'];

    mysqli_query($koneksi, "UPDATE roles SET name='$name', is_active='$is_active', description='$description' WHERE id='$id'");
    header('location:?page=role');
    exit();
}
?>

<div class="card">
    <h2 class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Create New' ?> Role</h2>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="" class="form-table">Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="Add Your Name" required
                        value="<?php echo isset($_GET['edit']) ? $rEdit['name'] : '' ?>">
                </div>

                <div class="col-mb-13 mb-3">
                    <label for="" class="form-table">Status *</label>
                    <select name="status" id="">
                        <option value="">Select your status</option>
                        <option value="1" <?php echo (isset($rEdit['is_active']) && (int)$rEdit['is_active'] === 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?php echo (isset($rEdit['is_active']) && (int)$rEdit['is_active'] === 0) ? 'selected' : '' ?>>Non-active</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label for="" class="form-table">Description </label>
                    <textarea name="description" id="" class="form-control" placeholder="Add Your Description"
            value="<?php echo isset($_GET['edit']) ? $rEdit['description'] : '' ?>"></textarea>
                </div>

                <?php if ($id): ?>
                    <div class="mt-2 ms-3 text-secondary">
                        <p>*Leave blank if you dont want to change the password</p>
                    </div>
                <?php endif ?>

                <div class="text-end mt-4">
                    <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>"
                        class="btn btn-primary me-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Role</button>
                    <a href="?page=role" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>