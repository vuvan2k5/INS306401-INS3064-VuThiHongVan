<?php
$submitted = false;
$formData = [
    'name' => '',
    'email' => '',
    'message' => ''
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $formData['name'] = trim($_POST['name'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['message'] = trim($_POST['message'] ?? '');
    
    if (empty($formData['name'])) {
        $errors['name'] = 'Name is required';
    }
    if (empty($formData['email']) || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required';
    }
    if (empty($formData['message'])) {
        $errors['message'] = 'Message is required';
    }
    
    // If no errors, mark as submitted
    if (empty($errors)) {
        $submitted = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        .error { color: red; font-size: 12px; }
        button { background-color: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .thank-you { background-color: #d4edda; color: #155724; padding: 20px; border-radius: 5px; text-align: center; }
    </style>
</head>
<body>

<?php if ($submitted): ?>
    <div class="thank-you">
        <h2>Thank You!</h2>
        <p>Thank you for contacting us, <?php echo htmlspecialchars($formData['name']); ?>.</p>
        <p>We will get back to you soon at <?php echo htmlspecialchars($formData['email']); ?>.</p>
    </div>
<?php else: ?>
    <h2>Contact Us</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($formData['name']); ?>">
            <?php if (isset($errors['name'])): ?>
                <span class="error"><?php echo $errors['name']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email']); ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error"><?php echo $errors['email']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5"><?php echo htmlspecialchars($formData['message']); ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <span class="error"><?php echo $errors['message']; ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Send</button>
    </form>
<?php endif; ?>

</body>
</html>