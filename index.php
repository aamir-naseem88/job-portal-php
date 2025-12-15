<?php include 'includes/header.php'; ?>

<div class="text-center mt-5">
    <h1 class="display-4">Welcome to JobPortal</h1>
    <p class="lead">Find your dream job or hire the best talent.</p>

    <div class="mt-4">
        <a href="auth/register.php" class="btn btn-primary btn-lg me-2">Register</a>
        <a href="auth/login.php" class="btn btn-secondary btn-lg">Login</a>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-4 text-center">
        <div class="card p-4 mb-4">
            <h4>Employers</h4>
            <p>Post jobs and find qualified candidates.</p>
            <a href="auth/register.php" class="btn btn-primary">Get Started</a>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="card p-4 mb-4">
            <h4>Job Seekers</h4>
            <p>Browse jobs and apply easily online.</p>
            <a href="auth/register.php" class="btn btn-primary">Get Started</a>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="card p-4 mb-4">
            <h4>Admin</h4>
            <p>Manage users, jobs, and companies.</p>
            <a href="auth/login.php" class="btn btn-primary">Login</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
