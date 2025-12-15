<?php
include '../includes/header.php';
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

if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === 0) {
    $ext = pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION);
    $allowed = ['pdf'];
    if (in_array(strtolower($ext), $allowed)) {
        $newName = uniqid() . '.' . $ext;
        $dest = '../assets/uploads/' . $newName;
        move_uploaded_file($_FILES['cv_file']['tmp_name'], $dest);
        $cv_file = $newName;
    }
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
        <form method="POST" enctype="multipart/form-data">
    <p>Upload your CV (PDF, optional):</p>
    <input type="file" name="cv_file" accept=".pdf"><br><br>
    <button type="submit">Apply</button>
</form>

        <br>
        <a href="jobs.php">Cancel</a>
    <?php endif; ?>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>

</body>
</html>
