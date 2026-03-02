<?php
session_start();

$errors = [];
$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    if (empty($password)) {
        $errors[] = 'Password is required';
    }
    
    // If no errors, store in session and redirect to step 2
    if (empty($errors)) {
        $_SESSION['username'] = htmlspecialchars($username);
        $_SESSION['password'] = htmlspecialchars($password);
        header('Location: step2.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Step 1 - Account Info</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        .error { color: red; margin: 10px 0; }
        input { display: block; margin: 10px 0; padding: 8px; width: 100%; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Step 1: Account Information</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p>• <?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Next →</button>
    </form>
</body>
</html>