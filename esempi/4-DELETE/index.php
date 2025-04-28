<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Y";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// ID del record da eliminare (puoi modificarlo)
$id_to_delete = 3;

$sql = "DELETE FROM foglio WHERE foglio_id = $id_to_delete";

if ($conn->query($sql) == TRUE) {
    echo "Record con ID $id_to_delete eliminato con successo";
} else {
    echo "Errore durante l'eliminazione: " . $conn->error;
}

$conn->close();
?>