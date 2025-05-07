<?php
session_start();
include("SQLconnect.php");
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["username"]) &&  isset($_POST["password"]) && $_POST["username"]!="" && $_POST["password"]!=""){
        $res = $conn->query("SELECT username FROM utenti");
        $flag=false;
        while($row = $res->fetch_assoc()){
            if($row["username"]==$_POST["username"]){$flag=true;break;}
        }
        if ($flag) echo("<h3>Username già in uso.</h3> <a href='login.php'>Torna al login</a>");
        else {
            $hash = md5($_POST["password"]);
            $name = $_POST["username"];
            $conn->query("INSERT INTO utenti (utenti.username, utenti.passwordHash, utenti.permessi) VALUES ('$name', '$hash','client')");
            echo("<h3>Account creato. </h3><a href='login.php'>Torna al login</a>");
        }
    }
    else echo("<h3>Username o password non supportati. </h3><a href='login.php'>Torna al login</a>");}

else echo "Error 400 Not Allowed";
$conn->close();
?>
