<?php

class Tabs extends Element{
	
	private $lista;
	private $id;
	public $script;
	public $estilo;
	private $actualTab = null;
        private $tabs = array();
	
	public function __construct(){
		parent::__construct("div");
		$this->script = parent::addBrother(new Script());
                $exe = <<<exe
$(function(){
    $("#tab_pat").tabs();
    // aqui mais código javascript para a página
});
exe;
                $this->script->addExe($exe);
		$this->estilo = parent::addBrother(new Style());
		if(func_get_args()>0){
			$this->id = func_get_arg(0);
			parent::__set("id",$this->id);
		}
		$this->lista = parent::add(new Lista());
	}
	
	public function addTab(){//$title,$child){
		$args = func_get_args();
		$this->lista->addItem(new Anchor("#".$this->sanitizeLink($this->id."-".$args[0]),$args[0]));//$title,$title));
		$div = parent::add(new Element("div"));
                $this->tabs[] = $div;
		$div->id = $this->sanitizeLink($this->id."-".$args[0]);//$title;
		$this->actualTab = $div;
		if(sizeof($args)>1) return $div->add($args[1]);
	}
        
        private function sanitizeLink($link){
            return str_ireplace(" ","_",$link);
        }
		
	public function addToActualTab($child){
		return $this->actualTab->add($child);
	}
        
        public function addToTab($child,$tab){
            return $this->tabs[$tab]->add($child);
        }
}
?>