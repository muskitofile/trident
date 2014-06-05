<?php

class Script extends Element{
	
    private $srcs = array();
    private $exes = array();

    public function __construct() {
        parent::__construct("script");
        if (func_num_args() > 0)
            $this->srcs[] = func_get_arg(0);
    }

    public function addSrc($src) {
        $this->srcs[] = $src;
    }

    public function addExe($exe) {
        $this->exes[] = $exe;
    }

    public function toString() {
        $texto = "";
        foreach ($this->srcs as $src) {
            $texto .= "<script src=\"" . $src . "\"></script>\n";
        }
        if (sizeof($this->exes) > 0) {
            $texto .= "<script>\n";
            foreach ($this->exes as $exe) {
                $texto .= $exe . "\n\n";
            }
            $texto .= "</script>\n";
        }
        return $texto;
    }

    public function toStringFormat() {
        $texto = "";
        foreach ($this->srcs as $src) {
            $texto .= $this->showIndent();
            $texto .= "<script src=\"" . $src . "\"></script>";
        }
        if (sizeof($this->exes) > 0) {
            $texto .= $this->showIndent();
            $texto .= "<script>";
            foreach ($this->exes as $exe) {
                $texto .= $exe . "\n\n";
            }
            $texto .= $this->showIndent();
            $texto .= "</script>";
        }
        return $texto;
    }

}

?>