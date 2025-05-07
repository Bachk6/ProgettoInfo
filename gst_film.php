<?php
    session_start();
    include("SQLconnect.php");
    checkUser(array('admin'));
    //Funzione aggiunta
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["btn"]) && $_POST["btn"] == "Aggiungi"){
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
                echo "<h3>Errore: Attori con quel nome già registrato</h3>";
        }

    //Funzione modifica
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["btn"]) && $_POST["btn"]=="Modifica"){
        $id = $_POST["titolo_film"];
        if(isset($_POST["scrittore_film"]) && $_POST["scrittore_film"] != ""){
            $temp = $_POST["scrittore_film"];
            $conn->query("UPDATE film SET scrittore='$temp' WHERE filmId='$id'");
        }
        if(isset($_POST["regista_film"]) && $_POST["regista_film"] != ""){
            $temp = $_POST["regista_film"];
            $conn->query("UPDATE film SET regista='$temp' WHERE filmId='$id'");
        }
        if(isset($_POST["durata"]) && $_POST["durata"] != ""){
            $temp = $_POST["durata"];
            $conn->query("UPDATE film SET durata='$temp' WHERE filmId='$id'");
        }
        //Cancellazione attori
        $conn->query("DELETE FROM attori WHERE filmId = '$id'");

        //Ri-aggiunta attori
        $act_1 = $_POST["attore_film_1"];
        $act_2 = $_POST["attore_film_2"];
        $act_3 = $_POST["attore_film_3"];
        $pg_1 = $_POST["personaggio_film_1"];
        $pg_2 = $_POST["personaggio_film_2"];
        $pg_3 = $_POST["personaggio_film_3"];

        $conn->query("INSERT INTO attori(filmId, attore, personaggio) VALUES ('$id', '$act_1', '$pg_1'), ('$id', '$act_2', '$pg_2'), ('$id', '$act_3', '$pg_3')");

            echo "<h3>Modifiche applicate</h3>";
    }

    //Funzione elimina
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["btn"]) && $_POST["btn"]=="Elimina"){
        $id = $_POST["titolo_film"];

        //Cancellazione attori
        $sql = "DELETE FROM attori WHERE filmId = '$id'";
        $conn->query($sql);
        //cancellazione proiezioni
        $conn->query("DELETE FROM proiezioni WHERE filmID='$id'");
        //Cancellazione film
        $sql = "DELETE FROM film WHERE filmId = '$id'";
        $conn->query($sql);
        
        echo "<h3>Cancellazione effettuata</h3>";
    }
?>

<html>
    <head>
        <title>Gestione film</title>
        <script>
            async function CaricaFilm(){
                let res = await fetch("getFilmDetails.php?film="+document.getElementById("titolone").value);
                let json = await res.json();
                document.getElementById("regista").value=json["regista"];
                document.getElementById("durata").value=json["durata"];
                document.getElementById("scrittore").value=json["scrittore"];
                document.getElementById("a1").value=json["a1"];
                document.getElementById("a2").value=json["a2"];
                document.getElementById("a3").value=json["a3"];
                document.getElementById("p1").value=json["p1"];
                document.getElementById("p2").value=json["p2"];
                document.getElementById("p3").value=json["p3"];
                console.log(json);
            }
        </script>
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
                    <form method="post" action="gst_film.php">
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
                        <input type="number" name="durata">
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
                        <select name="titolo_film" id="titolone" onchange="CaricaFilm();">
                            <?php
                                $res = $conn->query("SELECT filmId , titolo FROM film");
                                if ($res->num_rows > 0) {
                                    while($row = $res->fetch_assoc()){
                                        echo "<option value='".$row["filmId"]."'>".$row["titolo"]."</option>";
                                    }
                                }
                            ?>
                        </select>
                        <br>
                        <label for="scrittore_film">Scrittore</label>
                        <input id="scrittore" type="text" name="scrittore_film">
                        <br>
                        <label for="regista_film">Regista</label>
                        <input id="regista" type="text" name="regista_film">
                        <br>
                        <label for="durata">Durata(min)</label>
                        <input type="number" name="durata" id="durata">
                        <br>
                        <label>Attore/personaggio</label>
                        <input id="a1" type="text" name="attore_film_1">
                        <input id="p1"type="text" name="personaggio_film_1">
                        <br>
                        <label>Attore/personaggio</label>
                        <input id="a2" type="text" name="attore_film_2">
                        <input id="p2"type="text" name="personaggio_film_2">
                        <br>
                        <label>Attore/personaggio</label>
                        <input id="a3" type="text" name="attore_film_3">
                        <input id="p3" type="text" name="personaggio_film_3">
                        <br>
                        <input type="submit" name="btn" value="Modifica">
                        <script>CaricaFilm()</script>
                    </form>
                </td>
                <td>
                    <form method="post" action="">
                        <label for="titolo_film">Titolo</label>
                        <select name="titolo_film">
                            <?php
                                $res = $conn->query("SELECT filmId, titolo FROM film");
                                if ($res->num_rows > 0) {
                                    while($row = $res->fetch_assoc()){
                                        echo "<option value='".$row["filmId"]."'>".$row["titolo"]."</option>";
                                    }
                                }
                            ?>
                        </select>
                        <br>
                        <input type="submit" name="btn" value="Elimina">
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="admin.php">
                        <button>Torna alla dashboard</button>
                    </a>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php $conn->close();?>