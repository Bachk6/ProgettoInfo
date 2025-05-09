<?php
session_start();
include("SQLconnect.php");
CheckUser(array('admin','client'));
?>
<html>
    <head>
        <title>Cerca Film</title>
    </head>
    <body>
        <center>
        <h1>Cerca Film</h1>
        <form action="" method="POST">
            <label for="datainizio">Data inizio</label>
            <input type="date" name="datainizio">
            <br>
            <label for="datafine">Data fine</label>
            <input type="date" name="datafine">
            <br>
            <label for="film">Film</label>
            <select name="film">
                <option value="-1">Qualsiasi</option>
                <?php
                $res = $conn->query("SELECT filmId, titolo FROM film ORDER BY titolo");
                while($row=$res->fetch_assoc()){
                    $v = $row["filmId"];
                    $n = $row["titolo"];
                    echo "<option value='$v'>$n</option>";
                }
                ?>
            </select>
            <br>
            <label for="sede">Sede</label>
            <select name="sede">
                <option value="-1">Qualsiasi</option>
                <?php
                $res = $conn->query("SELECT sediId, nomeSede FROM sedi ORDER BY nomeSede");
                while($row=$res->fetch_assoc()){
                    $v = $row["sediId"];
                    $n = $row["nomeSede"];
                    echo "<option value='$v'>$n</option>";
                }
                ?>
            </select>
            <br>
            <br>
            <input type="submit" value="CERCA">
        </form>
        </center>
        <br>
        <?php
            if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["datainizio"])
            && isset($_POST["datafine"]) && isset($_POST["film"]) && isset($_POST["sede"])){
                if ($_POST["sede"]!="-1" && $_POST["film"]=="-1"){
                    $x = $_POST['sede'];
                    $start= $_POST["datainizio"];
                    $fin = $_POST["datafine"];
                    $res=$conn->query("
                    SELECT proiezioneId, giorno, orainizio, numeroSala, titolo FROM
                    film NATURAL JOIN proiezioni NATURAL JOIN sale NATURAL join sedi
                    WHERE sediId=$x AND giorno >= '$start' AND giorno <= '$fin' ORDER BY titolo;
                    ");
                    $ex="-1AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
                    echo "<h2>Proiezioni Trovate:</h2>";
                    while($row=$res->fetch_assoc()){
                        $t = $row["titolo"];
                        if ($t!=$ex){
                            echo "<h3>$t:</h3>";
                            $ex=$t;
                        }
                        $sala=$row["numeroSala"];
                        $g = $row["giorno"];
                        $init= $row["orainizio"];
                        $id = $row["proiezioneId"];
                        echo "<h4>SALA N $sala, Il $g, ore $init</h4>";
                        echo "<a href='gst_prenotazioni.php?proiezioneId=$id'><button>Prenota Ora</button></a>";
                    }
                }
                else if ($_POST["sede"]=="-1" && $_POST["film"]!="-1"){
                    $x=$_POST["film"];
                    $start= $_POST["datainizio"];
                    $fin = $_POST["datafine"];
                    echo "<h2>Proiezioni trovate: </h2>";
                    $res=$conn->query("SELECT proiezioneId, giorno, orainizio, numeroSala, nomeSede FROM
                    film NATURAL JOIN proiezioni NATURAL JOIN sale NATURAL join sedi
                    WHERE filmId=$x AND giorno >= '$start' AND giorno <= '$fin' ORDER BY nomeSede;
                    ");
                    $ex="APPARENETEMENTENONLOSOPLACEHOLDERCARINISSIMISSIMISSIMOSISISISISISISSISISISISISISISISISISISISISISISISISISISISISISSI";
                    while($row=$res->fetch_assoc()){
                        $s=$row["nomeSede"];
                        $sala=$row["numeroSala"];
                        $g = $row["giorno"];
                        $init= $row["orainizio"];
                        $id = $row["proiezioneId"];
                        if($row["nomeSede"]!=$ex){
                            echo "<h3>$s</h3>";
                            $ex=$s;
                        }
                        echo "<h4>SALA N $sala, Il $g, ore $init</h4>";
                        echo "<a href='gst_prenotazioni.php?proiezioneId=$id'><button>Prenota Ora</button></a>";

                    }
                }
                else if ($_POST["sede"]!="-1" && $_POST["film"]!="-1"){
                    echo "caso3";
                }
                else echo "<h3>FAI ALMENO UNA SCELTA</h3>";
            }
        ?>
    </body>
</html>
<?php $conn->close();?>