<?php
    session_start();
    include("SQLconnect.php");
    CheckUser(array('admin','client'));
    $proiez_id = $_GET["proiezioneId"];
    $data_proiez = $conn->query("SELECT giorno FROM proiezioni WHERE proiezioneId=$proiez_id");


    
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
    </head>
    <body>
<?php 
    if($data_proiez > gmdate('Y-m-d')){
        echo "<h3>SALA</h3>";
        $row = 7;
        $col = 7;
        $table = "<table id='table' name='table'>";
        for($i=0; $i<$col; $i++){
            $table.= "<tr>";
            for($j=0; $j<$row; $j++){
                $table.="<td><input type='radio' name='posto' value='$i-$j'></td>";
            }
            $table.="</tr>";
        }
        $table.="</table>";
        echo $table;

        $form = "<form method='post' action=''>";
        $form.= "<button type='submit'>Prenota</button>";
        $form.= "</form>";
        echo $form;
    }
    else
    {
        "<h3>Data del film non compatibile.</h3>";
    }
?>

    </body>
</html>


<?php $conn->close();?>