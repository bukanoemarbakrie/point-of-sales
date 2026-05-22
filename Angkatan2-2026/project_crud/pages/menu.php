<?php

include "config/koneksi.php";

$query = mysqli_query($koneksi, "SELECT parent.name AS parent_name, menus.* FROM menus LEFT JOIN menus AS parent ON parent.id = menus.parent_id ORDER BY menus.id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM menus WHERE id='$id'");
    header('location:?page=menu');
    exit();
}
?>

<div class="card">
    <h5 class="card-header">
        Management Menu
    </h5>
    <div class="card-body">
        <div class="mb-2" align="right">
            <a href="?page=create-menu" class="btn btn-primary">Create New Menu</a>
        </div>
        <?php
        if (isset($_GET['status']) && $_GET['status'] == 'success') {

            $status = "Menu Create Successfully!";
            $location = "?page=menu";
            echo statusSuccess($status, $location);
        }
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Parent</th>
                    <th>Name</th>
                    <th>Url</th>
                    <th>Icon</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $index => $row) {
                ?>
                    <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><?php echo $row['parent_name'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['url'] ?></td>
                        <td><?php echo $row['icon'] ?></td>
                        <td><?php echo $row['sort_order'] ?></td>
                        <td><?php echo getStatus($row['is_active']) ?></td>
                        <td class="ms-2">
                            <a href="?page=create-menu&edit=<?php echo $row['id'] ?>" class="btn btn-success">Edit</a>
                            <form action="?page=menu&delete=<?php echo $row['id'] ?>" method="post" class="d-inline">
                                <button class="btn btn-danger" onclick="return confirm ('Are you sure want delete this data?')">Delete</button>
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