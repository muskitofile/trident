<?php

class Lista extends Element{ // o php não aceita uma classe com nome List, pois é uma palavra reservada da linguagem
	
	public function __construct(){
		parent::__construct("ul");
	}
	
	public function addItem(){
		$num = func_num_args();
		if($num>0) return $this->add(new ListItem(func_get_arg(0)));
		else return $this->add(new ListItem());
	}
}
?>