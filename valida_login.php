<?php
include_once '../db/Conexao.class.php';

session_start();

$saram = $_POST['saram'];
$senha = $_POST['senha'];

if($user = Conexao::registroUnico("select * from usuario where saram='".
		$saram."' and senha=password('".$senha."')")){
        $_SESSION['usuario'] = $user; 
        $_SESSION['logado'] = $user; // detém os dados do usuário que está se logando
//	foreach($user as $index=>$value){
//		$_SESSION[$index] = $value;
//	}
//	$_SESSION['userId'] = $user['saram'];
	header("location: index.php");
}
else{
	$_SESSION['msg_login'] = "Saram ou senha errados!";
	header("location: login.php");
}
?>