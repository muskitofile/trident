<?php

class Label extends Element{
	
	public function __construct(){
		parent::__construct("label");
		if(func_num_args()>0) parent::add(func_get_arg(0));
	}
}
?>