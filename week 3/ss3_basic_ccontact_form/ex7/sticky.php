<?php
$errors = [];
$formData = [
    'name' => '',
    'email' => '',
    'password' => '',
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $formData['name'] = trim($_POST['name'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['password'] = $_POST['password'] ?? '';
    $formData['message'] = trim($_POST['message'] ?? '');

    // Validation
    if (empty($formData['name'])) {
        $errors['name'] = 'Name is required';
    }
    
    if (empty($formData['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    if (strlen($formData['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }
    
    if (empty($formData['message'])) {
        $errors['message'] = 'Message is required';
    }

    // If no errors, process form
    if (empty($errors)) {
        echo '<p style="color: green;">Form submitted successfully!</p>';
        // Reset form after successful submission
        $formData = ['name' => '', 'email' => '', 'password' => '', 'message' => ''];
    }
}
?>

<form method="POST">
    <div>
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($formData['name']); ?>">
        <?php if (isset($errors['name'])): ?>
            <span style="color: red;"><?php echo $errors['name']; ?></span>
        <?php endif; ?>
    </div>

    <div>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($formData['email']); ?>">
        <?php if (isset($errors['email'])): ?>
            <span style="color: red;"><?php echo $errors['email']; ?></span>
        <?php endif; ?>
    </div>

    <div>
        <label>Password:</label>
        <input type="password" name="password" value="<?php echo htmlspecialchars($formData['password']); ?>">
        <?php if (isset($errors['password'])): ?>
            <span style="color: red;"><?php echo $errors['password']; ?></span>
        <?php endif; ?>
    </div>

    <div>
        <label>Message:</label>
        <textarea name="message"><?php echo htmlspecialchars($formData['message']); ?></textarea>
        <?php if (isset($errors['message'])): ?>
            <span style="color: red;"><?php echo $errors['message']; ?></span>
        <?php endif; ?>
    </div>

    <button type="submit">Submit</button>
</form>