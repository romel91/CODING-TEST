<?php
require '../db.php';
require '../src/User.php';

$userObj = new User($conn);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    // Basic validation
    if ($name && $email && $password) {
        if ($userObj->create($name, $email, $password, $gender)) {
            $message = "User registered successfully!";
        } else {
            $message = "Error: User not created!";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>
<form method="POST">
    Name: <input type="text" name="name"><br>
    Email: <input type="email" name="email"><br>
    Password: <input type="password" name="password"><br>
    Gender: 
    <select name="gender">
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
    </select><br>
    <button type="submit">Register</button>
</form>
<p><?php echo $message; ?></p>
