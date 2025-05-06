<?php
include("SQLconnect.php");
$filmId=$_GET["film"];
$res = $conn->query("SELECT * FROM film WHERE filmId = $filmId");
$film = $res->fetch_assoc();
$res2= $conn->query("SELECT attore, personaggio FROM attori WHERE filmId = $filmId LIMIT 3");    
for($i=1;$i<=3;$i++){
    if ($att=$res2->fetch_assoc()){
        $film["a".$i]=$att["attore"];
        $film["p".$i]=$att["personaggio"];
    }
    else break;
}
echo json_encode($film);

?>