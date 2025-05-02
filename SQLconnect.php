<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cinema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

function checkUser($permessi){
    global $conn;
    if (! isset($_SESSION["username"])){
        echo "<script>window.location= 'login.php'</script>";
        die();
    }
    else{
        $u = $_SESSION["username"];
        $res = $conn->query("SELECT permessi FROM utenti where username='$u'");
        if ($res->num_rows !=1 || !in_array($res->fetch_assoc()["permessi"],$permessi)){
            echo "<script>window.location= 'login.php'</script>";
            die();
        }
    
}
}
?>