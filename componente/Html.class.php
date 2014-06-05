<?php
class Html extends Element {

    private $head;
    private $body;

    public function __construct() {
        parent::__construct("html");
        if (func_num_args() > 0)
            $this->head = new Head(func_get_arg(0));
        else
            $this->head = new Head();
        parent::add($this->head);
        $this->body = new Element("body");
        parent::add($this->body);
    }
    
    public function add($child){
        return $this->body->add($child);
    }

    public function getHead() {
        return $this->head;
    }

    public function getBody() {
        return $this->body;
    }

}

?>