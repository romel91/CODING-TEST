<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

ob_start();
?>
<div class="bg-white p-8 rounded shadow-md w-full max-w-3xl text-center">
    <h2 class="text-2xl font-bold mb-6">Welcome, <?= $_SESSION['user_name'] ?>!</h2>
    <div class="flex flex-col md:flex-row justify-center gap-4">
        <!-- All Users Button -->
        <a href="index.php" class="bg-blue-500 text-white p-4 rounded shadow hover:bg-blue-600 transition w-48">
            All Users
        </a>

        <!-- Add User Button -->
        <a href="register.php" class="bg-green-500 text-white p-4 rounded shadow hover:bg-green-600 transition w-48">
            Add User
        </a>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = "Dashboard";
require 'layout.php';
