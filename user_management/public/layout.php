<?php
// layout.php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'User Management' ?></title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-blue-500 text-white p-4 flex justify-between">
        <h1 class="font-bold">User Management</h1>
        <?php if(isset($_SESSION['user_id'])): ?>
            <div>
                Hello, <?= $_SESSION['user_name'] ?> | <a href="logout.php" class="hover:underline">Logout</a>
            </div>
        <?php endif; ?>
    </header>

    <!-- Main content -->
    <main class="flex-grow flex items-center justify-center p-6">
        <?php if(isset($content)) echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center p-4">
        &copy; <?= date('Y') ?> User Management System
    </footer>
</body>
</html>
