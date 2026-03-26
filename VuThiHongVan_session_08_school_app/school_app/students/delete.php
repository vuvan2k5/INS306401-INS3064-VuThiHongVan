<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = $_GET['id'] ?? 0;

if ($id) {
    try {
        $db->delete('students', 'id = ?', [$id]);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

// Luôn quay về index
header("Location: index.php");
exit;