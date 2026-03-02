<?php
$result = null;
$equation = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num1 = $_POST['num1'] ?? '';
    $num2 = $_POST['num2'] ?? '';
    $operation = $_POST['operation'] ?? '';
    
    if (!is_numeric($num1) || !is_numeric($num2)) {
        $error = "Error: Both inputs must be numeric values.";
    } elseif ($operation === '/' && $num2 == 0) {
        $error = "Error: Cannot divide by zero.";
    } elseif (!in_array($operation, ['+', '-', '*', '/'])) {
        $error = "Error: Invalid operation selected.";
    } else {
        $num1 = floatval($num1);
        $num2 = floatval($num2);
        
        switch ($operation) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                $result = $num1 / $num2;
                break;
        }
        
        $equation = "$num1 $operation $num2 = $result";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { max-width: 400px; }
        input, select { padding: 8px; margin: 5px 0; width: 100%; }
        button { padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; margin: 10px 0; }
        .success { color: green; margin: 10px 0; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Calculator</h1>
    
    <form method="POST">
        <label>First Number:</label>
        <input type="text" name="num1" required>
        
        <label>Operation:</label>
        <select name="operation" required>
            <option value="">-- Select Operation --</option>
            <option value="+">Addition (+)</option>
            <option value="-">Subtraction (-)</option>
            <option value="*">Multiplication (*)</option>
            <option value="/">Division (/)</option>
        </select>
        
        <label>Second Number:</label>
        <input type="text" name="num2" required>
        
        <button type="submit">Calculate</button>
    </form>
    
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if ($equation): ?>
        <div class="success"><?php echo htmlspecialchars($equation); ?></div>
    <?php endif; ?>
</body>
</html>