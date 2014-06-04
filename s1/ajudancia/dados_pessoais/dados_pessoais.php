<?php
//include_once 'componente1/Label1.class.php';
//include_once 'componente1/Paragraph1.class.php';
//include_once 'componente1/Meta1.class.php';
//include_once 'componente1/forms/Submit1.class.php';
//include_once 'componente1/forms/Form1.class.php';
//

if(true){ // verificar se o usuário logado é um admin

    $fieldset->add(new Script("scripts/dialogs.js"));
    $fieldset->add(new Script("scripts/wizard.js"));
    $fieldset->add(new Script("s1/ajudancia/dados_pessoais/dados.js"));
    $fieldset->add(new Style("s1/ajudancia/dados_pessoais/dados.css"));
    
    $fieldset->id = "dados_pessoais";

    $form = $fieldset->add(new Form("form_usuario"));
    $form->action = "index.php";
    $form->method = "get";
    $form->style['text-align'] = "right";
    $form->style['width'] = "100%";
    $form->style['border'] = "solid 1px #ccc";

    $button = $form->add(new Submit("opcao"));
    $button->value = "Editar1";
    $button->style['background'] = "url('s1/ajudancia/dados_pessoais/imagens/homemedit.png')";
    $button->style['color'] = "transparent";
    $button->title = "Edite os dados pessoais deste usuário.";
    $button = $form->add(new Submit("opcao"));
    $button->value = "Apagar";
    $button->style['background'] = "url('s1/ajudancia/dados_pessoais/imagens/homen2lixeira.png')";
    $button->style['color'] = "transparent";
    $button->title = "Apague este usuário do banco de dados do sistema.";
}

$foto = Conexao::registroUnico("select foto,foto_type from usuario where saram='{$usuario['saram']}'");
$table2 = $fieldset->add(new Table());
$table2->cellspacing = "5px";
//$table->border = "1";
$row = $table2->addRow();
if(!isset($foto['foto']) or $foto['foto']==null) 
    $img_foto = new Image("s1/ajudancia/dados_pessoais/imagens/foto.png");
else 
    $img_foto = new Image("data:{$foto['foto_type']};base64,".base64_encode($foto['foto']));
$img_foto->id = "foto";
$cell = $row->addCell($img_foto);
$cell->rowspan = "7";
$cell->style['vertical-align'] = "top";
$cell = $row->addCell(new Label("Saram:"));
$cell->add($usuario['saram']);
$cell = $row->addCell(new Label("Setor:"));
$cell->add("&lt;implementar&gt;");

$row = $table2->addRow();
$cell = $row->addCell(new Label("Identidade:"));
$cell->add($usuario['identidade']);
$cell = $row->addCell(new Label("Cargo:"));
$cell->add(Conexao::direct("select descricao from funcao where id=".
                    "(select funcao from usuario_funcao where usuario='{$usuario['saram']}')"));

$ender = Conexao::registroUnico("select * from endereco where usuario='{$usuario['saram']}'");
$cidade = Conexao::direct("select descricao from local where indicativo='{$ender['cidade']}'");                    

$row = $table2->addRow();
$cell = $row->addCell(new Label("CPF:"));
$cell->add($usuario['cpf']);
$cell = $row->addCell(new Label("CEP:"));
$cell->add($ender['cep']);

$row = $table2->addRow();
$cell = $row->addCell(new Label("Nome:"));
$cell->add($usuario['nome']);
$cell = $row->addCell(new Label("Data de Praça:"));
$cell->add(Conexao::converteData($usuario['praca']));


$row = $table2->addRow();
$cell = $row->addCell(new Label("Posto/Grad:"));
$cell->add($usuario['posto']);
$emails = Conexao::campoUnico("select email from email where usuario='{$usuario['saram']}'");
$cell = $row->addCell(new Label("Email:"));
if(sizeof($emails)>0){
    $cell->add($emails[0]);
    if(sizeof($emails)>1) $cell->add(new Anchor("#"," mais..."));
}

$row = $table2->addRow();
$cell = $row->addCell(new Label("Quadro Espec:"));
$cell->add($usuario['quadro']);
$fones = Conexao::campoUnico("select telefone from telefone where usuario='{$usuario['saram']}'");
$cell = $row->addCell(new Label("Telefone:"));
if(sizeof($fones)>0){
    $cell->add($fones[0]);
    if(sizeof($fones)>1) $cell->add(new Anchor("#"," mais..."));
}


$row = $table2->addRow();
$cell = $row->addCell(new Label("Antiguidade na OM:"));
$cell->add($usuario['ordem']);

$end_text = $ender['logradouro'].".<br/>".$ender['bairro']."<br/> ".$cidade."-".$ender['uf'];
//$end_text = $end_text;
$cell = $row->addCell(new Label("Endereço:"));
$cell->add($end_text);
$cell->style['max-width'] = "400px";

?>
