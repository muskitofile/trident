<?php

class Paragraph extends Element{
	
    public function __construct() {
        parent::__construct("p");
        if (func_num_args() == 1) {
            parent::add(func_get_arg(0));
        }
    }

    public function add($child) {
        if (is_object($child) and $child->getTag() == "a")
            $child->no_indent = true;
        return parent::add($child);
    }
}
?>
