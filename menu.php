<?php
    
    $menu = new Menu("menu");
    
    $menu->addItem("Comando");
    $pessoal = $menu->addItem("Pessoal");
    $submenuPessoal = $menu->addSubmenu($pessoal);
        $submenuPessoal->addItem("index.php?menu=chefia","Chefia");
        $submenuPessoal->addItem("index.php?menu=ajudancia","Ajudância");
        $submenuPessoal->addItem("index.php?menu=patrimonio","Patrimônio");
        $submenuPessoal->addItem("index.php?menu=leginfo","Legis. e Informática");
    $menu->addItem("Inteligência");
    $operacoes = $menu->addItem("Operações");
    $submenuOperacoes = $menu->addSubmenu($operacoes);
        $submenuOperacoes->addItem("index.php?menu=ssinst","SSINST");
    $menu->addItem("Material");
    $menu->addItem("Guerra Eletrônica");
    $menu->addItem("Aeromédica");
    $menu->addItem("SIPAA");
    $menu->addItem("Comunicação Social");
    $menu->script->addSrc("../jquery_ui/jquery-1.9.1.js");
    $menu->script->addSrc("../jquery_ui/ui/jquery.ui.core.js");
    $menu->script->addSrc("../jquery_ui/ui/jquery.ui.widget.js");
    $menu->script->addSrc("../jquery_ui/ui/jquery.ui.position.js");
    $menu->script->addSrc("../jquery_ui/ui/jquery.ui.menu.js");
    
    $codigo = <<<codigo
$(function(){
    $("#menu").menu();
    // aqui mais código javascript para a página
});
codigo;
    $menu->script->addExe($codigo);

    $menu->estilo->addHref("../jquery_ui/themes/base/jquery.ui.all.css");
    $estilos = <<<estilo
.ui-menu{
    font-size: 11pt;
    width: 180px;
    z-index: 1000;
}
          
.ui-menu-item a{
    height: 40px;
}
estilo;
    $menu->estilo->addRegra($estilos);
//    $menu->show();
?>
