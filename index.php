<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Entropy Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>File Entropy Calculator</h1>
        <form action="entropy.php" method="post" enctype="multipart/form-data">
            <label for="file">Choose a text file:</label>
            <input type="file" name="file" id="file" accept=".txt" required>
            <button type="submit">Calculate Entropy</button>
        </form>
        <div id="error" class="error"></div>
    </div>
</body>
</html>
