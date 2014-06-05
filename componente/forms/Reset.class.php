<?php

class Reset extends Input{
	
	public function __construct($name){
		parent::__construct("reset");
                parent::__set("name",$name);
	}
}
?>
