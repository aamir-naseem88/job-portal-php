<?php
include '../includes/header.php';
require '../includes/auth.php';
checkRole('jobseeker');

echo "Job Seeker Dashboard";

<a href="jobs.php">View Jobs</a>

<br><br>
<?php include '../includes/footer.php'; ?>

