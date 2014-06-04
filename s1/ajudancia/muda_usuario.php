<?php
include_once '../../bd/Conexao1.class.php';

session_start();
$saram = $_GET['usuario'];
$usuario = Conexao1::registroUnico("select * from usuario where saram='{$saram}'");
$_SESSION['usuario'] = $usuario;
header("location: ../../index.php");
?>
