<?php


class Head extends Element {

    public function __construct() {
        parent::__construct("head");
        if (func_num_args() > 0) {
            $title = new Element("title");
            $title->add(func_get_arg(0));
            parent::add($title);
        }
    }

    public function addScriptLink($href) {
        $script = new Element("script");
//        $script->type = "text/javascript";
        $script->src = $href;
        parent::add($script);
        return $script;
    }

    public function addStyleLink($href) {
        $style = new Element("link");
        $style->rel = "stylesheet";
        $style->type = "text/css";
        $style->href = $href;
        parent::add($style);
        return $style;
    }

}

?>