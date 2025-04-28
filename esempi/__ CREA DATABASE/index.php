<?php
// Configurazione della connessione
$servername = "localhost";
$username = "root";
$password = "";  // Password vuota di default in XAMPP

try {
    // 1. Creazione della connessione al server MySQL
    $conn = new mysqli($servername, $username, $password);
    
    // Verifica se la connessione ha avuto successo
    if ($conn->connect_error) {
        throw new Exception("Connessione fallita: " . $conn->connect_error);
    }
    
    echo "Connessione al server MySQL stabilita con successo!<br>";
    
    // 2. Creazione del database Y
    $sql = "CREATE DATABASE IF NOT EXISTS Y";
    
    if ($conn->query($sql) === TRUE) {
        echo "Database 'Y' creato con successo o già esistente";
    } else {
        throw new Exception("Errore nella creazione del database: " . $conn->error);
    }
    
} catch (Exception $e) {
    echo "Si è verificato un errore: " . $e->getMessage();
} finally {
    // Chiudi la connessione
    if (isset($conn)) {
        $conn->close();
        echo "<br>Connessione chiusa";
    }
}
?>