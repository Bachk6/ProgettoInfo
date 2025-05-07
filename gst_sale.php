<?php
session_start();include("SQLconnect.php");checkUser(array('admin'));
if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["bnt"])){
    if($_POST["bnt"]=="Aggiungi" && isset($_POST["nome_sede"])&& isset($_POST["numero_sala"])){
        $sede = $_POST["nome_sede"];
        $sala = $_POST["numero_sala"];
        $res = $conn->query("SELECT * FROM sale WHERE sediId=$sede AND numeroSala=$sala");
        if($res->num_rows==0){
                $conn->query("INSERT INTO sale (sediId, numeroSala) VALUES ($sede,$sala)");
                echo "<h3>Sala aggiunta con successo</h3>";
        }
        else echo "<h3>Errore: Sala esiste già</h3>";
    }
    else if ($_POST["bnt"]=="Elimina" && isset($_POST["nome_sede"])&& isset($_POST["numero_sala"])){
        $sala = $_POST["numero_sala"];
        $conn->query("DELETE FROM proiezioni WHERE salaId=$sala");
        $conn->query("DELETE FROM sale WHERE salaId=$sala");
        echo "<h3>Cancellazione eseguita!</h3>";
    }
}
?>
<html>
    <head>
        <title>Gestione sale</title>
        <script>
            async function Carica(){
                let sede = document.getElementById("nomesede").value;
                let res = await fetch("getSedeDetails.php?sede="+sede);
                let data = await res.json();
                let str="";
                data.forEach(e => {
                    str+="<option value='"+e["salaId"]+"'>"+e["numeroSala"]+"</option>";
                });
                document.getElementById("numsala").innerHTML=str;
            }
        </script>
    </head>
    <body>
        <h1>Gestione Sale</h1>
        <table>
            <tr>
                <td><h3>Aggiunta Sale</h3></td>
                <td><h3>Eliminazione Sale</h3></td>
            </tr>
            <tr>
                <td>
                    <form method="post" action="">
                        <label for="nome_sede">Nome Sede</label>
                        <select name="nome_sede">
                            <?php
                            $res = $conn->query("SELECT sediId, nomeSede FROM sedi");
                            while($row = $res->fetch_assoc()){
                                $a=$row["sediId"];
                                $b=$row["nomeSede"];
                                echo "<option value='$a'>$b</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="numero_sale">Numero Sale</label>
                        <input type="number" name="numero_sala">
                        <br>
                        <input type="submit" name="bnt" value="Aggiungi">
                    </form>
                </td>
                <td>
                    <form method="post" action="">
                        <label for="nome_sede">Nome Sede</label>
                        <select onchange="Carica()" name="nome_sede" id="nomesede">
                        <?php
                            $res = $conn->query("SELECT sediId, nomeSede FROM sedi");
                            while($row = $res->fetch_assoc()){
                                $a=$row["sediId"];
                                $b=$row["nomeSede"];
                                echo "<option value='$a'>$b</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="numero_sala">Numero Sala</label>
                        <select name="numero_sala" id="numsala"></select>
                        <script>Carica()</script>
                        <br>
                        <input type="submit"  name="bnt" value="Elimina">
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <form action="admin.php">
                        <input type="submit" value="Torna nella dashboard">
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php $conn->close();?>