<?php
include '../includes/header.php';
require '../includes/auth.php';
checkRole('employer');
require '../config/database.php';

// Check if company exists
$stmt = $pdo->prepare("SELECT * FROM companies WHERE user_id = :user_id");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$company = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2>Employer Dashboard</h2>

<?php if (!$company): ?>
    <p>You need to create a company profile first.</p>
    <a href="company.php">Create Company</a>
<?php else: ?>
    <p>Company: <strong><?php echo $company['company_name']; ?></strong></p>
    <a href="post-job.php">Post Job</a>
<?php endif; ?>

<br><br>
<a href="../auth/logout.php">Logout</a>
<?php include '../includes/footer.php'; ?>
