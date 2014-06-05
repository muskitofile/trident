<?php

class Body extends Element{

	public function __construct(){
		parent::__construct("body");
	}

	public function setOnload($function){
		parent::__set("onload",$function);
	}
}
?>