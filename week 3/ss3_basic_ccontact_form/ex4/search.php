<?php
$searchTerm = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .search-container {
            max-width: 500px;
            margin: 20px 0;
        }
        input[type="text"] {
            padding: 8px;
            width: 300px;
            font-size: 16px;
        }
        button {
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
        }
        .results {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Search</h1>
    
    <div class="search-container">
        <form method="GET">
            <input 
                type="text" 
                name="q" 
                placeholder="Enter search term..." 
                value="<?php echo $searchTerm; ?>"
            >
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if ($searchTerm): ?>
        <div class="results">
            <p>You searched for: <strong><?php echo $searchTerm; ?></strong></p>
            <p>URL shows: ?q=<?php echo urlencode($searchTerm); ?></p>
        </div>
    <?php endif; ?>
</body>
</html>