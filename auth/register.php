<?php
require '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role)
        VALUES (:name, :email, :password, :role)
    ");

    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':role' => $role
    ]);

    echo "Registration successful";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>User Registration</h2>

<form method="POST" action="">
    <input type="text" name="name" placeholder="Full Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <select name="role" required>
        <option value="">Select Role</option>
        <option value="employer">Employer</option>
        <option value="jobseeker">Job Seeker</option>
    </select><br><br>

    <button type="submit">Register</button>
</form>

</body>
</html>
