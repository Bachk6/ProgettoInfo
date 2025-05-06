<?php
include("SQLconnect.php");
$filmId=$_GET["sede"];
$res = $conn->query("SELECT salaId, numeroSala FROM sale WHERE sediId = $filmId");
$fine = array();
while($row=$res->fetch_assoc()){
    $fine[]=$row;
}
echo json_encode($fine);

?>