<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="username" required><br><br>

        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Contact Number:</label>
        <input type="text" name="number" maxlength="11" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <label>Role:</label>
        <select name="role" required>
            <option value="Hotel Employee">Hotel Employee</option>
            <option value="Hotel Manager">Hotel Manager</option>
        </select><br><br>

        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'database_config.php';

    // Sanitize and validate input
    $username = trim($_POST['username']);
    $name = trim($_POST['name']);
    $number = trim($_POST['number']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Invalid email format.</p>";
        exit;
    }

    if (empty($name)) {
        echo "<p>Please provide a name.</p>";
        exit;
    }

    if (!preg_match('/^\d{11}$/', $number)) {
        echo "<p>Contact number must be exactly 11 digits.</p>";
        exit;
    }

    if (strlen($password) < 6) {
        echo "<p>Password must be at least 6 characters long.</p>";
        exit;
    }

    if (!in_array($role, ['Hotel Manager', 'Hotel Employee'])) {
        echo "<p>Invalid role selected.</p>";
        exit;
    }

    // Generate employee_code (e.g., EMP-0001)
    try {
        $stmt = $pdo->query("SELECT employee_code FROM users ORDER BY id DESC LIMIT 1");
        $lastCode = $stmt->fetchColumn();

        if ($lastCode) {
            $num = (int) substr($lastCode, 4);
            $newCode = 'EMP-' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newCode = 'EMP-001';
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user
        $stmt = $pdo->prepare("
            INSERT INTO users (employee_code, username, name, number, password, role) 
            VALUES (:employee_code, :username, :name, :number, :password, :role)
        ");
        $stmt->execute([
            ':employee_code' => $newCode,
            ':username'      => $username,
            ':name'          => $name,
            ':number'        => $number,
            ':password'      => $hashedPassword,
            ':role'          => $role
        ]);

        echo "<p>Registration successful! Your employee code is <strong>$newCode</strong>.</p>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<p>Email already registered.</p>";
        } else {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>
