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

// Fetch applicants for this employer's jobs
$stmt = $pdo->prepare("
    SELECT applications.*, jobs.title, users.name, users.email
    FROM applications
    JOIN jobs ON applications.job_id = jobs.job_id
    JOIN users ON applications.user_id = users.user_id
    WHERE jobs.company_id = :company_id
    ORDER BY applications.applied_at DESC
");
$stmt->execute([':company_id' => $company['company_id']]);
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Applicants</title>
</head>
<body>
<h2>Applicants for Your Jobs</h2>

<?php if (!$applicants): ?>
    <p>No applicants yet.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Job Title</th>
            <th>Applicant Name</th>
            <th>Email</th>
            <th>Status</th>
        </tr>
        <?php foreach ($applicants as $app): ?>
        <tr>
            <td><?php echo $app['title']; ?></td>
            <td><?php echo $app['name']; ?></td>
            <td><?php echo $app['email']; ?></td>
            <td><?php echo $app['status']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
