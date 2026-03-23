<?php
// Kết nối DB bằng PDO
$host = 'localhost';
$db   = 'shopdb';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query dữ liệu (ví dụ bảng products)
    $stmt = $pdo->query("SELECT * FROM products");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!-- In ra console -->
<script>
    const data = <?php echo json_encode($data); ?>;
    console.log(data);
</script>