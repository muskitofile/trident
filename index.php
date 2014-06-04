<?php
//include_once 'componente1/Html1.class.php';
//include_once 'componente1/Paragraph1.class.php';
//include_once 'componente1/Meta1.class.php';
//include_once 'componente1/Table1.class.php';
//include_once 'componente1/Anchor1.class.php';
//include_once 'componente1/Image1.class.php';
include 'includes.php';

session_start();

if(isset($_SESSION['form_sql'])) unset($_SESSION['form_sql']);
if(isset($_SESSION['target'])) unset($_SESSION['target']);

$page = new Html("POSEIDON");
$head = $page->getHead();
$head->addStyleLink("pagina.css");
$meta = new Meta();
$meta->setHttpEquiv("cache-control");
$head->add($meta);
$body = $page->getBody();

$parag = $body->add(new Paragraph("Bem-vindo, "));
$parag->id = "boas-vindas";
if(!isset($_SESSION['logado'])) header("location: login.php");
$logado = $_SESSION['logado'];
$usuario = $_SESSION['usuario'];
$parag->add("{$logado['posto']} {$logado['quadro']} {$logado['guerra']}. ");
$imagemSair = new Image("sair.png");
$link_sair = $parag->add(new Anchor("logout.php",$imagemSair));
$link_sair->add("Sair");
$link_sair->style['color'] = "#f84";
$link_sair->style['text-decoration'] = "none";

$tableMenu = $body->add(new Table("raiz"));
$tableMenu->addRow();
include 'menu.php';
$tableMenu->addCell($menu);
if(!isset($_GET['menu']) or $_GET['menu']=="ajudancia"){
    include 's1/ajudancia/ajudancia.php';
}
else if($_GET['menu']=="patrimonio"){
    include 's1/patrimonio/material_carga.php';
}
else if($_GET['menu']=="ssinst"){
    include 's3/ssinst/index.php';// 's1/patrimonio/material_carga.php';
}
$cell = $tableMenu->addCell($content);
$cell->style['overflow'] = "auto";
$cell->style['max-height'] = "800px";

$page->show();
?>
