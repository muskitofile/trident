<?php

class Header extends Element{
	
	public function __construct(){
            if(func_num_args()>0){
		if(func_num_args()==2 and is_numeric(func_get_arg(0))){
			parent::__construct("h".func_get_arg(0));
			parent::add(func_get_arg(1));
		}
		else{
                    if(is_numeric(func_get_arg(0))){
			parent::__construct("h".func_get_arg(0));
                    }
                    else{
                        parent::__construct("h3");
                        parent::add(func_get_arg(0));
                    }
		}
            }
            else{
                parent::__construct("h3");
            }
	}
}
?>