<?php
//include_once '../../componente1/Fieldset1.class.php';
//include_once '../../componente1/Paragraph1.class.php';
include_once 'componente1/forms/Text1.class.php';
include_once 'componente1/forms/Password1.class.php';
include_once 'componente1/forms/TextArea1.class.php';
include_once 'componente1/forms/Submit1.class.php';
include_once 'componente1/forms/Form1.class.php';
include_once 'componente1/forms/CheckBox1.class.php';
include_once 'componente1/forms/Button1.class.php';
include_once 'componente1/forms/Hidden1.class.php';
include_once 'componente1/forms/File1.class.php';
include_once 'componente1/Label1.class.php';
include_once 'componente1/Image1.class.php';
//include_once 'componente1/forms/FormSql.class.php';
include_once 'componente1/forms/Select1.class.php';
include_once 'bd/Conexao1.class.php';

//session_start();

$user = $_SESSION['usuario'];//Conexao1::registroUnico("select * from usuario where saram='".$_GET['usuario']."'");

$fld_identificacao = $tabs->addToTab(new Fieldset1("Identificação"),0);
$fld_identificacao->class = "edita_usuario";

$form_edita = $fld_identificacao->add(new Form1("form_edita"));
$form_edita->action = "s1/ajudancia/dados_pessoais/atualiza_usuario.php";
$form_edita->enctype="multipart/form-data";
$form_edita->method = "post";
$form_edita->onsubmit = "preparaForm(this)";
//$form_edita->onsubmit = "preparaForm(this)";

$p_foto = $form_edita->add(new Paragraph1());
if(!isset($user['foto']) or $user['foto']==null) 
    $im_foto = $p_foto->add(new Image1("s1/ajudancia/dados_pessoais/imagens/foto.png"));
else 
    $im_foto = $p_foto->add(new Image1("data:{$user['foto_type']};base64,".  base64_encode($user['foto'])));
$im_foto->id = "foto";
$i_foto = $p_foto->add(new File1("foto"));
$i_foto->id = "file_foto";
$i_foto->style['display'] = "none";
$i_foto->onchange = "carregaFoto()";
$i_foto->accept = "image/*";

$im_edita = $p_foto->add(new Image1("s1/ajudancia/dados_pessoais/imagens/edita_foto.png"));
$im_edita->id = "edita_foto";
$im_edita->title = "Alterar foto deste usuário";
$im_edita->onclick = "alterarFoto()";

$img_exclui = $p_foto->add(new Image1("s1/ajudancia/dados_pessoais/imagens/exclui_foto.png"));
$img_exclui->id = "exclui_foto";
$img_exclui->title = "Excluir foto deste usuário";
$img_exclui->onclick = "excluirFoto()";

$p_saram = $form_edita->add(new Paragraph1("Saram: "));
$i_saram = $p_saram->add(new Text1());
$i_saram->style['maxlength'] = "7";
$i_saram->style['width'] = "80px";
$i_saram->disabled = "";
$i_saram->value = $user['saram'];
$h_saram = $p_saram->add(new Hidden1("saram"));
$h_saram->value = $user['saram'];

$p_guerra = $form_edita->add(new Paragraph1("Nome de Guerra: "));
$i_guerra = $p_guerra->add(new Text1("guerra"));
$i_guerra->style['width'] = "200px";
$i_guerra->style['text-transformation'] = "uppercase";
$i_guerra->value = $user['guerra'];

$p_posto = $form_edita->add(new Paragraph1("Posto/Grad: "));
$s_posto = $p_posto->add(new Select1("posto"));
$postos = Conexao1::campoUnico("select sigla from posto order by ordem");
foreach ($postos as $posto){
    if($posto==$user['posto']) $s_posto->addSelectedItem($posto);
    else $s_posto->addItem($posto);
}

$p_quadro = $form_edita->add(new Paragraph1("Quadro/Espec: "));
$s_quadro = $p_quadro->add(new Select1("quadro"));
$quadros = array("QOAV AV", "QSS BMA","QSS BCO","QSS BET");
foreach ($quadros as $quadro){
    if($quadro==$user['quadro']) $s_quadro->addSelectedItem($quadro);
    else $s_quadro->addItem($quadro);
}

$p_nome = $form_edita->add(new Paragraph1("Nome Completo: "));
$i_nome = $p_nome->add(new Text1("nome"));
$i_nome->style['text-transformation'] = "uppercase";
$i_nome->style['width'] = "400px";
$i_nome->value = $user['nome'];

