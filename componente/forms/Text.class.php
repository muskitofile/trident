<?php

class Text extends Input{
	
    public function __construct(){
        parent::__construct("text");
        if(func_num_args()>0){
            $name = func_get_arg(0);
            parent::__set("name",$name);
        }
    }
}
?>
