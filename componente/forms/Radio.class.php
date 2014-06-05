<?php
class Radio extends Label{
    
    public $radio;
    
    public function __construct() {
        parent::__construct();
        $this->radio = $this->add(new Input("radio"));
        if(func_num_args()>0) $this->radio->name = func_get_arg(0);
        if(func_num_args()>1) $this->add(func_get_arg(1));
    }
    
    public function __set($property, $value) {
        $this->radio->__set($property, $value);
    }
    
    public function setToLabel($property, $value){
        parent::__set($property,$value);
    }
}
?>
