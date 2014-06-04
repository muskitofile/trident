<?php
include_once 'componente1/forms/Text1.class.php';
include_once 'componente1/forms/Password1.class.php';
include_once 'componente1/forms/TextArea1.class.php';
include_once 'componente1/forms/Submit1.class.php';
include_once 'componente1/forms/Form1.class.php';
include_once 'componente1/forms/Button1.class.php';
//include_once '../../componente1/forms/Select1.class.php';
include_once 'bd/Conexao1.class.php';

$user = $_SESSION['usuario'];//Conexao1::registroUnico("select * from usuario where saram='".$_GET['usuario']."'");

$fld_endereço = $tabs->addToTab(new Fieldset1("Endereço, Telefones e Emails"),0);
$fld_endereço->class = "edita_usuario";

$form_edita = $fld_endereço->add(new Form1("form_edita"));
$form_edita->action = "s1/ajudancia/dados_pessoais/atualiza_usuario.php";
$form_edita->method = "post";
$form_edita->add("Logradouro:<br/>");
$ta_ender = $form_edita->add(new TextArea1("logradouro"));
$ta_ender->style['width'] = "300px";
$ta_ender->style['resize'] = "none";
$end = Conexao1::registroUnico("select * from endereco where usuario='{$user['saram']}'");
$ta_ender->add($end['logradouro']);

$p_bairro = $form_edita->add(new Paragraph1("Bairo: "));
$i_bairro = $p_bairro->add(new Text1("bairro"));
$i_bairro->value = $end['bairro'];

$p_cep = $form_edita->add(new Paragraph1("CEP: "));
$i_cep = $p_cep->add(new Text1("cep"));
$i_cep->value = $end['cep'];

$p_cidade = $form_edita->add(new Paragraph1("Cidade: "));
$s_cidade = $p_cidade->add(new Select1("cidade"));
$cidades = Conexao1::query("select indicativo,descricao from local");
foreach ($cidades as $cidade){
    if($cidade['indicativo']==$end['cidade']) $s_cidade->addSelectedItem($cidade);
    else $s_cidade->addItem($cidade);
}
$p_cidade->add(new Anchor1("#","Nova cidade"));

$p_uf = $form_edita->add(new Paragraph1("UF: "));
$s_uf = $p_uf->add(new Select1("uf"));
$ufs = array("PA","SP","RJ","CE","BA");
//Conexao1::query("select indicativo,descricao from local");
foreach ($ufs as $uf){
    if($uf==$end['uf']) $s_uf->addSelectedItem($uf);
    else $s_uf->addItem($uf);
}

$p_fone = $form_edita->add(new Paragraph1());
$table_fones = $p_fone->add(new Table1());
$table_fones->style['display'] = "inline";
//$table_fones->border = "1";
$table_fones->cellspacing = "0";
$table_fones->id = "table_fones";
$table_fones->addRow();

$cell = $table_fones->addCell("Telefones:");
$cell->rowspan = "3";

$text_ddd = $table_fones->addCell(new Text1(),"content");
$text_ddd->id = "text_ddd";
$text_ddd->placeholder = "00";
$text_ddd->maxlength = "2";
$text_ddd->title = "Digite aqui o DDD com 2 dígitos";
//$text_ddd->onchange = "estiloItalico(this)";
//$text_ddd->onkeypress = "estiloItalico(this)";
//$text_ddd->style['font-style'] = "italic";

$cell = $table_fones->getLastCell();
$cell->rowspan = "3";
$text_fone = $cell->add(new Text1());
$text_fone->id = "text_fone";
$text_fone->placeholder = "<8 dígitos>";
$text_fone->maxlength = "8";
$text_fone->title = "Digite aqui o número do telefone com 8 dígitos";
//$text_fone->onkeyup = "estiloItalico(this)";
//$text_fone->onchange = "estiloItalico(this)";
//$text_fone->style['font-style'] = "italic";

$btn_add = $cell->add(new Button1("add"));
$btn_add->id = "btn_add";
$btn_add->onclick = "addFone(text_ddd,text_fone)";
$btn_add->title = "Adicionar à lista de telefones";

