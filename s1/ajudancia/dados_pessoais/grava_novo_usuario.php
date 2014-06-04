<?php
include_once '../../bd/Conexao1.class.php';
include_once '../../email/Sender.class.php';
include_once '../../../PHPMailer/class.phpmailer.php';

session_start();
$vetor = array("0","1","2","3","4","5","6","7","8","9",
        "a","b","c","d","e","f","g","h","i","j","k","l",
        "m","n","o","p","q","r","s","t","u","v","w","x","y","z");

$opcao = $_GET['opcao'];
$nome = $_GET['nome'];
$saram = $_GET['saram'];
$email = $_GET['email'];
$posto = $_GET['posto'];
$quadro = $_GET['quadro'];

if($opcao=="Concluir"){
    $maiusculas = 0;
    $senha = "";
    for($i=0;$i<7;$i++){
        $maiusculas = rand(0,1);
        if($maiusculas==0) $senha .= $vetor[rand(0,35)];
        else $senha .= strtoupper($vetor[rand(0,35)]);
    }

    $_SESSION['novo_usuario_nome'] = $nome;
    $_SESSION['novo_usuario_saram'] = $saram;
    $_SESSION['novo_usuario_posto'] = $posto;
    $_SESSION['novo_usuario_quadro'] = $quadro;
    $_SESSION['novo_usuario_email'] = $email;

    $result = Conexao1::registroUnico("select * from email where usuario='{$saram}' or email='{$email}'");
    echo sizeof($result);
    echo $result;
    if(isset($result) and sizeof($result)>0){
        $_SESSION['msg_novo_usuario_saram'] = "O SARAM e/ou o EMAIL que você forneceu já estão cadastrados. ".
                                           "Verifique se você recebeu um email em <u>{$email}</u> com sua senha ou ".
                                           "consulte sua conta junto ao administrador do sistema.";
        header("location: novo_usuario.php");
    }
    else{
        if(Sender1::send ("Senha: ".$senha, array("email"=>"pinheirowprj@babe.intraer","nome"=>"{$posto} {$nome}"))){
            if(Conexao1::execute("call novo_usuario('{$nome}','{$saram}','{$posto}',".
                                                "'{$quadro}','{$senha}','{$email}')")){
                header("location: novo_usuario_ok.php?novo_usuario={$posto} {$nome}");
            }
            else{
                $_SESSION['msg_novo_usuario_saram'] = "Erro no BD";
                header("location: novo_usuario.php");
            }
        }
        else{
            $_SESSION['msg_novo_usuario_email'] = "O email que você forneceu não passou no teste do sistema. ".
                                            "Por favor, informe outro email.";
            header("location: novo_usuario.php");
        }
    }
}
else header("location: ../../../index.php");
?>
