<?php

class Meta extends Element{

	public function __construct(){
		parent::__construct("meta");
	}

	public function setHttpEquiv($value){
		parent::__set("http-equiv",$value);
	}
}
?>