<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Y";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Query per inserire 5 record di esempio
$sql = "INSERT INTO foglio (testo, riga, colonna, nickName) VALUES 
        ('Primo testo', 1, 1, 'Utente1'),
        ('Secondo testo', 1, 2, 'Utente2'),
        ('Terzo testo', 2, 1, 'Utente3'),
        ('Quarto testo', 2, 2, 'Utente1'),
        ('Quinto testo', 3, 1, 'Utente2')";

if ($conn->query($sql) == TRUE) {
    echo "5 record inseriti con successo";
} else {
    echo "Errore: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>