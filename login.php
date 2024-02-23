<?php
session_start();
    require_once "conn.php";
if(isset($_SESSION["id"])){
    header("Location: home.html");
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="name">Name</label>
        <input type="text" name="name" id="name"/>
        <label for="pw">PW</label>
        <input type="text" name="pw" id="pw">
        <input id ="sub" type="submit" value="">
    </form>
</body>
<script>
    let sub = document.querySelector("form")
    sub.addEventListener("submit", function(e){
 
    })
    
    
    </script>
</html>';}
else{
    if(!isset($_SESSION["id"])){
        $conn = conn();
        $sql = "SELECT * FROM korisnik WHERE korisnicko_ime = :korime AND lozinka = :lozinka";
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":korime", $_POST["name"]);
            $pw = md5($_POST["pw"]);
            $stmt->bindParam(":lozinka", $pw);
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $res = $stmt->fetch();
                    $_SESSION["id"] = $res["id"];
                    $_SESSION["uloga_id"] = $res["uloga_id"];
                    if($res["uloga_id"] == "1") header("Location: admin.php");
                    else if($res["uloga_id"] =="2") header("Location: korisnik.php");
                    echo "xx";
                }else{
                    echo "greska";
                }
            }
        }
    }



}