$p_identidade = $form_edita->add(new Paragraph1("Identidade: "));
$i_identidade = $p_identidade->add(new Text1("identidade"));
$i_identidade->value = $user['identidade'];

$p_cpf = $form_edita->add(new Paragraph1("CPF: "));
$i_cpf = $p_cpf->add(new Text1("cpf"));
$i_cpf->value = $user['cpf'];

$p_senha = $form_edita->add(new Paragraph1("Senha: "));
/*$i_senha = */$p_senha->add(new Password1("senha"));
$l_senha = $p_senha->add(new Label1());
$ck_senha = $l_senha->add(new CheckBox1("auto_senha"));
$ck_senha->onchange = "form_edita.senha.disabled = this.checked";
$l_senha->add("Deixar que o sistema gere uma senha automaticamente.");

$p_antiguidade = $form_edita->add(new Paragraph1("Antiguidade: "));
$s_antiguidade = $p_antiguidade->add(new Select1("antiguidade"));
$antigs = Conexao1::query("select ordem,concat(posto,' ',guerra) ".
        "from usuario order by ordem");
foreach ($antigs as $antig){
    if($antig['ordem']==$user['ordem']) $s_antiguidade->addSelectedItem($antig);
    else $s_antiguidade->addItem($antig);
}
//$s_antiguidade->addItem(array("-1","::Mais moderno::"));

$p_botoes = $form_edita->add(new Paragraph1());
$p_botoes->style['text-align'] = "right";
$i_salvar = $p_botoes->add(new Submit1("opcao"));
$i_salvar->value = "Próximo1";
$i_salvar->class = "proximo";
$i_cancelar = $p_botoes->add(new Submit1("opcao"));
$i_cancelar->value = "Cancelar";
$i_cancelar->class = "cancel";
$i_concluir = $p_botoes->add(new Submit1("opcao"));
$i_concluir->value = "Concluir";
$i_concluir->class = "ok";


//$fld_endereço = $tabs->addToTab(new Fieldset1("Endereço, Telefones e Emails"),0);
//$fld_endereço->class = "edita_usuario";
//$fld_endereço->add("Logradouro:<br/>");
//$ta_ender = $fld_endereço->add(new TextArea1("logradouro"));
//$ta_ender->style['width'] = "300px";
//$ta_ender->style['resize'] = "none";
//$end = Conexao1::registroUnico("select * from endereco where usuario='{$user['saram']}'");
//$ta_ender->add($end['logradouro']);
//
//$p_bairro = $fld_endereço->add(new Paragraph1("Bairo: "));
//$i_bairro = $p_bairro->add(new Text1("bairro"));
//$i_bairro->value = $end['bairro'];
//
//$p_cep = $fld_endereço->add(new Paragraph1("CEP: "));
//$i_cep = $p_cep->add(new Text1("cep"));
//$i_cep->value = $end['cep'];
//
//$p_cidade = $fld_endereço->add(new Paragraph1("Cidade: "));
//$s_cidade = $p_cidade->add(new Select1("cidade"));
//$cidades = Conexao1::query("select indicativo,descricao from local");
//foreach ($cidades as $cidade){
//    if($cidade['indicativo']==$end['cidade']) $s_cidade->addSelectedItem($cidade);
//    else $s_cidade->addItem($cidade);
//}
//$p_cidade->add(new Anchor1("#","Nova cidade"));
//
//$p_uf = $fld_endereço->add(new Paragraph1("UF: "));
//$s_uf = $p_uf->add(new Select1("uf"));
//$ufs = array("PA","SP","RJ","CE","BA");
////Conexao1::query("select indicativo,descricao from local");
//foreach ($ufs as $uf){
//    if($uf==$end['uf']) $s_uf->addSelectedItem($uf);
//    else $s_uf->addItem($uf);
//}
//
//$p_fone = $fld_endereço->add(new Paragraph1("Telefones: "));
//$s_fone = $p_fone->add(new Select1("fone"));
//$s_fone->multiple = "";
//$fones = Conexao1::campoUnico("select concat(ddd,'-',telefone) from telefone where usuario='{$user['saram']}'");
//$s_fone->addItems($fones);
//
//$p_mail = $fld_endereço->add(new Paragraph1("Emails: "));
//$s_mail = $p_mail->add(new Select1("email"));
//$s_mail->multiple = "";
//$mails = Conexao1::campoUnico("select email from email where usuario='{$user['saram']}'");
//$s_mail->addItems($mails);

//$fld_func = $tabs->addToTab(new Fieldset1("Dados Funcionais"),0);
//$fld_func->class = "edita_usuario";

//$fld_ident->show();
?>
