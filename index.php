<?php

// Function to generate a unique short code
function generateShortCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $shortCode = '';
    for ($i = 0; $i < $length; $i++) {
        $shortCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $shortCode;
}

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the URL
    $url = $_POST["url"];
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // Generate a unique short code
        $shortCode = generateShortCode();

        // Get the existing URL map
        $urlMap = getUrlMap();

        // Make sure the generated short code is unique
        while (array_key_exists($shortCode, $urlMap)) {
            $shortCode = generateShortCode();
        }

        // Save the new mapping
        $urlMap[$shortCode] = $url;
        saveUrlMap($urlMap);

        // Display the shortened URL
        $shortenedUrl = "http://yourdomain.com/$shortCode";
        echo "<br><div class='success-message'>Shortened URL: <a href='$shortenedUrl' target='_blank'>$shortenedUrl</a></div>";
    } else {
        echo "<div class='error-message'>Invalid URL. Please enter a valid URL.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
   
<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

form {
    text-align: center;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

label {
    font-size: 18px;
    margin-right: 10px;
}

input {
    width: 70%;
    padding: 8px;
    margin-bottom: 20px;
}

button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

.success-message {
    color: #4caf50;
    margin-top: 20px;
}

.error-message {
    color: #ff6347;
    margin-top: 20px;
}

.admin-button {
            position: fixed;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .admin-symbol {
            fill: black; /* Set the fill color for the SVG */
        }
</style>
</head>
<body>


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h2>URL Shortener</h2>
        <label for="url">Enter URL:</label>
        <input type="text" name="url" id="url" required>
        <button type="submit">Shorten</button>
    </form>
     <!-- Admin button with SVG symbol -->
     <div class="admin-button" onclick="window.location.href='admin.php'">
        <img src="admin-symbol.svg" alt="Admin Symbol" width="28" height="28">
    </div>
</body>
</html>
