<?php

include "config/koneksi.php";

$selectUser = mysqli_query($koneksi, "SELECT * FROM users");
$rows = mysqli_fetch_all($selectUser, MYSQLI_ASSOC);

?>


<div class="card">
    <div class="card-header text-center">
        <h2 class="card-title">Users</h2>
    </div>
</div>
<div class="card-body">
    <div class="mb-4">
        <a href="?page=user-create-edit" class="btn btn-primary">Create</a>
    </div>
    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'success') {

        $status = "Data Berhasil Ditambah!";
        $location = "?page=user";
        echo statusSuccess($status, $location);
    }
    ?>
    <!-- <div class="table-responsive">
        <div class="alert alert-success" role="alert">
  A simple success alert—check it out!
</div> -->
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $index => $row) {
            ?>
                <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td>
                        <a href="?page=user-create-edit&idEdit=<?php echo $row ['id'] ?>" class="btn btn-success">Edit</a>
                        <form action="" method="post" class="d-inline">
                            <button class="btn btn-danger">Delete</button>
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