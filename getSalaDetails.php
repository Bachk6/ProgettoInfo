<?php
include("SQLconnect.php");
$filmId=$_GET["sala"];
$res = $conn->query("SELECT film.titolo, proiezioni.proiezioneId, proiezioni.giorno, sale.numeroSala, sedi.nomeSede FROM film NATURAL JOIN proiezioni NATURAL JOIN sale NATURAL JOIN sedi  WHERE salaId = $filmId");
$fine = array();
while($row=$res->fetch_assoc()){
    $fine[]=$row;
}
echo json_encode($fine);

?>