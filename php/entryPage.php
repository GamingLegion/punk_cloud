<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entry Page</title>
</head>
<body>    
    <?php
    // Retrieve the link name from the query string
    $linkName = isset($_GET['link']) ? $_GET['link'] : 'default';
    echo '<p>'.$linkName.'</p>';
    ?>
</body>
</html>