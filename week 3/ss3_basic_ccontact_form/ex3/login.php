<?php
session_start();

// Initialize failed attempts counter
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
}

// Hardcoded credentials
$valid_user = 'admin';
$valid_pass = '123456';

$message = '';
$login_success = false;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validate credentials
    if ($username === $valid_user && $password === $valid_pass) {
        $message = 'Login Successful';
        $login_success = true;
        $_SESSION['failed_attempts'] = 0; // Reset counter on success
    } else {
        $_SESSION['failed_attempts']++;
        $message = 'Invalid Credentials';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <style>
        body { font-family: Arial; margin: 50px; }
        .form-container { max-width: 300px; }
        input { display: block; margin: 10px 0; padding: 8px; width: 100%; }
        button { padding: 8px 20px; cursor: pointer; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login Form</h2>
        
        <?php if ($message): ?>
            <p class="<?php echo $login_success ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>
        
        <?php if ($_SESSION['failed_attempts'] > 0 && !$login_success): ?>
            <p class="error">Failed Attempts: <?php echo $_SESSION['failed_attempts']; ?></p>
        <?php endif; ?>
        
        <?php if (!$login_success): ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>