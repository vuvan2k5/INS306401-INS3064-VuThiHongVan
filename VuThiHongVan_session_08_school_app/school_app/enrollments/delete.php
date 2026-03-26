<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = $_GET['id'] ?? 0;

if ($id) {
    try {
        $db->delete('enrollments', 'id = ?', [$id]);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

header("Location: index.php");
exit;