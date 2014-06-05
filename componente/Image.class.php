<?php

class Image extends Element{

    public function __construct(){
        parent::__construct("img");
        if(func_num_args()==1){
            $valor = func_get_arg(0);
            parent::__set("src",$valor);
        }
    }
    
    public function setSrc($src){
        if(is_string($src)) parent::__set($src);
    }
}
?>