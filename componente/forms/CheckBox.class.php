<?php


class CheckBox extends Input{
	
	public function __construct($name){
		parent::__construct("checkbox");
                parent::__set("name",$name);
	}
}
?>