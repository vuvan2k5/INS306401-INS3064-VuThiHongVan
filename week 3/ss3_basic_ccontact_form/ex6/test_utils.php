<?php

// Helper Functions for Validation and Sanitization

/**
 * Sanitize input data by removing HTML tags and whitespace
 */
function sanitize($data) {
    return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
}

/**
 * Validate email format
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate string length between min and max
 */
function validateLength($str, $min, $max) {
    $length = strlen($str);
    return $length >= $min && $length <= $max;
}

/**
 * Validate password: min 8 chars and at least 1 special character
 */
function validatePassword($pass) {
    $hasSpecialChar = preg_match('/[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\\/]/', $pass);
    $minLength = strlen($pass) >= 8;
    return $minLength && $hasSpecialChar;
}

// ===== TEST SCRIPT =====

function runTests() {
    echo "=== VALIDATION & SANITIZATION TESTS ===\n\n";
    
    $tests = 0;
    $passed = 0;
    
    // Test sanitize()
    echo "Testing sanitize():\n";
    $testData = "<script>alert('xss')</script>";
    $result = sanitize($testData);
    $expected = "&lt;script&gt;alert(&#039;xss&#039;)&lt;/script&gt;";
    if ($result === $expected) {
        echo "✓ PASS: Sanitization removes HTML tags\n";
        $passed++;
    } else {
        echo "✗ FAIL: Expected '$expected', got '$result'\n";
    }
    $tests++;
    
    // Test validateEmail()
    echo "\nTesting validateEmail():\n";
    $testCases = [
        "user@example.com" => true,
        "invalid.email" => false,
        "test@domain.co.uk" => true,
        "user@" => false
    ];
    
    foreach ($testCases as $email => $expected) {
        $result = validateEmail($email);
        if ($result === $expected) {
            echo "✓ PASS: '$email' validation correct\n";
            $passed++;
        } else {
            echo "✗ FAIL: '$email' expected " . ($expected ? "valid" : "invalid") . "\n";
        }
        $tests++;
    }
    
    // Test validateLength()
    echo "\nTesting validateLength():\n";
    $testCases = [
        ["hello", 3, 10, true],
        ["hi", 3, 10, false],
        ["toolong", 3, 5, false],
        ["test", 4, 4, true]
    ];
    
    foreach ($testCases as [$str, $min, $max, $expected]) {
        $result = validateLength($str, $min, $max);
        if ($result === $expected) {
            echo "✓ PASS: '$str' (len: $min-$max) validation correct\n";
            $passed++;
        } else {
            echo "✗ FAIL: '$str' expected " . ($expected ? "valid" : "invalid") . "\n";
        }
        $tests++;
    }
    
    // Test validatePassword()
    echo "\nTesting validatePassword():\n";
    $testCases = [
        "SecurePass123!" => true,
        "short1!" => false,
        "NoSpecialChar123" => false,
        "Valid@Pass99" => true,
        "weak" => false
    ];
    
    foreach ($testCases as $pass => $expected) {
        $result = validatePassword($pass);
        if ($result === $expected) {
            echo "✓ PASS: '$pass' validation correct\n";
            $passed++;
        } else {
            echo "✗ FAIL: '$pass' expected " . ($expected ? "valid" : "invalid") . "\n";
        }
        $tests++;
    }
    
    echo "\n=== SUMMARY ===\n";
    echo "Total Tests: $tests\n";
    echo "Passed: $passed\n";
    echo "Failed: " . ($tests - $passed) . "\n";
    echo "Success Rate: " . round(($passed / $tests) * 100, 2) . "%\n";
}

// Run tests
runTests();
?>