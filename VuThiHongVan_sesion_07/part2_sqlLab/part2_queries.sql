-- Task 1: Product Catalog with Categories
SELECT 
    p.id AS product_id,
    p.name AS product_name,
    p.price,
    COALESCE(c.category_name, 'No category') AS category_name
FROM products p
LEFT JOIN categories c ON p.category_id = c.id;

-- Task 2: Revenue Analysis by Category
SELECT 
    COALESCE(c.category_name, 'No category') AS category_name,
    SUM(oi.quantity * oi.unit_price) AS total_revenue
FROM order_items oi
JOIN products p ON oi.product_id = p.id
LEFT JOIN categories c ON p.category_id = c.id
GROUP BY c.category_name;

-- Task 3: VIP Customers
SELECT 
    u.name,
    u.email,
    SUM(o.total_amount) AS total_spent
FROM users u
JOIN orders o ON u.id = o.user_id
GROUP BY u.id, u.name, u.email
ORDER BY total_spent DESC
LIMIT 3;
