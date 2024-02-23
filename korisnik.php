<?php
session_start();
require_once "conn.php";
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $res = null;
    $sql = " select  * from pozivnice p inner join korisnik_pozivnica kp ON kp.id_pozivnica = p.id WHERE kp.id_korisnik = :param   ORDER BY p.datum DESC LIMIT 5";
    if ($conn = conn()) {
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":param", $_SESSION["id"]);
            if ($stmt->execute()) {
                $res = $stmt->fetchAll();
            }
        }
    }
    $html = "<table><thead>
            <tr>
                <th>ID</th>
                <th>Naslov</th>
                <th>tekst</th>
                <th>Datum</th>
                <th>Slika</th>
                <th>Odbij</th>
            </tr>
        </thead><tbody>";
    foreach ($res as $row) {
        $html .= "<tr><td>" . $row["id"] . "</td><td>" . $row["naslov"] . "</td><td>" . $row["tekst"] . "</td><td>" . $row["datum"] . "</td><td><img style='width:100px' src='" . $row["slika"] . "'/></td>" . "<td>" . "<a href='obrisi.php?id=" . $row["id"] . "'>odbij</a></td>";
    }
    $html .= "</tbody></table>";
    echo $html;
}