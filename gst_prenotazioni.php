<?php
    session_start();
    include("SQLconnect.php");
    CheckUser(array('admin','client'));
    $proiez_id = $_GET["proiezioneId"];
    $username = $_SESSION["username"];
    $utente = $conn->query("SELECT utenteId FROM utenti WHERE username = '$username'");
    while($row = $utente->fetch_assoc()){
        $utente_id = $row["utenteId"];
    }
    $data_proiez = $conn->query("SELECT giorno FROM proiezioni WHERE proiezioneId=$proiez_id");
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn"])){
        $posto = $_POST["posto"];
        $arr_posto = explode("-", $posto);
        $postoX = $arr_posto[1];
        $postoY = $arr_posto[0];
        
        if($conn->query("INSERT INTO prenotazioni(proiezioneId, utenteId, postoX, postoY) VALUE ($proiez_id, $utente_id, $postoX, $postoY)"))
            echo "<h3>Prenotazione aggiunta!</h3>";
        else
            echo "Error prenotazione";
    }

    
    //gst_prenotazioni?proiezioneid=3
    //uscire se data proiezione è <= oggi
    //Creare e mostrare posti "Checkbox" con table-> php
    //Mostrare posti liberi con verde e posti occupate con rosso
    //I posti occupati non possono cambiare
    //Mostra dati proiezione

?>
<html>
    <head>
        <title>Prenotazioni</title>
        <style>
            .red{
                background-color:#ef251b;
            }
            .green{
                background-color:#278f2c;
            }
            td{
                padding:5px;
            }
            input{
                margin:0px;
            }
        </style>
    </head>
    <body>
<?php 
    if($data_proiez > gmdate('Y-m-d')){
        echo "<h3>SALA</h3>";
        $title = $conn->query("SELECT giorno, numeroSala, nomeSede, titolo FROM proiezioni NATURAL JOIN film NATURAL JOIN sale NATURAL JOIN sedi WHERE proiezioneId=$proiez_id");
        while($row = $title->fetch_assoc()){
            echo "GIORNO:".$row["giorno"]."<br>"."SEDE:".$row["nomeSede"]."<br>"."SALA:".$row["numeroSala"]."<br>"."TITOLO:".$row["titolo"]."<br>";
        }
        $posti_disabled = $conn->query("SELECT postoX, postoY FROM prenotazioni WHERE proiezioneId = $proiez_id");
        $row = 7;
        $col = 7;
        $arr=array();
        while($r = $posti_disabled->fetch_assoc()){
            $arr[] = $r;
        }
        $table = "<table id='table' name='table'>";
        while($data = $posti_disabled->fetch_assoc()) $arr[]=$data;
        for($i=0; $i<$col; $i++){
            $table.= "<tr>";
            for($j=0; $j<$row; $j++){
                $flag=false;
                for($rw = 0; $rw<count($arr); $rw++){
                    if($arr[$rw]["postoY"] == $i && $arr[$rw]["postoX"] == $j)
                        $flag=true;
                }
                $table.="<td ";
                if ($flag)
                    $table.="class='red'";
                else $table.="class='green'";
                $table.="><input type='radio' name='posto' value='$i-$j'";
                if ($flag)
                    $table.=" disabled";
                $table.="></td>";
            }
            $table.="</tr>";
        }
        $table.="</table>";

        $form = "<form method='POST' action=''>";
        $form.= $table;
        $form.= "<button name='btn' type='submit'>Prenota</button>";
        $form.= "</form>";
        echo $form;
    }
    else
    {
        "<h3>Data del film non compatibile.</h3>";
    }
?>  <br><br>
    <a href="user.php"><button>Torna alla dashboard</button></a>
    </body>
</html>


<?php $conn->close();?>