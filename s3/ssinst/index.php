<?php

$content = new Div("div_ssinst");
$content->addBrother(new Style("s3/ssinst/index.css"));
$content->addBrother(new Script("s3/ssinst/ssinst.js"));

$div = $content->add(new Div("div_menu"));
$div->style["float"] = "left";
$div->style["margin"] = "10px";

$divAcc = $div->add(new MenuAccordion("menuAcc"));
$divAcc->setPrefix("../");
$menuP = $divAcc->addMenu("princ","Principal");
    $menuP->addItem("Registrar Voo");
    $menuP->addItem("Ficha de Voo");
$menuP = $divAcc->addMenu("meusd","Meus Dados");
    $menuP->addItem("Minhas Fichas");
    $menuP->addItem("Meus Voos");
    $menuP->addItem("Outros Dados");
$menu = $divAcc->addMenu("avanc","Avançado");
    $menu->addItem("Gerenciar Itens");
    $menu->addItem("Gerenciar Fichas");

$div = $content->add(new Div("div_main"));
$div->style["float"] = "left";
$div->style["margin"] = "10px";
$field = $div->add(new Fieldset("ENTRE COM OS DADOS PRELIMINARES DO VOO"));
$form = $field->add(new Form("nova_ficha"));
$form->add(new Label("Aluno: "))->class = "label";
$txt_al = $form->addText("aluno");
$txt_al->id = "txt_al";
$txt_al->style['width'] = "57px";
$txt_al->placeholder = "saram";

$form->add(new BreakLine());

$form->add(new Label("Programa: "))->class = "label";
$slc_prog = $form->addSelect("slc_prog");
Conexao::setDB("instrucao");
$items = Conexao::campoUnico("select descricao from programa order by ordem");
$slc_prog->addItems($items);

?>