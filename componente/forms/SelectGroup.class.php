<?php

class SelectGroup extends Element{
	
    public function __construct($label){
        parent::__construct("optgroup");
        $this->label = $label;
    }
    
    public function addItem($item){
        if(is_object($item) and $item->getTag()=="option"){
            parent::add($item);
            return $item;
        }
        else if(is_string($item)){
            $novo = new Element("option");
            $novo->value = $item;
            parent::add($novo);
            return $novo;
        }
    }
}
?>