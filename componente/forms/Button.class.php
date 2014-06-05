<?php

class Button extends Input{
	
	public function __construct($name){
		parent::__construct("button");
                parent::__set("name",$name);
	}
}
?>
