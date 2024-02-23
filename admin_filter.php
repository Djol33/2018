<?php
require_once "conn.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $filter = $_GET["filter"];
    $orderBy = NULL;
    switch ($filter) {
        case 1:
            $orderBy = "ASC";
            break;
        case 2:
            $orderBy = "DESC";
            break;
    }

    $sql = "SELECT * FROM pozivnice order by datum $orderBy";
    $conn = conn();
    if ($stmt = $conn->prepare($sql)) {
        if ($stmt->execute()) {
            $res = $stmt->fetchAll();
            if ($res) {
                echo json_encode($res);
            } else {
                echo json_encode([]);
            }
        }
    }

}