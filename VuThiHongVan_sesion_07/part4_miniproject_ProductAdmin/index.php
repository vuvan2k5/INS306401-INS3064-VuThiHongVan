<?php
require_once 'Database.php';
$db = Database::getInstance()->getConnection();

// Lấy dữ liệu category để hiển thị dropdown
$catStmt = $db->prepare("SELECT id, category_name FROM categories");
$catStmt->execute();
$categories = $catStmt->fetchAll();

// Xử lý filter từ người dùng
$search = $_GET['search'] ?? '';
$category_id = $_GET['category_id'] ?? '';

$sql = "SELECT p.id, p.name, p.price, p.stock, c.category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE 1=1";

$params = [];

if (!empty($search)) {
    $sql .= " AND p.name LIKE :search";
    $params[':search'] = "%$search%";
}

if (!empty($category_id)) {
    $sql .= " AND p.category_id = :category_id";
    $params[':category_id'] = $category_id;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Admin Dashboard</title>
    <style>
        .low-stock { background-color: #ffcccc; } /* highlight đỏ */
    </style>
</head>
<body>
    <h2>Product Administration</h2>

    <!-- Form tìm kiếm -->
    <form method="get">
        <input type="text" name="search" placeholder="Search by name" value="<?= htmlspecialchars($search) ?>">
        <select name="category_id">
            <option value="">-- All Categories --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $cat['id']==$category_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Bảng sản phẩm -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Price</th><th>Category</th><th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr class="<?= $p['stock'] < 10 ? 'low-stock' : '' ?>">
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= $p['price'] ?></td>
                    <td><?= htmlspecialchars($p['category_name'] ?? 'No category') ?></td>
                    <td><?= $p['stock'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
