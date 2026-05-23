<?php
session_start();
require_once 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == 'admin') {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['role'] = 'admin';
            header("Location: admin/dashboard.php");
            exit;
        } else {
            $error = "Invalid admin credentials.";
        }
    } else if ($role == 'doctor') {
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = 'doctor';
            header("Location: doctor/dashboard.php");
            exit;
        } else {
            $error = "Invalid doctor credentials.";
        }
    } else {
        $stmt = $pdo->prepare("SELECT * FROM patients WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = 'patient';
            header("Location: patient/dashboard.php");
            exit;
        } else {
            $error = "Invalid patient credentials.";
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white text-center py-3">
                <h4 class="mb-0">Login</h4>
            </div>
            <div class="card-body p-4">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Login As</label>
                        <select name="role" id="roleSelect" class="form-select" onchange="toggleLabel()">
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label id="emailLabel" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                    
                    <div class="text-center mt-3">
                        Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleLabel() {
    var role = document.getElementById('roleSelect').value;
    var label = document.getElementById('emailLabel');
    if(role === 'admin') {
        label.innerText = 'Username';
        document.querySelector('input[name="email"]').type = 'text';
    } else {
        label.innerText = 'Email';
        document.querySelector('input[name="email"]').type = 'email';
    }
}
</script>

<?php include 'includes/footer.php'; ?>
