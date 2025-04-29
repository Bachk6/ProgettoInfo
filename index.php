<?php

include("SQLconnect.php");

$res = $conn->query("SELECT * from sedi");

while($row = $res->fetch_assoc()){
    print_r($row);echo ("<br>");
}

?>

<a href="login.php">Login</a>