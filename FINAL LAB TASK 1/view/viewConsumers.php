<?php
require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    deleteConsumer($_POST['delete_id']);
    header('Location: viewConsumers.php'); 
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    updateConsumer($id, $first_name, $last_name, $email, $mobile);
    header('Location: viewConsumers.php'); 
    exit;
}

$consumers = fetchAllConsumers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Consumers</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Consumers List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($consumers) > 0): ?>
                <?php foreach ($consumers as $consumer): ?>
                    <tr>
                        <form method="POST">
                            <td><?= htmlspecialchars($consumer['id']); ?></td>
                            <td>
                                <input type="text" name="first_name" value="<?= htmlspecialchars($consumer['first_name']); ?>">
                            </td>
                            <td>
                                <input type="text" name="last_name" value="<?= htmlspecialchars($consumer['last_name']); ?>">
                            </td>
                            <td>
                                <input type="email" name="email" value="<?= htmlspecialchars($consumer['email']); ?>">
                            </td>
                            <td>
                                <input type="text" name="mobile" value="<?= htmlspecialchars($consumer['mobile']); ?>">
                            </td>
                            <td>
                                <button type="submit" name="update_id" value="<?= $consumer['id']; ?>">Update</button>
                                <button type="submit" name="delete_id" value="<?= $consumer['id']; ?>">Delete</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No consumers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
