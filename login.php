<?php

//if (empty($_SERVER['HTTPS'])) {
//    header("location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
//}
session_start();
if (isset($_SESSION['login']))
    $login = $_SESSION['login'];
if (isset($_SESSION['senha']))
    $senha = $_SESSION['senha'];

echo "<html>\n";
echo "<head>\n";
echo "<title>Poseidon</title>\n";
echo "<link rel=\"shortcut icon\" href=\"icone.ico\" >\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' height='100%' border='0'>";
echo "<tr><td align='center' valign='center' height='60%'>";
echo "<img src='netuno.png'/>";
echo "</td></tr>";
echo "<tr><td align='center' valign='top'>";
echo "<form action='valida_login.php' method='post'>\n";
echo "<table border='0'>\n";
echo "<tr><td align='right'>Saram:</td><td><input type='text' name='saram' autofocus id='login'></td></tr>\n";
echo "<tr><td align='right'>Senha:</td><td><input type='password' name='senha'></td></tr>\n";
echo "<tr><td colspan='2' align='right'><input type='submit' value='Enviar'></td></tr>\n";
echo "<tr><td colspan='2' style='color: red'>";
if (isset($_SESSION['msg_login']))
    echo $_SESSION['msg_login'];
echo "</td></tr>";
?>
<tr><td colspan="2" align="right"><a href="s1/ajudancia/dados_pessoais/novo_usuario.php">Registre-se</a></td></tr>
<?php
session_destroy();
echo "</table>\n";
echo "</form>\n";
echo "</table>";
echo "</body>\n";
echo "</html>\n";
?>
