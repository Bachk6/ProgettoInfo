<?php
    session_start();
    include("SQLconnect.php");
    checkUser(array('admin'));

    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["btn"])){
        if($_POST["btn"] == "Aggiungi" && isset($_POST["data"]) && $_POST["data"] != null){
            $sala_id = $_POST["sale"];
            $ora = $_POST["ora_init"];
            $data = $_POST["data"];
            $film_id = $_POST["film"];
            $conn->query("INSERT INTO proiezioni(salaId, oraInizio, giorno, filmId) VALUE ($sala_id, $ora, '$data', $film_id)");
        
            echo "<h3>Proiezione aggiunta!</h3>";
        }
        if($_POST["btn"]  == "Modifica"){
            $proiez_id = $_POST["proiezioni"];
            
            $film_id = $_POST["film"];
            $ora = $_POST["ora_init"];
            $data = $_POST["data"];
            $conn->query("UPDATE proiezioni SET filmId = $film_id, oraInizio = $ora, giorno = '$data' WHERE proiezioneId = $proiez_id");

            echo "<h3>Proiezione aggiornata</h3>"; 
        }
        if ($_POST["btn"]=="Elimina" && isset($_POST["proiezioni"])){
            $pId = $_POST["proiezioni"];
            $conn->query("DELETE FROM proiezioni WHERE proiezioneId = $pId");
        }
    }
?>
<html>
    <head>
        <title>Gestione Proiezioni</title>
        <script>
            async function CaricaSede(idSede,idSala){
                let sede = document.getElementById(idSede).value;
                let res = await fetch("getSedeDetails.php?sede="+sede);
                let data = await res.json();
                let str="";
                data.forEach(e => {
                    str+="<option value='"+e["salaId"]+"'>"+e["numeroSala"]+"</option>";
                });
                document.getElementById(idSala).innerHTML=str;
            }

            async function CaricaPro(idsala,idpro){
                let sede = document.getElementById(idsala).value;
                let res = await fetch("getSalaDetails.php?sala="+sede);
                let data = await res.json();
                let str="";
                data.forEach(
                    e=>{str+="<option value='"+e["proiezioneId"]+"'>"+e["titolo"]+", sala N "+e["numeroSala"]+", "+e["nomeSede"]+", il "+e["giorno"]+"</option>";}
                );
                document.getElementById(idpro).innerHTML=str;
                CaricaPro2();
            }

            async function CaricaPro2(){
                let coso = document.getElementById("pro2").value;
                let res = await fetch("getProiezioneDetails.php?pro="+coso);
                let data = await res.json();
                document.getElementById("film").value=data["filmID"];
                document.getElementById("giorno").value=data["giorno"];
                document.getElementById("orainizio").value=data["orainizio"]
            }
                
    
        </script>
    </head>
    <body>
        <h1> Gestione Proiezioni </h1>
        <br>
        <table>
            <tr>
                <td><h3>Aggiunta Proiezione</h3></td>
                <td><h3>Modifica Proiezione</h3></td>
                <td><h3>Eliminazione Proiezione</h3></td>
            </tr>
            <tr>
                <td>
                    <form method="post" action="">
                        <label for="sedi">Sede</label>
                        <select onchange="CaricaSede('sede1','sala1')" id="sede1" name="sedi">
                        <?php
                            $res = $conn->query("SELECT sediId, nomeSede FROM sedi");
                            while($row = $res->fetch_assoc()){
                                $a=$row["sediId"];
                                $b=$row["nomeSede"];
                                echo "<option value='$a'>$b</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="sale">Sala</label>
                        <select name="sale" id="sala1"></select>
                        <script>CaricaSede('sede1','sala1')</script>
                        <br>
                        <label for="film">Film</label>
                        <select name="film">
                        <?php
                            $res = $conn->query("SELECT filmId, titolo FROM film");
                            while($row=$res->fetch_assoc()){
                                $id= $row["filmId"];
                                $t= $row["titolo"];
                                echo "<option value='$id'>$t</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="ora_init">Ora Inizio</label>
                        <select name="ora_init">
                            <option>8</option>
                            <option>10</option>
                            <option>16</option>
                            <option>18</option>
                            <option>20</option>
                        </select>
                        <br>
                        <label for="data">Data</label>
                        <input type="date" name="data">
                        <br>
                        <input name = "btn" type="submit" value="Aggiungi">
                    </form>
                </td>
                <td>
                    <form method="post" action="">
                        <label for="sedi">Sede</label>
                        <select  name="sedi" id="sede2" onchange="CaricaSede('sede2','sala2')">
                        <?php
                            $res = $conn->query("SELECT sediId, nomeSede FROM sedi");
                            while($row = $res->fetch_assoc()){
                                $a=$row["sediId"];
                                $b=$row["nomeSede"];
                                echo "<option value='$a'>$b</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="sale">Sala</label>
                        <select name="sale" id="sala2" onchange="CaricaPro('sala2','pro2')"></select>
                        <br>
                        <label for="proiezioni">Proiezione</label>
                        <select name="proiezioni" id="pro2" onchange="CaricaPro2()"></select>
                        <script>CaricaSede('sede2','sala2')</script>
                        <br>
                        <label for="film">Film</label>
                        <select name="film" id="film">
                            <?php
                            $res = $conn->query("SELECT filmId, titolo FROM film");
                            while($row=$res->fetch_assoc()){
                                $id= $row["filmId"];
                                $t= $row["titolo"];
                                echo "<option value='$id'>$t</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="ora_init">Ora Inizio</label>
                        <select name="ora_init" id="orainizio">
                            <option>8</option>
                            <option>10</option>
                            <option>16</option>
                            <option>18</option>
                            <option>20</option>
                        </select>
                        <br>
                        <label for="data">Data</label>
                        <input type="date" name="data" id="giorno">
                        <br>
                        <input name="btn" type="submit" value="Modifica">
                    </form>
                </td>
                <td>
                    <form method="post" action="">
                    <label for="sedi">Sede</label>
                        <select  name="sedi" id="sede3" onchange="CaricaSede('sede3','sala3')">
                        <?php
                            $res = $conn->query("SELECT sediId, nomeSede FROM sedi");
                            while($row = $res->fetch_assoc()){
                                $a=$row["sediId"];
                                $b=$row["nomeSede"];
                                echo "<option value='$a'>$b</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="sale">Sala</label>
                        <select name="sale" id="sala3" onchange="CaricaPro('sala3','pro3')"></select>
                        <script>CaricaSede('sede3','sala3')</script>
                        <br>
                        <label for="proiezioni" >Proiezione</label>
                        <select name="proiezioni" id="pro3"></select>
                        <br>
                        <input name="btn" type="submit" value="Elimina">
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <form action="admin.php">
                        <input type="submit" value="Torna alla dashboard">
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>