$s_fone = $table_fones->addCell(new Select1("fone[]"),"content");
$s_fone->id = "slc_fones";
$s_fone->size = "4";
$cell = $table_fones->getLastCell();
$cell->rowspan = "3";
$fones = Conexao1::campoUnico("select concat(ddd,'-',telefone) from telefone where usuario='{$user['saram']}'");
$s_fone->addItems($fones);

$btn_up = $table_fones->addCell(new Button1("up"),"content");
$btn_up->id = "btn_up";
$btn_up->onclick = "upFone()";
$btn_up->title = "Mover telefone selecionado para cima";

$table_fones->addRow();
$btn_down = $table_fones->addCell(new Button1("down"),"content");
$btn_down->id = "btn_down";
$btn_down->onclick = "downFone()";
$btn_down->title = "Mover telefone selecionado para baixo";

$table_fones->addRow();
$btn_del = $table_fones->addCell(new Button1("del"),"content");
$btn_del->id = "btn_del";
$btn_del->onclick = "delFone()";
$btn_del->title = "Excluir telefone selecionado da lista";

//$p_mail = $form_edita->add(new Paragraph1("Emails: "));
//$s_mail = $p_mail->add(new Select1("email"));
//$s_mail->multiple = "";
//$mails = Conexao1::campoUnico("select email from email where usuario='{$user['saram']}'");
//$s_mail->addItems($mails);

$p_mail = $form_edita->add(new Paragraph1());
$table_emails = $p_mail->add(new Table1());
$table_emails->id = "table_emails";
$table_emails->addRow();
$cell = $table_emails->addCell("Emails:");
$cell->rowspan = "3";

$text_email = $table_emails->addCell(new Text1(),"content");
$text_email->id = "text_email";
$text_email->placeholder = "usuario@dominio";
$text_email->title = "Digite aqui o seu email";
//$text_email->onkeyup = "estiloItalico(this)";
//$text_email->onchange = "estiloItalico(this)";
//$text_email->style['font-style'] = "italic";
$cell = $table_emails->getLastCell();
$cell->rowspan = "3";

$slc_tipo = $cell->add(new Select1("email[]"));
$slc_tipo->addItems(array("intraer","internet"));
$slc_tipo->id = "slc_tipo";

$btn_add = $cell->add(new Button1("add"));
$btn_add->id = "btn_add";
$btn_add->onclick = "addEmail()";
$btn_add->title = "Adicionar à lista de emails";

$s_email = $table_emails->addCell(new Select1("fone"),"content");
$s_email->id = "slc_emails";
$s_email->size = "4";
$cell = $table_emails->getLastCell();
$cell->rowspan = "3";
$mails = Conexao1::query("select concat(email,'-',tipo),email from email where usuario='{$user['saram']}'");
$s_email->addItems($mails);

$btn_up = $table_emails->addCell(new Button1("up"),"content");
$btn_up->id = "btn_up";
$btn_up->onclick = "upEmail()";
$btn_up->title = "Mover email selecionado para cima";

$table_emails->addRow();
$btn_down = $table_emails->addCell(new Button1("down"),"content");
$btn_down->id = "btn_down";
$btn_down->onclick = "downEmail()";
$btn_down->title = "Mover email selecionado para baixo";

$table_emails->addRow();
$btn_del = $table_emails->addCell(new Button1("del"),"content");
$btn_del->id = "btn_del";
$btn_del->onclick = "delEmail()";
$btn_del->title = "Excluir email selecionado da lista";

$p_botoes = $form_edita->add(new Paragraph1());
$p_botoes->style['text-align'] = "right";
$i_voltar = $p_botoes->add(new Submit1("opcao"));
$i_voltar->value = "Anterior1";
$i_voltar->class = "anterior";
$i_salvar = $p_botoes->add(new Submit1("opcao"));
$i_salvar->value = "Próximo2";
$i_salvar->class = "proximo";
$i_cancelar = $p_botoes->add(new Submit1("opcao"));
$i_cancelar->value = "Cancelar";
$i_cancelar->class = "cancel";
$i_concluir = $p_botoes->add(new Submit1("opcao"));
$i_concluir->value = "Concluir";
$i_concluir->class = "ok";
?>
