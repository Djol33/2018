<?php
function conn()
{
    $conn = new PDO("mysql:host=localhost;dbname=primer1", "root", "");
    if ($conn) {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Additional PDO settings (optional)
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Uncomment if needed
        return $conn;
    }
}
