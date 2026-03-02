<?php
session_start();

// Check if step 1 data exists
if (!isset($_SESSION['username'])) {
    header('Location: step1.php');
    exit;
}

$step1_data = [
    'username' => $_SESSION['username'] ?? '',
    'password' => $_SESSION['password'] ?? ''
];

$submitted = false;
$all_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store step 2 data
    $_SESSION['bio'] = $_POST['bio'] ?? '';
    $_SESSION['location'] = $_POST['location'] ?? '';
    
    // Compile all data
    $all_data = [
        'username' => $step1_data['username'],
        'bio' => $_SESSION['bio'],
        'location' => $_SESSION['location']
    ];
    
    $submitted = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Step 2 - Profile Info</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        .form-group { margin: 15px 0; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .success { background: #d4edda; padding: 15px; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>

<?php if ($submitted): ?>
    <div class="success">
        <h2>All Data Submitted Successfully!</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($all_data['username']); ?></p>
        <p><strong>Bio:</strong> <?php echo htmlspecialchars($all_data['bio']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($all_data['location']); ?></p>
    </div>
    <a href="step1.php">Start Over</a>
<?php else: ?>
    <h1>Step 2 - Profile Information</h1>
    <p>Username: <strong><?php echo htmlspecialchars($step1_data['username']); ?></strong></p>
    
    <form method="POST">
        <div class="form-group">
            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" rows="4" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
        </div>
        
        <button type="submit">Submit All Data</button>
    </form>
<?php endif; ?>

</body>
</html>