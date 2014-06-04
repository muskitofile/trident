<?php
include_once '../../bd/Conexao1.class.php';

session_start();

$status = $_GET['status'];
$id_msg = $_GET['id_msg'];
$usuario = $_SESSION['usuario'];

Conexao1::execute("update msg_usuario set status=".$status." where mensagem=".$id_msg.
        " and usuario='".$usuario['saram']."'");
//echo Conexao1::direct("select status from msg_usuario where mensagem=".$id_msg);
?>
