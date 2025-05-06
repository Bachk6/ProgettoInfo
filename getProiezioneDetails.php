<?php
include("SQLconnect.php");
$filmId=$_GET["pro"];
$res = $conn->query("SELECT proiezioni.filmID,  proiezioni.giorno, proiezioni.orainizio FROM proiezioni WHERE proiezioneId = $filmId");
echo json_encode($res->fetch_assoc());

?>