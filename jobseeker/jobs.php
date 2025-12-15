<?php
include '../includes/header.php';
require '../includes/auth.php';
checkRole('jobseeker');
require '../config/database.php';

// Fetch all jobs with company info
$stmt = $pdo->prepare("
    SELECT jobs.*, companies.company_name 
    FROM jobs
    JOIN companies ON jobs.company_id = companies.company_id
    ORDER BY jobs.created_at DESC
");
$stmt->execute();
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Jobs</title>
</head>
<body>

<h2>Available Jobs</h2>

<?php if (!$jobs): ?>
    <p>No jobs found.</p>
<?php else: ?>
    <ul>
    <?php foreach ($jobs as $job): ?>
        <li>
            <strong><?php echo $job['title']; ?></strong> at <?php echo $job['company_name']; ?><br>
            Location: <?php echo $job['location']; ?> | Type: <?php echo $job['job_type']; ?><br>
            <a href="apply.php?job_id=<?php echo $job['job_id']; ?>">Apply</a>
        </li>
        <hr>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<br>
<a href="dashboard.php">Back to Dashboard</a> | <a href="../auth/logout.php">Logout</a>
<br>
<?php include '../includes/footer.php'; ?>

</body>
</html>
