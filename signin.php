<?php
session_start();
include("SQLconnect.php");
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    print_r($_POST);
    if(isset($_POST["username"]) &&  isset($_POST["password"]) && $_POST["username"]!="" && $_POST["password"]!=""){
        $usr = $_POST["username"]; $psw = md5($_POST["password"]);
        $res = $conn->query("SELECT * FROM utenti WHERE utenti.username='$usr'");
        if ($res->num_rows == 1){
            $row = $res->fetch_assoc();
            if ($psw==$row["passwordHash"]){
                $_SESSION["username"]=$row["utenteId"];
                echo "<script>window.location.href = 'user.php';</script>";
            }
            else echo("Password errata! <a href='login.php'>Torna al login</a>");
        }
        else echo ("Errore! L'utente non è stato trovato.<a href='login.php'>Torna al login</a>");
    
    }
    else echo("Username o password non supportati. <a href='login.php'>Torna al login</a>");}

else echo "Error 400 Not Allowed";
$conn->close();
?>
