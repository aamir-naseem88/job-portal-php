<?php
require '../includes/auth.php';
checkRole('jobseeker');
require '../config/database.php';

$error = '';
$success = '';

if (!isset($_GET['job_id'])) {
    header("Location: jobs.php");
    exit;
}

$job_id = intval($_GET['job_id']);

// Check if already applied
$check = $pdo->prepare("SELECT * FROM applications WHERE job_id = :job_id AND user_id = :user_id");
$check->execute([':job_id' => $job_id, ':user_id' => $_SESSION['user_id']]);

if ($check->rowCount() > 0) {
    $error = "You have already applied for this job.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && !$error) {

    $cv_file = ''; // Optional: add file upload later

    $stmt = $pdo->prepare("
        INSERT INTO applications (job_id, user_id, cv_file)
        VALUES (:job_id, :user_id, :cv_file)
    ");

    $stmt->execute([
        ':job_id' => $job_id,
        ':user_id' => $_SESSION['user_id'],
        ':cv_file' => $cv_file
    ]);

    $success = "You have successfully applied for this job.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply for Job</title>
</head>
<body>

<h2>Apply for Job</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
    <a href="jobs.php">Back to Jobs</a>
<?php else: ?>

    <?php if ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
        <a href="jobs.php">Back to Jobs</a>
    <?php else: ?>
        <form method="POST">
            <p>Are you sure you want to apply?</p>
            <button type="submit">Apply</button>
        </form>
        <br>
        <a href="jobs.php">Cancel</a>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>
