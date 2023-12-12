<?php
// Function to get the URL mapping from the JSON file
function getUrlMap() {
    $urlMapFile = 'urlMap.json';
    if (file_exists($urlMapFile)) {
        $jsonContent = file_get_contents($urlMapFile);
        return json_decode($jsonContent, true);
    }
    return [];
}

// Function to save the URL mapping to the JSON file
function saveUrlMap($urlMap) {
    $urlMapFile = 'urlMap.json';
    $jsonContent = json_encode($urlMap, JSON_PRETTY_PRINT);
    file_put_contents($urlMapFile, $jsonContent);
}

// Check if delete button is clicked
if (isset($_POST['delete'])) {
    $urlToDelete = $_POST['delete'];
    $urlMap = getUrlMap();
    if (isset($urlMap[$urlToDelete])) {
        unset($urlMap[$urlToDelete]);
        saveUrlMap($urlMap);
    }
}

// Get the existing URL map
$urlMap = getUrlMap();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - URL Shortener</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Admin - URL Shortener</h2>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>Short Code</th>
                    <th>Original URL</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($urlMap as $shortCode => $originalUrl): ?>
                    <tr>
                        <td><?php echo $shortCode; ?></td>
                        <td><?php echo $originalUrl; ?></td>
                        <td>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <button type="submit" name="delete" value="<?php echo $shortCode; ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Font Awesome for delete icon -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>
</html>
