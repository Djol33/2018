<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-type: text/html");
require_once "conn.php";

if (isset($_SESSION["uloga_id"]) && $_SESSION["uloga_id"] == 1) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $sq_korisnici = "SELECT id, ime, prezime FROM korisnik";
        $conn = conn();
        $res = NULL;
        if ($stmt = $conn->prepare($sq_korisnici)) {
            if ($stmt->execute()) {
                $res = $stmt->fetchAll();
            }
        }


        $html = '
    <!DOCTYPE html>
    <head>
    <title>aaaaa</title>
</head>
    
    <body>
<form action="admin.php" method="POST" enctype="multipart/form-data">
	<table>
		
		<tr>
			<th colspan="2">Pozivnica za venčanje</th>
		</tr>

		<tr>
			<td>Naslov:</td>
			<td>
				<input type="text" name="naslov"/>
			</td>
		</tr>

		<tr>
			<td>Tekst:</td>
			<td>
				<textarea name="tekst"> </textarea>
			</td>
		</tr>

		<tr>
			<td>Slika:</td>
			<td>
				<input type="file" name="fajl"/>
			</td>
		</tr>

		<tr>
			<td align="top">Korisnici: <br/></td>
			<td>';
        foreach ($res as $row) {
            $html .= "<input type='checkbox' name='korisnik[]' value='" . $row["id"] . "'/>" . $row["ime"] . " " . $row["prezime"];
            $html .= "<br/>";
        }

        //<input type="checkbox" name="imeprez" /> Ime i prezime <br/>
        $html .= '<!-- Prikaz korisnika iz baze -->

			</td>
		</tr>

		<tr>
			<td colspan="2">
				<input name="submit" type="submit" value="Kreiraj pozivnicu" />
			</td>
		</tr>
	</table>
</form> 
<!--
<script>
    let form = document.querySelector("form");
    form.addEventListener("submit", function(e){
        e.preventDefault();
        console.log("aaa");
    })

</script>-->
';
        $html .= "<p>Hi</p></body>";
        echo $html;
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "hiiii";
        $naslov = $_POST["naslov"] ?? "default value";

        if (isset($_POST["tekst"]) && strlen($_POST["tekst"]) > 2) $tekst = $_POST["tekst"];
        else         echo "lol nothing wants to be echoed";
        if (!isset($_POST["korisnik"])) {

            echo "pozovi nekoga sirotinjo";

            die();
        }


        if ($_FILES["fajl"]["name"] == "slika") {
            echo "slika ne moze biti nazvana slika";
        }
        $slikaNewName = "uploads/" . $_FILES["fajl"]["name"];
        move_uploaded_file($_FILES["fajl"]["tmp_name"], $slikaNewName);

        $sql = "INSERT INTO pozivnice (naslov, tekst, slika) VALUES (:naslov, :tekst, :slika)";

        $conn = conn();

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bindParam(':naslov', $naslov);
            $stmt->bindParam(":tekst", $tekst);
            $stmt->bindParam(":slika", $slikaNewName);
            if ($stmt->execute()) {
                $lastId = $conn->lastInsertId();

                foreach ($_POST['korisnik'] as $row) {
                    $conn2 = conn();

                    $sql = "INSERT INTO korisnik_pozivnica VALUES (:id_poz, :id_kor)";
                    if ($stmt2 = $conn2->prepare($sql)) {
                        $stmt2->bindParam(":id_poz", $lastId);
                        $stmt2->bindParam(':id_kor', $row);
                        $stmt2->execute();

                    }


                }


            }
        }


    }
} else {
    echo "xx";
}