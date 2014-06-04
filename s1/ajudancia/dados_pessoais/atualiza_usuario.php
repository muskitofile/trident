<?php
include_once '../../../bd/Conexao1.class.php';
include_once '../../../componente1/Div1.class.php';
include_once '../../../componente1/Paragraph1.class.php';
include_once '../../../email/Sender.class.php';
include_once '../../../../PHPMailer/class.phpmailer.php';

$opcao1 = $_POST[opcao];
if($opcao1=="Cancelar") header("location: ../../../index.php");
else if($opcao1=="Concluir"){
    salva1();
    header("location: ../../../index.php");
}
else if($opcao1=="Próximo1"){
    salva1();
    header("location: ../../../index.php?opcao=Próximo1");
}
else if($opcao1=="Próximo2"){
    salva1();
    header("location: ../../../index.php?opcao=Próximo2");
}
else if($_POST['opcao']=="Anterior1") header("location: ../../../index.php?opcao=Anterior1");
else if($_POST['opcao']=="Anterior2") header("location: ../../../index.php?opcao=Anterior2");

function salva1(){
/*    $_FILES["file"]["name"] - the name of the uploaded file
      $_FILES["file"]["type"] - the type of the uploaded file
      $_FILES["file"]["size"] - the size in bytes of the uploaded file
      $_FILES["file"]["tmp_name"] - the name of the temporary copy of the file stored on the server
      $_FILES["file"]["error"] - the error code resulting from the file upload
 */
    
    echo "Nome do Arquivo: ".$_FILES['foto']['tmp_name'].". Tamanho: ".  sizeof($_FILES['foto']['tmp_name']);
    if(isset($_FILES['foto'])/* and sizeof($_FILES['foto']['tmp_name'])>1*/){
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $type = $_FILES['foto']['type'];
    }
    else{
        $foto = null;
        $type = null;
    }
    $saram = $_SESSION['usuario']['saram'];
    $guerra = $_POST['guerra']; //echo $guerra;
    $posto = $_POST['posto']; //echo $posto;
    $quadro = $_POST['quadro']; //echo $quadro;
    $nome = $_POST['nome']; //echo $nome;
    $identidade = $_POST['identidade']; //echo $identidade;
    $cpf = $_POST['cpf']; //echo $cpf;
    if(isset($_POST['senha'])) $senha = $_POST['senha']; //echo $senha;
    $antiguidade = $_POST['antiguidade']; //echo $antiguidade;
    $enviar_email = false;
    if(isset($_POST['auto_senha'])){
        $vetor = array("0","1","2","3","4","5","6","7","8","9",
            "a","b","c","d","e","f","g","h","i","j","k","l",
            "m","n","o","p","q","r","s","t","u","v","w","x","y","z");
        $maiusculas = 0;
        $senha = "";
        for($i=0;$i<7;$i++){
            $maiusculas = rand(0,1);
            if($maiusculas==0) $senha .= $vetor[rand(0,35)];
            else $senha .= strtoupper($vetor[rand(0,35)]);
        }
        $enviar_email = true;
    } 
    $sql = "call atualiza_usuario1('{$foto}', '{$type}','{$saram}',".
            "'{$guerra}', '{$posto}', '{$quadro}', '{$nome}',".
            "'{$identidade}', '{$cpf}', '{$senha}', ".
            "'{$antiguidade}')";
    //echo $sql;
    if(Conexao1::execute($sql)){
        session_start();
        $_SESSION['usuario'] = Conexao1::registroUnico("select * from usuario where saram='{$saram}'");
        if($enviar_email){
            $msg = new Div1();
            $msg->add(new Paragraph1("Caro, ".$posto." ".$guerra.", sua senha automática foi gerada com sucesso."));
            $msg->add(new Paragraph1("Anote sua nova senha: <b>".$senha."</b>"));
            $msg->add(new Paragraph1("Em caso de dúvida, entre em contato com o administrador do sistema."));
            $msg->add(new Paragraph1("Não responda a esta mensagem, ela foi gerada automaticamente."));
            Sender1::send($msg->toString(), array("email"=>"muskitofile@gmail.com","nome"=>"Junior Reis"));
        }
    }
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $fones = $_POST['fone'];
    $emails = $_POST['email'];
    
    Conexao1::execute("call atualiza_usuario2('{$logradouro}',".
            "'{$bairro}','{$cep}','{$cidade}','{$uf}','{$saram}')");
    
    Conexao1::execute();
}
?>
