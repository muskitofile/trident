<?php

class Fieldset extends Element{
	
    private $legend;
    public function __construct(){
        parent::__construct("fieldset");
        if(func_num_args()>0){
            $this->legend = parent::add(new Element("legend"));
            $this->legend->add(func_get_arg(0));
        }
    }
    
    public function addToLegend($child){
        return $this->legend->add($child);
    }
    
}
?>
