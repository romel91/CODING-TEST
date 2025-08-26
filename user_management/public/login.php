<?php
require '../db.php';
require '../src/User.php';

$userobj = new User($conn);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("location: dashboard.php");
        exit;
    } else {
        $message = "Invalid email or password!";
    }
}


?>
<div class="bg-white p-8 rounded shadow-md w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <?php if($message): ?>
        <p class="text-red-500 mb-4 text-center"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
        <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">Login</button>
    </form>
    <p class="mt-4 text-center text-sm">Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register</a></p>
</div>
<?php
$content = ob_get_clean();
$title = "Login";
require 'layout.php';
