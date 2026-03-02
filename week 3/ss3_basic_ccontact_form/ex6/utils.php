<?php

/**
 * Sanitize user input by removing special characters and whitespace
 * @param string $data The data to sanitize
 * @return string Sanitized data
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate email format
 * @param string $email The email to validate
 * @return bool True if valid, false otherwise
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate string length within min and max bounds
 * @param string $str The string to validate
 * @param int $min Minimum length
 * @param int $max Maximum length
 * @return bool True if within bounds, false otherwise
 */
function validateLength($str, $min, $max) {
    $length = strlen($str);
    return $length >= $min && $length <= $max;
}

/**
 * Validate password strength
 * Requires: minimum 8 characters and at least one special character
 * @param string $pass The password to validate
 * @return bool True if valid, false otherwise
 */
function validatePassword($pass) {
    $minLength = 8;
    $hasSpecialChar = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $pass);
    
    return strlen($pass) >= $minLength && $hasSpecialChar;
}

// ===== TEST SCRIPT =====
function runTests() {
    echo "=== VALIDATION TEST RESULTS ===\n\n";
    
    // Test sanitize()
    echo "--- sanitize() Tests ---\n";
    $testCases = [
        ["<script>alert('xss')</script>", "XSS prevention"],
        ["  name  ", "Trim whitespace"],
        ["'quoted'", "Remove quotes"]
    ];
    
    foreach ($testCases as [$input, $desc]) {
        $result = sanitize($input);
        echo "PASS: $desc → $result\n";
    }
    
    echo "\n--- validateEmail() Tests ---\n";
    $emailTests = [
        ["user@example.com", true],
        ["invalid.email", false],
        ["test@domain.co.uk", true],
        ["@nodomain.com", false]
    ];
    
    foreach ($emailTests as [$email, $expected]) {
        $result = validateEmail($email) === $expected ? "PASS" : "FAIL";
        echo "$result: '$email' (expected: " . ($expected ? "valid" : "invalid") . ")\n";
    }
    
    echo "\n--- validateLength() Tests ---\n";
    $lengthTests = [
        ["hello", 3, 10, true],
        ["hi", 3, 10, false],
        ["toolongstring", 3, 10, false],
        ["test", 4, 4, true]
    ];
    
    foreach ($lengthTests as [$str, $min, $max, $expected]) {
        $result = validateLength($str, $min, $max) === $expected ? "PASS" : "FAIL";
        echo "$result: '$str' (length $min-$max, expected: " . ($expected ? "valid" : "invalid") . ")\n";
    }
    
    echo "\n--- validatePassword() Tests ---\n";
    $passTests = [
        ["Pass@1234", true],
        ["short@1", false],
        ["NoSpecialChars123", false],
        ["ValidPass!2024", true],
        ["weak", false]
    ];
    
    foreach ($passTests as [$pass, $expected]) {
        $result = validatePassword($pass) === $expected ? "PASS" : "FAIL";
        echo "$result: '$pass' (expected: " . ($expected ? "valid" : "invalid") . ")\n";
    }
}

// Run tests if executed directly
if (php_sapi_name() === 'cli' || basename($_SERVER['PHP_SELF'] ?? '') === 'utils.php') {
    runTests();
}

?>