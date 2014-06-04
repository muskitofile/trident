<?php

include_once '../../../../componente1/Element1.class.php';
include_once '../../../../componente1/Style1.class.php';
include_once '../../../../componente1/Html1.class.php';
include_once '../../../../componente1/Fieldset1.class.php';
include_once '../../../../componente1/Table1.class.php';
include_once '../../../../componente1/Label1.class.php';
include_once '../../../../componente1/forms/FormSql.class.php';
include_once '../../../bd/Conexao1.class.php';
include_once '../../../email/Sender.class.php';
include_once '../../../../PHPMailer/class.phpmailer.php';

session_start();

if (sizeof($_POST)>0 or sizeof($_GET)>0){
    FormSql::store();
    $gets = $_SESSION["form_sql"];
//    foreach ($gets as $index=>$value){
//        echo $index."=>'".$value."'\n";
//    }

    $vetor = array("0","1","2","3","4","5","6","7","8","9",
            "a","b","c","d","e","f","g","h","i","j","k","l",
            "m","n","o","p","q","r","s","t","u","v","w","x","y","z");

    $opcao = $_GET['opcao'];

    if($opcao=="Concluir"){
        $maiusculas = 0;
        $senha = "";
        for($i=0;$i<7;$i++){
            $maiusculas = rand(0,1);
            if($maiusculas==0) $senha .= $vetor[rand(0,35)];
            else $senha .= strtoupper($vetor[rand(0,35)]);
        }

        $result = Conexao1::registroUnico(
                "select * from email where usuario='{$gets["saram"]}' ".
                "or email='{$gets["email"]}'");
        if(isset($result) and sizeof($result)>0){
            $_SESSION['msg_novo_usuario_saram'] = "O SARAM e/ou o EMAIL que você forneceu já estão cadastrados. ".
                        "Verifique se você recebeu um email em <u>{$gets["email"]}</u> com sua senha ou ".
                        "consulte sua conta junto ao administrador do sistema.";
            header("location: novo_usuario.php");
        }
        else{
            if(Sender1::send ("Senha: ".$senha, 
                    array("email"=>"pinheirowprj@babe.intraer","nome"=>"{$gets["posto"]} {$gets["nome"]}"))){
                if(Conexao1::execute("call novo_usuario('{$gets["nome"]}','{$gets["saram"]}','{$gets["posto"]}',".
                                        "'{$gets["quadro"]}','{$senha}','{$gets["email"]}')")){
                    header("location: novo_usuario_ok.php?novo_usuario={$gets["posto"]} {$gets["nome"]}");
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
}
else {
    $html = new Html1("Novo Usuário - Poseidon");
    $head = $html->getHead();
    $head->addStyleLink("../../pagina.css");
    $head->addStyleLink("dados.css");
    $head->addStyleLink("../s1.css");

    $body = $html->getBody();
    $field = $body->add(new Fieldset1("Dados Primários"));
    $field->add(new Style1("dados.css"));
    $field->style['width'] = "800px";
    $field->id = "fld_novo_usuario";
//$form = $field->add(new Form1("form_usuario"));
    $form = new FormSql();
    $form->id = "form_usuario";
    $field->add($form);
    $form->action = "novo_usuario.php";
    $form->method = "get";
    $table = $form->add(new Table1());
//$table->border = "1";
    $table->style['width'] = "auto";
    $row = $table->addRow();
    $cell = $row->addCell("Nome de Guerra:");
    $cell->class = "label";
    $cell = $row->addCell();
    $cell->colspan = "3";
//$nomeText = $cell->add(new Text1("nome"));
    $nomeText = $cell->add($form->addText("nome"));
    $nomeText->style['width'] = "180px";
    if (isset($_SESSION['novo_usuario_nome']))
        $nomeText->value = $_SESSION['novo_usuario_nome'];

    $row = $table->addRow();
    $cell = $row->addCell("Saram: ");
    $cell->class = "label";
    $saramText = $cell->add($form->addText("saram"));
    $saramText->maxlength = "7";
    if (isset($_SESSION['novo_usuario_saram']))
        $saramText->value = $_SESSION['novo_usuario_saram'];
    $cell = $row->addCell();
    if (isset($_SESSION['msg_novo_usuario_saram'])) {
        $msg_saram = $cell->add(new Label1($_SESSION['msg_novo_usuario_saram']));
        $msg_saram->class = "aviso_interno";
        unset($_SESSION['msg_novo_usuario_saram']);
    }

    $cell = $row->addCell("Senha:");
    $cell->class = "label";
    $cell->colspan = "2";
    $table_senha = $table->addCell(new Table1(), "content");
//    $table_senha->border = "1";
    $table_senha->addRow();
//    $rdo_agora = $table_senha->addCell(new Radio1("senha_opcao","Digitar agora"),"content");
    $rdo_agora = $table_senha->addCell($form->addRadio("senha_opcao"), "content");
    $rdo_agora->add("Digitar agora: ");
    $rdo_agora->checked = "";
    $rdo_agora->value = "agora";
    $rdo_agora->onchange = "senha_txt.disabled = !this.checked";
    $senha_text = $table_senha->lastCell()->add($form->addPassword("senha"));
    $senha_text->id = "senha_txt";
//    $senha_text->disabled = "";
    $table_senha->addRow();
//    $rdo_agora = $table_senha->addCell(new Radio1("senha_opcao","Receber por email uma senha automática."),"content");
    $rdo_agora = $table_senha->addCell($form->addRadio("senha_opcao"), "content");
    $rdo_agora->add("Receber por email uma senha automática");
    $rdo_agora->value = "auto";
    $rdo_agora->onchange = "senha_txt.disabled = this.checked";

$table->addRow();
$cell = $table->addCell("Email (Intraer):");
//$cell->style['padding-left'] = "20px";
$cell->class = "label";
$cell->colspan = "4";
$cell = $table->addCell();
if(isset($_SESSION['msg_novo_usuario_email'])){
    $aviso_email = new Label1($_SESSION['msg_novo_usuario_email']);
    $aviso_email->class = "aviso_interno";
    $msg_email = $cell->add($aviso_email);
    unset($_SESSION['msg_novo_usuario_email']);
}
$emailText = $cell->add($form->addText("email"));
$emailText->placeholder = "< Obrigatório >";
$emailText->style['width'] = "220px";
if(isset($_SESSION['novo_usuario_email'])) 
    $emailText->value = $_SESSION['novo_usuario_email'];

    $row = $table->addRow();
    $cell = $row->addCell("Posto/Grad:");
    $cell->class = "label";
    $cell = $row->addCell();
//$postoSlc = $cell->add(new Select1());
    $postoSlc = $cell->add($form->addSelect(false, "posto"));
//$postoSlc->name = "posto";
    $postos = Conexao1::campoUnico("select sigla from posto order by ordem");
    $postoSlc->addItems($postos);
    if (isset($_SESSION['novo_usuario_posto']))
        $postoSlc->setSelectedItem($_SESSION['novo_usuario_posto']);

    $cell = $row->addCell("Quadro:");
    $cell->class = "label";
    $cell = $row->addCell();
//$quadroSlc = $cell->add(new Select1());
    $quadroSlc = $cell->add($form->addSelect(false, "quadro"));
    $quadroSlc->name = "quadro";
    $quadros = array("QOAV AV", "QSS BCO", "QSS BMA", "QCB SAD");
    $quadroSlc->addItems($quadros);
    if (isset($_SESSION['novo_usuario_quadro']))
        $quadroSlc->setSelectedItem($_SESSION['novo_usuario_quadro']);

    $row = $table->addRow();
    $cell = $row->addCell();
    $cell->colspan = "4";
    $cell->align = "right";
    $cell->style['padding'] = "15px";
    $cnlButton = $cell->add(new Submit1("opcao"));
    $cnlButton->value = "Cancelar";
    $cnlButton->style['background'] = "#faa";
    $cnlButton->style['width'] = "100px";
    $okButton = $cell->add(new Submit1("opcao"));
    $okButton->value = "Concluir";
    $okButton->style['background'] = "#afa";
    $okButton->style['width'] = "100px";
    $okButton->onclick = "form_usuario.submit()";
    
    $html->show();
}
?>
