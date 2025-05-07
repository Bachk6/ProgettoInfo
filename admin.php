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
        <form action="gst_film.php">
            <button type="submit">Gestione film</button>
        </form>
        <form action="gst_sedi.php">
            <button type="submit">Gestione sedi</button>
        </form>
        <form action="gst_sale.php">
            <button type="submit">Gestione sale</button>
        </form>
        <form action="gst_proiezioni.php">
            <button type="submit">Gestione proiezioni</button>
        </form>
        <form action="login.php">
            <button type="submit">Torna al login</button>
        </form>
        
        <a href="user.php">
            <button>Vai alla tua pagina client</button>
        </a>
        </body>
</html>