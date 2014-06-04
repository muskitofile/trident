<?php
//include_once 'componente1/Table1.class.php';
//include_once 'componente1/Div1.class.php';
//include_once 'componente1/Header1.class.php';
//include_once 'componente1/Paragraph1.class.php';
//include_once 'componente1/forms/Button1.class.php';
//include_once 'bd/Conexao1.class.php';
//include_once 'componente1/complexos/dintable/DinTable1.class.php';
//include_once 'jquery_php/Tabs.class.php';

//if($_GET['opcao']=="secao"){
    
//    $divMat = new Div1("div_mat");
    $content = new Tabs("tab_pat");
    $content->script->addSrc("../jquery_ui/ui/jquery.ui.mouse.js");
    $content->script->addSrc("../jquery_ui/ui/jquery.ui.sortable.js");
    $content->script->addSrc("../jquery_ui/ui/jquery.ui.tabs.js");
    $content->script->addSrc("../jquery_ui/ui/jquery.ui.button.js");
    $content->script->addSrc("../jquery_ui/ui/jquery.ui.draggable.js");
    $content->script->addSrc("../jquery_ui/ui/jquery.ui.resizable.js");
    $content->script->addSrc("../jquery_ui/ui/jquery.ui.dialog.js");
    $content->script->addSrc("../jquery_ui/ui/jquery.ui.position.js");
    $content->script->addSrc("scripts/ajax.js");
    $content->script->addSrc("s1/patrimonio/patrimonio.js");
    
    $content->script->addSrc("scripts/dialogs.js");
    $content->estilo->addHref("s1/s1.css");
    $content->estilo->addHref("s1/patrimonio/patrimonio.css");
    
    $content->addTab("Carga Geral");
    $content->addTab("Informática");
    $content->addTab("Aeronáutico");
    $content->addTab("Imobiliário");
    $content->addTab("Viaturas");
    
//    $link = $content->add(new Element("link"));
//    $link->rel = "stylesheet";
//    $link->href = "../componente/complexos/painel_imagens/painelImagens.css";    
    
    $secoes = Conexao::query("select sigla,descricao from setor order by ordem");
    
    foreach ($secoes as $secao){
        $content->addToTab(new Header($secao['descricao']),0);
        $table = $content->addToTab(new DinTable("din_".limpar($secao['sigla'])),0);
        $table->setScriptSrc("../componente/complexos/dintable/tabela.js");
        $table->setStyleHref("../componente/complexos/dintable/dintable.css");
        cabecalho($table);
        for($i=0;$i<(sizeof($table->header->getChildren())*5);$i++){
            $table->addCell("item".$i);
        }
        $prg_novo_reg = $content->addToTab(new Paragraph(),0);
        $prg_novo_reg->style['text-align'] = "right";
        $prg_novo_reg->style['margin'] = "0";
        $btn_novo_registro = $prg_novo_reg->add(new Button("new_reg"));
        $btn_novo_registro->onclick = "novoRegistro('".$secao['sigla']."')";
        $btn_novo_registro->value = "Adicionar Registro";
        $btn_novo_registro->name = "novo_reg";
    }
    
//    $tabs->show();
//}

function cabecalho($tab){
    $tab->addHeaderCell("Foto");
    $tab->addSortHeaderCell("Setor");
    $tab->addSortHeaderCell("BMP");
    $tab->addSortHeaderCell("Conta");
    $tab->addSortHeaderCell("Classe");
    $tab->addSortHeaderCell("Sispat");
    $tab->addSortHeaderCell("Descrição do Material");
    $tab->addSortHeaderCell("Valor (R$)");
    $tab->addSortHeaderCell("Detentor");
    $tab->addSortHeaderCell("Situação");
    $tab->addHeaderCell("Ações");
}

function limpar($texto){
    $texto = str_ireplace("_", "",$texto);
    $texto = str_ireplace("-", "", $texto);
    $texto = str_ireplace(" ", "", $texto);
    return $texto;
}
?>
