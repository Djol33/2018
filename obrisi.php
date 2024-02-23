<?php
session_start();
require_once "conn.php";
if (isset($_SESSION["id"])) {
    $poz_id = $_GET["id"];
    $sql = "DELETE FROM korisnik_pozivnica WHERE id_korisnik = :param AND id_pozivnica = :poz";
    if ($conn = conn()) {
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":param", $_SESSION["id"]);
            $stmt->bindParam(":poz", $poz_id);
            if ($stmt->execute()) {
                echo "success";
            }
        }
    }

}