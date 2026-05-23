<?php
session_start();
require_once 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'] ?? 'patient';
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        if ($role == 'patient') {
            $gender = $_POST['gender'];
            $stmt = $pdo->prepare("INSERT INTO patients (name, email, password, phone, gender) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hashed_password, $phone, $gender]);
        } else if ($role == 'doctor') {
            $specialization = trim($_POST['specialization']);
            $stmt = $pdo->prepare("INSERT INTO doctors (name, email, password, phone, specialization) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hashed_password, $phone, $specialization]);
        }
        $success = "Registration successful! You can now login.";
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            $error = "Email already exists!";
        } else {
            $error = "Registration failed: " . $e->getMessage();
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white text-center py-3">
                <h4 class="mb-0">Register</h4>
            </div>
            <div class="card-body p-4">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Register As</label>
                        <select name="role" id="roleSelect" class="form-select" onchange="toggleFields()">
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <!-- Patient specific fields -->
                    <div id="patientFields">
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Doctor specific fields -->
                    <div id="doctorFields" style="display:none;">
                        <div class="mb-3">
                            <label class="form-label">Specialization</label>
                            <input type="text" name="specialization" id="specInput" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
                    
                    <div class="text-center mt-3">
                        Already have an account? <a href="login.php" class="text-decoration-none">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFields() {
    var role = document.getElementById('roleSelect').value;
    var patientFields = document.getElementById('patientFields');
    var doctorFields = document.getElementById('doctorFields');
    var specInput = document.getElementById('specInput');

    if (role === 'doctor') {
        patientFields.style.display = 'none';
        doctorFields.style.display = 'block';
        specInput.setAttribute('required', 'required');
    } else {
        patientFields.style.display = 'block';
        doctorFields.style.display = 'none';
        specInput.removeAttribute('required');
    }
}
</script>

<?php include 'includes/footer.php'; ?>
