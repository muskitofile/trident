<?php

include "includes.php"; // todos os includes desta página foram colocados em uma página a parte
                        // para despoluir o visual desta.

$page = new Html("Sistema de Instrução Online");
$page->getHead()->addStyleLink("index.css");
$div = $page->add(new Div("div_main"));
$div->add(new Header("COMANDO DA AERONÁUTICA"));
$div->add(new Header("SEGUNDA FORÇA AÉREA"));
$div->add(new Header("3º/7º GAV"));

$divAcc = $div->add(new MenuAccordion("menu"));
$menuP = $divAcc->addMenu("princ","Principal");
$menuP->addItem("Registrar Voo");
$menuP->addItem("Ficha de Voo");
$menuP = $divAcc->addMenu("meusd","Meus Dados");
$menuP->addItem("Minhas Fichas");
$menuP->addItem("Meus Voos");

$divAcc->script->addSrc("../jquery_ui/jquery-1.9.1.js");
$divAcc->script->addSrc("../jquery_ui/ui/jquery.ui.core.js");
$divAcc->script->addSrc("../jquery_ui/ui/jquery.ui.widget.js");
$divAcc->script->addSrc("../jquery_ui/ui/jquery.ui.position.js");
$divAcc->script->addSrc("../jquery_ui/ui/jquery.ui.menu.js");
$divAcc->script->addSrc("../jquery_ui/ui/jquery.ui.accordion.js");
$codigo = <<<codigo
$(function(){
    $("#menu").accordion({collapsible: true});
    $("#princ").menu();
    $("#meusd").menu();
    // aqui mais código javascript para a página
});
codigo;
$menuP->script->addExe($codigo);
    $estilos = <<<estilo
.ui-menu{
    font-size: 6pt;
    font-family: Times New Roman;
    width: auto;
    z-index: 1000;
}
          
.ui-menu-item a{
    height: 40px;
}
            
.ui-accordion .ui-accordion-content, .ui-widget-content{
    padding: 10px;
    height: auto;
    max-height: none;
    font-family: Times New Roman;
}
estilo;
$menuP->estilo->addRegra($estilos);
$menuP->estilo->addHref("../jquery_ui/themes/base/jquery.ui.all.css");

Conexao::setBD("instrucao");
$form = $div->add(new Form());
$lista = $form->add(new Lista());
$lista->addItem("Aluno: ")->add($form->addText("aluno"));
$slc_funcao = $lista->addItem("Função: ")->add($form->addSelect("funcao"));
    $slc_funcao->addItems(Conexao::query("select * from funcao"));
$lista->addItem("Missão: ")->add($form->addText("missao"));
$lista->addItem("Data: ")->add($form->addText("data"));
$button = $form->addButton("enviar");
$button->value = "Enviar";
$lista->addItem($button);

$page->show();
?>