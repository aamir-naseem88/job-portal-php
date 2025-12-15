<?php
require '../includes/auth.php';
checkRole('employer');
require '../config/database.php';

// Get employer company
$stmt = $pdo->prepare("SELECT company_id FROM companies WHERE user_id = :user_id");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$company = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$company) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $job_type = trim($_POST['job_type']);
    $salary = trim($_POST['salary']);

    if (empty($title) || empty($description) || empty($location)) {
        $error = "Title, description and location are required.";
    } else {

        $stmt = $pdo->prepare("
            INSERT INTO jobs (company_id, title, description, location, job_type, salary)
            VALUES (:company_id, :title, :description, :location, :job_type, :salary)
        ");

        $stmt->execute([
            ':company_id' => $company['company_id'],
            ':title' => $title,
            ':description' => $description,
            ':location' => $location,
            ':job_type' => $job_type,
            ':salary' => $salary
        ]);

        $success = "Job posted successfully.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
</head>
<body>

<h2>Post a Job</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="title" placeholder="Job Title" required><br><br>
    <textarea name="description" placeholder="Job Description" required></textarea><br><br>
    <input type="text" name="location" placeholder="Location" required><br><br>

    <select name="job_type">
        <option value="">Select Job Type</option>
        <option value="Full-time">Full-time</option>
        <option value="Part-time">Part-time</option>
        <option value="Remote">Remote</option>
    </select><br><br>

    <input type="text" name="salary" placeholder="Salary (optional)"><br><br>

    <button type="submit">Post Job</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
