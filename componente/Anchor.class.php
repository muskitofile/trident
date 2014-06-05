<?php

class Anchor extends Element {

    public function __construct() {
        parent::__construct("a");
        if (func_num_args() == 2) {
            $this->href = func_get_arg(0);
            parent::add(func_get_arg(1));
        } else if (func_num_args() == 1) {
            $this->href = "#";
            parent::add(func_get_arg(0));
        }
    }

}

?>