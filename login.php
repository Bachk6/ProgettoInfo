<html>
    <head>
        <title> Login </title>
    </head>
        <table >
            <tr>
                <td><h1>LOGIN</h1></td>
                <td><h1>REGISTRAZIONE</h1></td>
            </tr>
            <tr>
                <td>
                    <form method="post" action="signin.php">
                        <label for="username">username</label>
                        <input type="text" name="username">
                        <br>
                        <label for="password">password</label>
                        <input type="password" name="password">
                        <br>
                        <input type="submit" value="Login">
                    </form>
                </td>
                <td>
                    <form method="post" action="signup.php">
                        <label for="username">username</label>
                        <input type="text" name="username">
                        <br>
                        <label for="password">password</label>
                        <input type="password" name="password">
                        <br>
                        <input type="submit" value="Signup">
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>