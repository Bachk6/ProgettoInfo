<?php
    session_start();
    //Funzione aggiunta
    if($_POST["btn"] == "Aggiungi"){
        include("SQLconnect.php");
        if ($_SERVER["REQUEST_METHOD"]=="POST"){
            if(isset($_POST["titolo_film"]) && isset($_POST["scrittore_film"]) && isset($_POST["regista_film"])
            && isset($_POST["durata"]) && $_POST["titolo_film"] != "" && $_POST["scrittore_film"] != "" 
            && $_POST["regista_film"] != "" && $_POST["durata"] != ""){
                //controllo titolo
                $res = $conn->query("SELECT titolo FROM film");
                $flag = false;
                if($res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        if($row["titolo"] == $_POST["titolo_film"]){
                            $flag = true;
                            break;
                        }
                    }
                }
                if(!$flag){
                    //aggiungi film
                    $titl = $_POST["titolo_film"];
                    $wrtr = $_POST["scrittore_film"];
                    $rgst = $_POST["regista_film"];
                    $drt = intval($_POST["durata"]);
                    $sql = "INSERT INTO film(titolo, scrittore, regista, durata) VALUES
                        ('$titl','$wrtr','$rgst','$drt')";
                    if ($conn->query($sql) == TRUE) {
                        echo "<h3>Film inserito con successo!</h3>";
                    } else {
                        echo "<h3>Errore: " . $sql . "<br>" . $conn->error . "</h3>";
                    }
                }
                else{
                    echo "<h3>Errore: Film con quel titolo già registrato</h3>";
                }
                
            }
            //aggiunta attori e personaggi
            if(isset($_POST["attore_film_1"]) && isset($_POST["attore_film_2"]) && isset($_POST["attore_film_3"])
            && isset($_POST["personaggio_film_1"]) && isset($_POST["personaggio_film_2"]) && isset($_POST["personaggio_film_3"])
            && $_POST["attore_film_1"] != "" && $_POST["attore_film_2"] != "" && $_POST["attore_film_3"] != ""
            && $_POST["personaggio_film_1"] != "" && $_POST["personaggio_film_2"] != "" && $_POST["personaggio_film_3"] != ""){
                //ottenimento film id
                $titl = $_POST["titolo_film"];
                $res = $conn->query("SELECT filmId FROM film WHERE titolo='$titl'");
                $tmp = $res->fetch_assoc();
                $id = $tmp["filmId"];
                //controllo film id
                $res = $conn->query("SELECT filmId FROM attori");
                $flag = false;
                if($res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        if($row["filmId"] == $id){
                            $flag = true;
                            break;
                        }
                    }
                }
                //registrazione
                if(!$flag){
                    $act_1 = $_POST["attore_film_1"];
                    $act_2 = $_POST["attore_film_2"];
                    $act_3 = $_POST["attore_film_3"];
                    $pg_1 = $_POST["personaggio_film_1"];
                    $pg_2 = $_POST["personaggio_film_2"];
                    $pg_3 = $_POST["personaggio_film_3"];
                    $sql = "INSERT INTO attori(filmId, attore, personaggio) VALUES ('$id', '$act_1', '$pg_1'), ('$id', '$act_2', '$pg_2'), ('$id', '$act_3', '$pg_3')";
                    $conn->query($sql);
                }
                else
                    echo "<h3>Errore: Attori con quel titolo già registrato</h3>";
            }
        }
        $conn->close();
    }

    //Funzione modifica
    if($_POST["btn"]=="Modifica"){
        include("SQLconnection.php");

        $conn->close();
    }
?>

<html>
    <head>
        <title>Gestione film</title>
    </head>
    <body>
        <h1> Gestione Film </h1>
        <br>
        <table>
            <tr>
                <td><h3>Aggiunta Film</h3></td>
                <td><h3>Modifica Film</h3></td>
                <td><h3>Eliminazione Film</h3></td>
            </tr>
            <tr>
                <td>
                    <form method="post" action="">
                        <label for="titolo_film">Titolo</label>
                        <input type="text" name="titolo_film">
                        <br>
                        <label for="scrittore_film">Scrittore</label>
                        <input type="text" name="scrittore_film">
                        <br>
                        <label for="regista_film">Regista</label>
                        <input type="text" name="regista_film">
                        <br>
                        <label for="durata">Durata(min)</label>
                        <input type="text" name="durata">
                        <br>
                        <label>Attore/personaggio</label>
                        <input type="text" name="attore_film_1">
                        <input type="text" name="personaggio_film_1">
                        <br>
                        <label>Attore/personaggio</label>
                        <input type="text" name="attore_film_2">
                        <input type="text" name="personaggio_film_2">
                        <br>
                        <label>Attore/personaggio</label>
                        <input type="text" name="attore_film_3">
                        <input type="text" name="personaggio_film_3">
                        <br>
                        <input type="submit" name="btn" value="Aggiungi">
                    </form>
                </td>
                <td>
                    <form method="post" action="">
                        <label for="titolo_film">Titolo</label>
                        <select name="titolo_film" >
                            <?php
                                include("SQLconnect.php");
                                $res = $conn->query("SELECT titolo FROM film");
                                if ($res->num_rows > 0) {
                                    while($row = $res->fetch_assoc()){
                                        echo "<option value='".$row["titolo"]."'>".$row["titolo"]."</option>";
                                    }
                                }
                                $conn->close();
                            ?>
                        </select>
                        <br>
                        <label for="scrittore_film">Scrittore</label>
                        <input type="text" name="scrittore_film">
                        <br>
                        <label for="regista_film">Regista</label>
                        <input type="text" name="regista_film">
                        <br>
                        <label>Attore/personaggio</label>
                        <input type="text" name="attore_film_1">
                        <input type="text" name="personaggio_film_1">
                        <br>
                        <label>Attore/personaggio</label>
                        <input type="text" name="attore_film_2">
                        <input type="text" name="personaggio_film_2">
                        <br>
                        <label>Attore/personaggio</label>
                        <input type="text" name="attore_film_3">
                        <input type="text" name="personaggio_film_3">
                        <br>
                        <input type="submit" name="btn" value="Modifica">
                    </form>
                </td>
                <td>
                    <form method="post" action="">
                        <label for="titolo_film">Titolo</label>
                        <select name="titolo_film" >
                            <?php
                                include("SQLconnect.php");
                                $res = $conn->query("SELECT titolo FROM film");
                                if ($res->num_rows > 0) {
                                    while($row = $res->fetch_assoc()){
                                        echo "<option value='".$row["titolo"]."'>".$row["titolo"]."</option>";
                                    }
                                }
                                $conn->close();
                            ?>
                        </select>
                        <br>
                        <input type="submit" name="btn" value="Elimina">
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>