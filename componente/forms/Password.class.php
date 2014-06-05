<?php

class Password extends Input{
	
	public function __construct($name){
		parent::__construct("password");
                parent::__set("name",$name);
	}
}
?>
