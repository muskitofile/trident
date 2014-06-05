<?php

class Row extends Element{
	
	public function __construct(){
		parent::__construct("tr");
	}
	
	public function addCell(){
		if(func_num_args()>0){
			return parent::add(new Cell(func_get_arg(0)));
		}
		else return parent::add(new Cell());
	}
}
?>