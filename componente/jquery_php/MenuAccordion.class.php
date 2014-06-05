<?php

class MenuAccordion extends Accordion {

    public function __construct($id) {
        parent::__construct($id);
        $this->style["width"] = "200px";
        $this->style["font-size"] = "10pt";
    }

    public function addMenu($id, $texto) {
        $menu = parent::addSect($texto, new MenuInterno());
        $menu->id = $id;
        return $menu;
    }
    
    public function setPrefix($pref){
        $id = $this->get("id");
        $this->script->addSrc($pref."jquery_ui/jquery-1.9.1.js");
        $this->script->addSrc($pref."jquery_ui/jquery.maskedinput.js");
        $this->script->addSrc($pref."jquery_ui/ui/jquery.ui.core.js");
        $this->script->addSrc($pref."jquery_ui/ui/jquery.ui.widget.js");
        $this->script->addSrc($pref."jquery_ui/ui/jquery.ui.position.js");
        $this->script->addSrc($pref."jquery_ui/ui/jquery.ui.menu.js");
        $this->script->addSrc($pref."jquery_ui/ui/jquery.ui.accordion.js");
        
        $codigo = <<<codigo
$(function(){
    $("#{$id}").accordion();
    $("#{$id}").find("h3").each(function(){
        $(this).on("mouseover",function(){
            $(this).click();
        });
    });
    // aqui mais código javascript para a página
});
codigo;

        $this->script->addExe($codigo);

        $estilos = <<<estilo
.ui-accordion .ui-accordion-content, .ui-widget-content{
    padding: 10px;
    height: auto;
    max-height: none;
}

.
estilo;

        $this->estilo->addRegra($estilos);
        $this->estilo->addHref($pref."jquery_ui/themes/base/jquery.ui.all.css");
    }

}

class MenuInterno extends Lista{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function addItem($item){
        return parent::addItem(new Anchor($item));
    }
}
?>