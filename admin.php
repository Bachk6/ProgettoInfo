<?php session_start();include("SQLconnect.php");checkUser(array('admin'));?>
<html>
    <head>
        <title>Pagina Admin</title>
        <style>
            button{
                margin-bottom:5px;
            }
        </style>
    </head>
    <body>
        <?php
            echo "<h1>Sei dentro '".$_SESSION["username"]."'!</h1>";
        ?>
        <br>
        <a href="gst_film.php">
            <button>Gestione film</button>
        </a>
        <br>
        <a href="gst_sedi.php">
            <button>Gestione sedi</button>
        </a>
        <br>
        <a href="gst_sale.php">
            <button>Gestione sale</button>
        </a>
        <br>
        <a href="gst_proiezioni.php">
            <button>Gestione proiezioni</button>
        </a>
        <br>
        <a href="login.php">
            <button>Torna al login</button>
        </a>
        <br>
        <a href="user.php">
            <button>Vai alla tua pagina client</button>
        </a>
        </body>
</html>