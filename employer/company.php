<?php
include '../includes/header.php';
require '../includes/auth.php';
checkRole('employer');
require '../config/database.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $company_name = trim($_POST['company_name']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);

    if (empty($company_name) || empty($location)) {
        $error = "Company name and location are required.";
    } else {

        // Check if company already exists
        $check = $pdo->prepare("SELECT company_id FROM companies WHERE user_id = :user_id");
        $check->execute([':user_id' => $_SESSION['user_id']]);

        if ($check->rowCount() > 0) {
            $error = "Company profile already exists.";
        } else {

            $stmt = $pdo->prepare("
                INSERT INTO companies (user_id, company_name, description, location)
                VALUES (:user_id, :company_name, :description, :location)
            ");

            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':company_name' => $company_name,
                ':description' => $description,
                ':location' => $location
            ]);

            $success = "Company profile created successfully.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Company</title>
</head>
<body>

<h2>Create Company Profile</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="company_name" placeholder="Company Name" required><br><br>
    <textarea name="description" placeholder="Company Description"></textarea><br><br>
    <input type="text" name="location" placeholder="Location" required><br><br>
    <button type="submit">Save Company</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>
<?php include '../includes/footer.php'; ?>
</body>
</html>
