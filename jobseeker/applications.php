<?php
include '../includes/header.php';
require '../includes/auth.php';
checkRole('jobseeker');
require '../config/database.php';

$stmt = $pdo->prepare("
    SELECT applications.*, jobs.title, companies.company_name
    FROM applications
    JOIN jobs ON applications.job_id = jobs.job_id
    JOIN companies ON jobs.company_id = companies.company_id
    WHERE applications.user_id = :user_id
    ORDER BY applications.applied_at DESC
");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Applications</title>
</head>
<body>
<h2>My Job Applications</h2>

<?php if (!$applications): ?>
    <p>You haven’t applied for any jobs yet.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Job Title</th>
            <th>Company</th>
            <th>Status</th>
        </tr>
        <?php foreach ($applications as $app): ?>
        <tr>
            <td><?php echo $app['title']; ?></td>
            <td><?php echo $app['company_name']; ?></td>
            <td><?php echo $app['status']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<br><a href="dashboard.php">Back to Dashboard</a>
<?php include '../includes/footer.php'; ?>

</body>
</html>
