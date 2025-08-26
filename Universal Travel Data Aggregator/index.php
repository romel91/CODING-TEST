<?php
$data = json_decode(file_get_contents('aggregator.php'), true);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Travel Aggregator</title>
</head>
<body>
    <h1>Travel Aggregated Data</h1>
    <pre><?php echo json_encode($data, JSON_PRETTY_PRINT); ?></pre>
</body>
</html>
