<?php
session_start();
include("SQLconnect.php");
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["username"]) &&  isset($_POST["password"]) && $_POST["username"]!="" && $_POST["password"]!=""){
        $usr = $_POST["username"]; $psw = md5($_POST["password"]);
        $res = $conn->query("SELECT * FROM utenti WHERE utenti.username='$usr'");
        if ($res->num_rows == 1){
            $row = $res->fetch_assoc();
            if ($psw==$row["passwordHash"]){
                $_SESSION["username"]=$row["username"];
                if($row["permessi"] == "admin")
                    echo "<script>window.location.href = 'admin.php';</script>";
                else if($row["permessi"] == "client")
                    echo "<script>window.location.href = 'user.php';</script>";
            }
            else echo("<h3>Password errata! </h3><br><a href='login.php'>Torna al login</a>");
        }
        else echo ("<h3>Errore! L'utente non è stato trovato.</h3><br><a href='login.php'>Torna al login</a>");
    
    }
    else echo("<h3>Username o password non supportati.</h3><br><a href='login.php'>Torna al login</a>");}

else echo "Error 400 Not Allowed";
$conn->close();
?>
