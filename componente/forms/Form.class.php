<?php

class Form extends Element{
	
    function __construct(){
        parent::__construct("form");
        if(func_num_args()>0){
            $id = func_get_arg(0);
            parent::__set("id",$id);
        }
    }
    
    
    private function addInput($type,$name){
        switch ($type){
            case "text":        $input = new Text($name); break;
            case "password":    $input = new Password($name); break;
            case "hidden":      $input = new Hidden($name); break;
            case "button":      $input = new Button($name); break;
            case "submit":      $input = new Submit($name); break;
            case "reset":       $input = new Reset($name); break;
            case "radio":       $input = new Radio($name); break;
            case "checkbox":    $input = new CheckBox($name); break;
            case "select":      $input = new Select($name); break;
            case "textarea":    $input = new TextArea($name); break;
            case "file":        $input = new File($name); break;
        }
        $input->name = $name;
        $input->id = $name.$this->cont++;
        parent::add($input);
        return $input;
    }
    
    public function addText($name){
        return $this->addInput("text",$name);
    }
    
    public function addPassword($name){
        return $this->addInput("password",$name);
    }
    
    public function addHidden($name){
        return $this->addInput("hidden",$name);
    }

    public function addButton($name){
        return $this->addInput("button",$name);
    }
    
    public function addSubmit($name){
        return $this->addInput("submit",$name);
    }
    
    public function addReset($name){
        return $this->addInput("reset",$name);
    }
    
    public function addRadio($name){
        return $this->addInput("radio",$name);
    }
    
    public function addCheckBox($name){
        return $this->addInput("checkbox",$name);
    }
    
    public function addSelect($name){
        return $this->addInput("select",$name);
    }
    
    public function addTextArea($name){
        return $this->addInput("textarea",$name);
    }
    
    public function addFile($name){
        return $this->addInput("file",$name);
    }
} 
?>