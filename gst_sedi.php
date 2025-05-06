<?php
session_start();include("SQLconnect.php");checkUser(array('admin'));
if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["btn"])){
    if ($_POST["btn"]=="Aggiungi" && isset($_POST["nome_sede"]) && $_POST["nome_sede"]!=""){
        $nome=$_POST["nome_sede"];
        $res = $conn->query("SELECT nomeSede from sedi WHERE nomeSede='$nome'");
        if ($res->num_rows==0){
            $conn->query("INSERT into sedi (nomeSede) VALUES ('$nome')");
            echo "<h3>Sede aggiunta con successo!</h3>";
        }
        else echo "<h3>Errore: Sede esiste già</h3>";
    }
    else if ($_POST["btn"]=="Elimina"){
        $id = $_POST["nome_sede"];
        //Cancella proiezioni della sede
        $conn->query("DELETE FROM proiezioni WHERE salaId IN (SELECT salaId FROM sale WHERE sediId='$id')");
        //Cancella sale della sede
        $conn->query("DELETE FROM sale WHERE sediId='$id'");
        //Cancella sede
        $conn->query("DELETE FROM sedi WHERE sediId='$id'");

        echo "<h3>Sede eliminata con successo</h3>";
    }
}
?>
<html>
    <head>
        <title>Gestione sedi</title>
    </head>
    <body>
        <h1>Gestione Sedi</h1>
        <table>
            <tr>
                <td><h3>Aggiunta Sede</h3></td>
                <td><h3>Eliminazione Sede</h3></td>
            </tr>
            <tr>
                <td>
                    <form method="post" action="">
                        <label for="nome_sede">Nome Sede</label>
                        <input type="text" name="nome_sede">
                        <br>
                        <input type="submit" name="btn" value="Aggiungi">
                    </form>
                </td>
                <td>
                    <form method="post" action="">
                        <label for="nome_sede">Nome Sede</label>
                        <select name="nome_sede">
                            <?php
                            $res2= $conn->query("SELECT sediId, nomeSede FROM sedi");
                            while($row=$res2->fetch_assoc()){
                                $a=$row["sediId"];
                                $b=$row["nomeSede"];
                                echo "<option value='$a'>$b</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <input type="submit" name = "btn" value="Elimina">
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php $conn->close()?>