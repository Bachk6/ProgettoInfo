<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Y";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "SELECT foglio_id, testo, riga, colonna, nickName FROM foglio";
$result = $conn->query($sql);

echo "<h2>Contenuto della tabella foglio</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Testo</th>
            <th>Riga</th>
            <th>Colonna</th>
            <th>Nickname</th>
        </tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["foglio_id"]."</td>
                <td>".$row["testo"]."</td>
                <td>".$row["riga"]."</td>
                <td>".$row["colonna"]."</td>
                <td>".$row["nickName"]."</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Nessun record trovato</td></tr>";
}
echo "</table>";

$conn->close();
?>