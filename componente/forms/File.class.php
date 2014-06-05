<?php

class File extends Input{
	
	public function __construct($name){
		parent::__construct("file");
                parent::__set("name",$name);
	}
}
?>
