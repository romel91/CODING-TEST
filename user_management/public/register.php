<?php
require '../db.php';
require '../src/User.php';

$userobj = new User($conn);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        $message = "Registration successful! You can now <a href='login.php' class='text-blue-500 underline'>login</a>.";
    } else {
        $message = "Error: " . $stmt->error;
    }
}

ob_start();
?>
<div class="bg-white p-8 rounded shadow-md w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    <?php if($message): ?>
        <p class="text-green-500 mb-4 text-center"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
        <input type="text" name="name" placeholder="Full Name" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">Register</button>
    </form>
    <p class="mt-4 text-center text-sm">Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login</a></p>
</div>
<?php
$content = ob_get_clean();
$title = "Register";
require 'layout.php';
