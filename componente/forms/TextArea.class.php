<?php

class TextArea extends Element{

	public function __construct(){
		parent::__construct("textarea");
                $name = func_get_arg(0);
                if(func_num_args()>0) parent::__set("name",$name);
	}
}
?>