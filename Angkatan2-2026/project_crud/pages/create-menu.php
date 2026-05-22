<?php
include "config/koneksi.php";

if (isset($_POST['add'])) {
    $parent_id = $_POST['parent_id'] ?: 'NULL';
    $name = htmlspecialchars($_POST['name']);
    $icon = htmlspecialchars($_POST['icon']);
    $url = htmlspecialchars($_POST['url']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $sort_order = $_POST['sort_order'];

    mysqli_query($koneksi, "INSERT INTO menus (parent_id, name, icon, url, is_active, sort_order) VALUES ($parent_id, '$name', '$icon', '$url', '$is_active', '$sort_order')");
    header('location:?page=menu&status=success');
    exit();
}

// membuat parameter status untuk alert status
$is_active = $_GET['is_active'] ?? '';

$id = $_GET['edit'] ?? '';
$selectMenu = mysqli_query($koneksi, "SELECT * FROM menus WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($selectMenu);

if (isset($_POST['edit'])) {
    $parent_id = $_POST['parent_id'] ?: 'NULL';
    $name = htmlspecialchars($_POST['name']);
    $icon = htmlspecialchars($_POST['icon']);
    $url = htmlspecialchars($_POST['url']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $sort_order = $_POST['sort_order'];

    mysqli_query($koneksi, "UPDATE menus SET parent_id=$parent_id, name='$name', icon='$icon', url='$url', is_active='$is_active', sort_order='$sort_order' WHERE id='$id'");

    header('location:?page=menu');
    exit();
}
// is : adalah
$queryParent = mysqli_query($koneksi, "SELECT * FROM menus WHERE parent_id IS NULL OR parent_id = 0");
$rowParent = mysqli_fetch_all($queryParent, MYSQLI_ASSOC);

?>

<div class="card">
    <h2 class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Create New' ?> Menu</h2>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="" class="form-table">Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="Add Your Name" required
                        value="<?php echo isset($_GET['edit']) ? $rEdit['name'] : '' ?>">
                </div>

                <div class="col-6 mb-3">
                    <label for="" class="form-label">Parent Id *</label>
                    <select name="parent_id" class="form-control">
                        <option value="">Select One</option>
                        <?php foreach ($rowParent as $parent): ?>
                            <option value="<?= $parent['id'] ?>"
                                <?= (isset($rEdit['parent_id']) && $rEdit['parent_id'] == $parent['id']) ? 'selected' : '' ?>>
                                <?= $parent['name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label for="" class="form-lable">Icon *</label>
                    <input type="text" name="icon" class="form-control" placeholder="Enter Icon" required
                        value="<?php echo isset($_GET['edit']) ? $rEdit['icon'] : '' ?>">
                </div>

                <div class="col-6 mb-3">
                    <label for="" class="form-lable">Url *</label>
                    <input type="text" name="url" class="form-control" placeholder="Enter Url"
                        value="<?php echo isset($_GET['edit']) ? $rEdit['url'] : '' ?>">
                </div>

                <div class="col-mb-13 mb-3">
                    <label for="" class="form-table">Status *</label>
                    <select name="is_active" id="">
                        <option value="">Select your status</option>
                        <option value="1" <?php echo (isset($rEdit['is_active']) && (int)$rEdit['is_active'] === 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?php echo (isset($rEdit['is_active']) && (int)$rEdit['is_active'] === 0) ? 'selected' : '' ?>>Non-active</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label for="" class="form-lable">Sort Order *</label>
                    <input type="number" name="sort_order" id="" class="form-control" placeholder="Enter Sort Order"
                        value="<?php echo isset($_GET['edit']) ? $rEdit['sort_order'] : '' ?>"></input>
                </div>

                <?php if ($id): ?>
                    <!-- <div class="mt-2 ms-3 text-secondary">
                        <p>*Leave blank if you dont want to change the password</p>
                    </div> -->
                <?php endif ?>

                <div class="text-end mt-4">
                    <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>"
                        class="btn btn-primary me-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Menu</button>
                    <a href="?page=menu" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>