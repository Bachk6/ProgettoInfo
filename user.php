<?php 
session_start();
include("SQLconnect.php");
CheckUser(array('admin','client'));
?>
<html>
    <head>
        <title>User - <?php echo $_SESSION["username"]?></title>
    </head>
    <body>
        <h1>Utente - <?php echo $_SESSION["username"]?></h1>
        <a href="cerca.php">Esplora</a>
        <h3>Le mie Prenotazioni</h3>
        <form action="">
            <select name = "prenota">
                <?php
                $u = $_SESSION["username"];
                $res = $conn->query("SELECT * FROM utenti NATURAL JOIN prenotazioni NATURAL JOIN proiezioni NATURAL JOIN film NATURAL JOIN sale NATURAL JOIN sedi WHERE utenti.username='$u' AND proiezioni.giorno >= CURDATE()");
                while($row=$res->fetch_assoc()){
                    $id= $row["prenotazioneId"];
                    $g = $row["giorno"];
                    $film = $row["titolo"];
                    $sala = $row["numeroSala"];
                    $sede = $row["nomeSede"];
                    $x = $row["postoX"];
                    $y = $row["postoY"];
                    echo "<option value='$id'>
                    $film, Sala $sala, $sede, posto $x-$y il giorno $g
                    </option>";
                }
                ?>
            </select>
            <input type="submit" value="Elimina">
        </form>
        <a href="login.php">
            Torna al Login
        </a>
    </body>
</html>