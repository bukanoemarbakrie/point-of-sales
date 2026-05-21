<?php
include "config/koneksi.php";

if (isset($_POST['simpan'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];
    $passSha = sha1($password);

    if ($password !== $confirm_password) {
        header('location:?page=user-create-edit&status=password_not_match');
        exit();
    }
    $cekEmail = mysqli_query($koneksi, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($cekEmail) > 0) {
        header('location:?page=user-create-edit&email_exists');
        exit();
    }

    mysqli_query($koneksi, " INSERT INTO users (name, email, password) VALUES ('$name','$email','$passSha')");
    header('location:?page=user&status=success');
}



$id = $_GET['idEdit']?? '';
$selectUser = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
$rEdit = mysqli_fetch_assoc($selectUser);
if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];
    $passSha = sha1($password);

    if (empty($password)) {
        $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name',email='$email' WHERE id='$id'");
        header('location:?page=user');
        exit();
    }

    if ($password !== $confirm_password) {
        header('location:?page=user-create-edit&idEdit=' . $id . '&status=password_not_match');
        exit();
    }
    $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name',email='$email', password='$passSha' WHERE id='$id'");
    $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name',email='$email', password='$passSha' WHERE id='$id'");
}


// if ($updateUser) {
//     header('location:?page=user');
//     exit();
// }


$status = $_GET['status'] ?? '';
?>


<div class="card">
    <div class="card-header text-center mt-2">
        <h2 class="card-title"> <?php echo isset($_GET['idEdit']) ? 'Edit' : 'Create New' ?> User</h2>
    </div>
    <div class="card-body">
        <?php
        if ($status == 'password_not_match'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Password do not match.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
        <?php
        if ($status == 'email_exists') {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> This email is already registered.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><div
        </div>';
        }
        ?>

        <form action="" method="post">
            <div class="row my-2 mb">
                <div class="col-6">
                    <label for="" class="form-label">Name *</label>
                    <input type="text" class="form-control" name="name" value="<?php echo isset($_GET['idEdit']) ? $rEdit['name'] : '' ?>" required placeholder="Enter Your Name">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Email *</label>
                    <input type="email" class="form-control" name="email" value="<?php echo isset($_GET['idEdit']) ? $rEdit['email'] : '' ?>" required placeholder="ex:admin@gmail.com">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Password *</label>
                    <input type="password" class="form-control" name="password"  placeholder="Enter Password" <?php $id ? 'required' : '' ?>>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Password Confirm *</label>
                    <input type="password" class="form-control" name="password_confirm"  placeholder="Enter Password Confirm" <?php $id ? 'required' : '' ?>>
                </div>
                <?php if ($id): ?>
                <div class="mt-2 text-secondary">
                    <p>*Leave blank if you don't want to change the password</p>
                </div>
                <?php endif ?>
            </div>
            <div class="text-end mt-2">
                <button type="submit" name="<?php echo isset($_GET['idEdit']) ? 'edit' : 'simpan' ?>" class="btn btn-primary"> <?php echo isset($_GET['idEdit']) ? 'Edit' : 'Save Change' ?></button>
                <a href="?page=user" class="btn btn-danger">Batal</a>
            </div>

        </form>
    </div>
</div>
</div>