<?php session_start();include("SQLconnect.php");checkUser(array('admin'));?>
<html>
    <head>
        <title>Pagina Admin</title>
    </head>
    <body>
        <?php
            echo "<h1>Sei dentro '".$_SESSION["username"]."'!</h1>";
        ?>
        <br>
        <a href="gst_film.php">
            <button>Gestione film</button>
        </a>
        <a href="gst_sedi.php">
            <button>Gestione sedi</button>
        </a>
        <a href="gst_sale.php">
            <button>Gestione sale</button>
        </a>
        <a href="gst_proiezioni.php">
            <button>Gestione proiezioni</button>
        </a>
        <a href="login.php">
            <button>Torna al login</button>
        </a>
        </body>
</html>