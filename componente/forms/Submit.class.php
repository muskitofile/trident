<?php

class Submit extends Input{
	
	public function __construct($name){
		parent::__construct("submit");
                parent::__set("name",$name);
	}
}
?>
