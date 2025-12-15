<?php
require '../config/database.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } 
    // Check if email already exists
    else {
        $check = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
        $check->execute([':email' => $email]);

        if ($check->rowCount() > 0) {
            $error = "Email already registered.";
        } else {
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

            $success = "Registration successful. You can login now.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

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
