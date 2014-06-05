<?php

class Style extends Element {

    public function __construct() {
        parent::__construct("style");
        if (func_num_args() > 0) {
            $link = new Element("link");
            $link->rel = "stylesheet";
            $link->href = func_get_arg(0);
            parent::addBrother($link);
        }
    }

    public function addHref($href) {
        $link = new Element("link");
        $link->rel = "stylesheet";
        $link->href = $href;
        parent::addBrother($link);
    }

    public function addRegra($regra) {
        parent::add("\n" . $regra . "\n");
    }
}

?>