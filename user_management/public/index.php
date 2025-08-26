<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../db.php';

$result = $conn->query("SELECT * FROM users");

?>
<div class="bg-white p-8 rounded shadow-md w-full max-w-4xl">
    <h2 class="text-2xl font-bold mb-6 text-center">All Users</h2>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Name</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = $result->fetch_assoc()): ?>
                <tr class="text-center">
                    <td class="border p-2"><?= $user['id'] ?></td>
                    <td class="border p-2"><?= $user['name'] ?></td>
                    <td class="border p-2"><?= $user['email'] ?></td>
                    <td class="border p-2 space-x-2">
                        <a href="edit.php?id=<?= $user['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                        <a href="delete.php?id=<?= $user['id'] ?>" class="text-red-500 hover:underline">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php
$title = "All Users";
require 'layout.php';
