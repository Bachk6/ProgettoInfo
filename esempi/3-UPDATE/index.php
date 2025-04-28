<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Y";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// ID del record da modificare (puoi modificarlo)
$id_to_update = 2;
$new_text = "Testo modificato";

$sql = "UPDATE foglio SET testo='$new_text' WHERE foglio_id=$id_to_update";

if ($conn->query($sql) == TRUE) {
    echo "Record con ID $id_to_update aggiornato con successo";
} else {
    echo "Errore durante l'aggiornamento: " . $conn->error;
}

$conn->close();
?>