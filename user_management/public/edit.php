<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../db.php';
$message = '';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);

    if ($stmt->execute()) {
        $message = "User updated successfully!";
        $user['name'] = $name;
        $user['email'] = $email;
    } else {
        $message = "Error: " . $stmt->error;
    }
}

ob_start();
?>
<div class="bg-white p-8 rounded shadow-md w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Edit User</h2>
    <?php if($message): ?>
        <p class="text-green-500 mb-4 text-center"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
        <input type="text" name="name" value="<?= $user['name'] ?>" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="email" name="email" value="<?= $user['email'] ?>" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">Update</button>
    </form>
</div>
<?php
$content = ob_get_clean();
$title = "Edit User";
require 'layout.php';
