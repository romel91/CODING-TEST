<?php
class User {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Create a new user
    public function create($name, $email, $password, $gender) {
        $passwordHash =password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, gender) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $passwordHash, $gender);
        return $stmt->execute();
    }

    //read all users
    public function getAll() {
        $result = $this->conn->query("SELECT id, name, email, gender FROM users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //get user by id
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, name, email, gender FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    // Update user
    public function update($id, $name, $email, $gender, $status) {
        $stmt = $this->conn->prepare("UPDATE users SET name=?, email=?, gender=?, status=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $email, $gender, $status, $id);
        return $stmt->execute();
    }

    // Delete user
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}