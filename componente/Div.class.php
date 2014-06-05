<?php

class Div extends Element{
	
	public function __construct(){
		parent::__construct("div");
		if(func_num_args()==1){
                    $id = func_get_arg(0);
                    parent::__set("id",$id);
		}
	}
}
?>
