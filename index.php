<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="hero-section text-center">
    <div class="container">
        <h1 class="hero-title">Your Health, Our Priority</h1>
        <p class="lead mb-4">Book appointments with top doctors online, quickly and easily.</p>
        
        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn btn-primary btn-lg me-2">Get Started</a>
            <a href="login.php" class="btn btn-outline-secondary btn-lg">Login</a>
        <?php else: ?>
            <?php if($_SESSION['role'] == 'patient'): ?>
                <a href="patient/dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
            <?php else: ?>
                <a href="<?php echo $_SESSION['role']; ?>/dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-4">
            <div class="card-body">
                <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                <h4 class="card-title">Expert Doctors</h4>
                <p class="card-text">Connect with highly qualified professionals across various specializations.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-4">
            <div class="card-body">
                <i class="fas fa-calendar-check fa-3x text-primary mb-3"></i>
                <h4 class="card-title">Easy Booking</h4>
                <p class="card-text">Schedule your appointments online anytime, anywhere.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-4">
            <div class="card-body">
                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                <h4 class="card-title">Secure & Private</h4>
                <p class="card-text">Your health records and personal information are kept safe and secure.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
