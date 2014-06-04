<?php
//importar na página chamadora o arquivo /PHPMailer/class.phpmailer.php

class Sender1{
    
    static function send($msg,$dest){
        $mailer = new PHPMailer();
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
	$mailer = new PHPMailer();
	$mailer->isSMTP();
	$mailer->From = "admin@poseidon.net";
	//$mailer->From = "muskitofile@gmail.com";//deve ser "pinheirowprj@babe.intraer" para funcionar na BABE
	$mailer->FromName = "2S Pinheiro";
	$mailer->Subject = "Poseidon - PGOL";
	$mailer->Host = "smtp.gmail.com";  //deve ser "email.babe.intraer" para funcionar na BABE
	$mailer->SMTPSecure = "ssl";  //deve ser comentada para funcionar na BABE
	$mailer->SMTPAuth = true;   //deve ser comentada para funcionar na BABE
	$mailer->Port = 465;  //deve ser 25 para funcionar na BABE
	$mailer->Username = "muskitofile";  //deve ser "pinheirowprj" para funcionar na BABE
	$mailer->Password = "saraguto1331";  //deve ser "Sa2.Gu4" para funcionar na BABE
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	
//	$mailer = new PHPMailer();
//	$mailer->isSMTP();
//	$mailer->FromName = "Poseidon Gerente On Line";
//	$mailer->Subject = "PGOL - Mensagem Teste";
//	$mailer->Host = "email.babe.intraer";
//      $mailer->Port = 25;
	
	$mailer->AddAddress($dest['email'],$dest['nome']);
	$mailer->MsgHTML($msg);
	return $mailer->Send();
    }
}
?>
