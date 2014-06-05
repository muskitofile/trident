<?php

class Accordion extends Element {

    public $script;
    public $estilo;
    public $id;
    private $actualSect;

    public function __construct() {
        parent::__construct("div");
        $this->script = parent::addBrother(new Script());
        $this->estilo = parent::addBrother(new Style());
        if (func_num_args() > 0) {
            $this->id = func_get_arg(0);
            parent::__set("id", $this->id);
        }
    }

    public function addSect() {
        $args = func_get_args();
        if (sizeof($args) > 0) {
            parent::add(new Header($args[0]));
            $div = parent::add(new Div());
            $div->id = $this->id . "-" . $args[0];
            $this->actualSect = $div;
            if (sizeof($args) == 2)
                return $div->add($args[1]);
        }
    }

    public function addToActualSect($child) {
        return $this->actualSect->add($child);
    }

}

?>