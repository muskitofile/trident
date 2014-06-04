<?php
//include_once '../../componente1/Fieldset1.class.php';
//include_once '../../componente1/Paragraph1.class.php';
include_once 'componente1/forms/Text1.class.php';
include_once 'componente1/forms/Password1.class.php';
include_once 'componente1/forms/TextArea1.class.php';
include_once 'componente1/forms/Submit1.class.php';
include_once 'componente1/forms/Form1.class.php';
include_once 'componente1/forms/CheckBox1.class.php';
include_once 'componente1/Label1.class.php';
include_once 'componente1/Image1.class.php';
//include_once '../../componente1/forms/Select1.class.php';
include_once 'bd/Conexao1.class.php';

//session_start();

$user = $_SESSION['usuario'];//Conexao1::registroUnico("select * from usuario where saram='".$_GET['usuario']."'");

$fld_func = $tabs->addToTab(new Fieldset1("Dados Funcionais"),0);
$fld_func->class = "edita_usuario";

$form_edita = $fld_func->add(new Form1("form_edita"));
$form_edita->action = "s1/ajudancia/dados_pessoais/atualiza_usuario.php";
$form_edita->method = "post";

$p_botoes = $form_edita->add(new Paragraph1());
$p_botoes->style['text-align'] = "right";
$i_voltar = $p_botoes->add(new Submit1("opcao"));
$i_voltar->value = "Anterior2";
$i_voltar->class = "anterior";
$i_cancelar = $p_botoes->add(new Submit1("opcao"));
$i_cancelar->value = "Cancelar";
$i_cancelar->class = "cancel";
$i_concluir = $p_botoes->add(new Submit1("opcao"));
$i_concluir->value = "Concluir";
$i_concluir->class = "ok";
?>
