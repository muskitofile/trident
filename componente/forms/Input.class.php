<?php

class Input extends Element{
	
	public function __construct($type){
		parent::__construct("input");
		parent::__set("type",$type);
	}
}
?>