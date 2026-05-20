<?php
include "config/koneksi.php";

if (isset($_POST['simpan'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $pass = $_POST['password'];
    $confirm = $_POST['password_confirm'];
    $passSha = sha1($pass);

    if ($pass == $confirm) {
        $cekEmail = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($cekEmail) > 0) {
            header('location:?page=user-create-edit');
        }
        mysqli_query($koneksi, " INSERT INTO users (name, email, password) VALUES ('$name','$email','$passSha')");

        header('location:?page=user&status=success');
        exit();
    } else {
        header('location:?page=user-create-edit');
        exit();
    }
}
if (isset($_GET['idEdit'])) {
    $id = $_GET['idEdit'] ?? '';
    $selectUser = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
    $rEdit = mysqli_fetch_assoc($selectUser);

    if (isset($_POST['edit'])) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $pass = $_POST['password'];
        $confirm = $_POST['password_confirm'];
        $passSha = sha1($pass);

        if ($pass ==  '') {
            $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name',email='$email' WHERE id='$id'");
            header ('location:?page=user');
            exit();
        } else {
            if ($pass == $confirm) {
                $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name',email='$email', password='$passSha' WHERE id='$id'");
                header ('location:?page=user');
            exit();
            }
        }
        
        
        {
            $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name',email='$email', password='$passSha' WHERE id='$id'");
        }

        // if ($updateUser) {
        //     header('location:?page=user');
        //     exit();
        // }
    }
}

?>


<div class="card">
    <div class="card-header text-center mt-2">
        <h2 class="card-title"> <?php echo isset($_GET['idEdit']) ? 'Edit' : 'Tambah' ?> User</h2>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row my-2">
                <div class="col-6">
                    <label for="" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo isset($_GET['idEdit']) ? $rEdit['name'] : '' ?>" required placeholder="Masukkan Nama">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo isset($_GET['idEdit']) ? $rEdit['email'] : '' ?>" required placeholder="Masukkan Email">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan Password">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Password Confirm </label>
                    <input type="password" class="form-control" name="password_confirm" placeholder="Confrim Password">
                </div>
            </div>
            <div class="text-end mt-2">
                <button type="submit" name="<?php echo isset($_GET['idEdit']) ? 'edit' : 'simpan' ?>" class="btn btn-primary"> <?php echo isset($_GET['idEdit']) ? 'Edit' : 'Simpan' ?></button>
                <a href="?page=user" class="btn btn-danger">Batal</a>
            </div>

        </form>
    </div>
</div>