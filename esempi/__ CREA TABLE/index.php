<?php
// Configurazione della connessione
$servername = "localhost";
$username = "root";
$password = "";  // Password vuota di default in XAMPP
$dbname = "Y";   // Nome del database

try {
    // 1. Creazione della connessione al database Y
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verifica se la connessione ha avuto successo
    if ($conn->connect_error) {
        throw new Exception("Connessione fallita: " . $conn->connect_error);
    }
    
    echo "Connessione al database 'Y' stabilita con successo!<br>";
    
    // 2. Creazione della tabella foglio
    $CreaTable = "CREATE TABLE IF NOT EXISTS foglio (
        foglio_id INT AUTO_INCREMENT,
        testo VARCHAR(255),
        riga INT,
        colonna INT,
        nickName VARCHAR(255), 
        PRIMARY KEY (foglio_id)
    )";
    
    if ($conn->query($CreaTable) == TRUE) {
        echo "Tabella 'foglio' creata con successo o già esistente";
    } else {
        throw new Exception("Errore nella creazione della tabella: " . $conn->error);
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