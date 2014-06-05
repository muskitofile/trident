<?php

class Menu extends Element {

    public $script;
    public $estilo;

    public function __construct() {
        parent::__construct("ul");
        $this->script = parent::addBrother(new Script());
        $this->estilo = parent::addBrother(new Style());
        if (func_num_args() > 0)
            $this->id = func_get_arg(0);
    }

    public function addItem() {
        $args = func_get_args();
        if (func_num_args() == 2) {
            return parent::add(new ListItem(new Anchor($args[0], $args[1])));
        } else {
            return parent::add(new ListItem(new Anchor($args[0])));
        }
    }

    public function addSubmenu($item) {
        return $item->add(new Menu());
    }
}
?>