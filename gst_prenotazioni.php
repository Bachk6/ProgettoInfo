<?php
    session_start();
    include("SQLconnect.php");
    CheckUser(array('admin','client'));
    $proiez_id = $_GET["proiezioneId"];
    $data_proiez = $conn->query("SELECT giorno FROM proiezioni WHERE proiezioniId=$proiez_id");
    
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
        <p><?php echo "Proiezione ID: ".$proiez_id ?></p>
    </body>
</html>


<?php $conn->close();?>