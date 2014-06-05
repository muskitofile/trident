<?php
class Element{
    
    private $indent = 0;
    private $tag;
    private $properties;
    public  $style;
    private $children;
    private $brothers;
//    private $no_indent;
//    private $no_newline_tags = array("a","td","b","u","i","span","quot","label","strong","big","small");
//    private $no_break_tags = array("td","p","option","span","b","i","u","li","strong","big","small","meta",
//                            "a","label","title","h1","h2","h3","h4","h5","h6");
    private $no_close_tags = array("br","input","link","meta","img");
    
    public function __construct($nome){
        $this->tag = strtolower($nome);
    }
	
    public function add($child){
        $this->children[] = $child;
        if(is_object($child)) $child->setIndent($this->indent+1);
	return $child;
    }
    
    public function addBrother($brother){
        $this->brothers[] = $brother;
        if(is_object($brother)) $brother->indent = $this->indent;
        return $brother;
    }
	
    public function __set($property,$value){
        $property = strtolower($property);
        if($property=="style") return;
        else if($property=="indent"){
            $this->setIndent($value);
        }
        else if($property=="no_indent"){
            $this->no_indent = $value;
        }
        else if($value!="UNDEFINED" and $value!="undefined") {
            $this->properties[$property] = $value;
        }
    }
    
    public function __get($property){
        if($property=="indent") return $this->indent;
    }

    public function setIndent($value){
        $this->indent = $value;
        if ($this->brothers) {
            foreach ($this->brothers as $brother) {
                if (is_object($brother))
                    $brother->setIndent($value);
            }
        }
        if ($this->children) {
            foreach ($this->children as $child) {
                if (is_object($child))
                    $child->setIndent($value + 1);
            }
        }
    }
    
    private function open(){
        $texto = "";
        if($this->tag=="html") $texto .= "<!DOCTYPE html>\n";
        $texto .= "<".$this->tag/*." indent=\"".$this->indent."\""*/;
        if(isset($this->properties)){
            foreach($this->properties as $prop=>$value){
                if(isset($value) and $value!="") $texto .= " ".$prop."=\"".$value."\"";
                else $texto .= " ".$prop;
            }
        }
        if(sizeof($this->style)>0){
            $texto .= " style=\"";
            foreach ($this->style as $key=>$value) {
                $texto .= $key.": ".$value."; ";
            }
            $texto .= "\" ";
        }
        $noclose = false;
        foreach($this->no_close_tags as $tag){
            if($this->tag==$tag){
                $noclose = true;
                break;
            }
        }
        if($noclose) $texto .= "/>";
        else $texto .= ">";
        return $texto;
    }
    
    private function close(){
        
        $texto = "";
        $close = true;
        foreach($this->no_close_tags as $tag){
            if($this->tag == $tag){
                $close = false;
                break;
            }
        }
        if($close) $texto .= "</{$this->tag}>";
        return $texto;
    }
    
    public function toString(){
        $texto = "";
        if($this->brothers){
            foreach ($this->brothers as $brother){
                $texto .= $brother->toString();
            }
        }
        $texto .= $this->open();
        if($this->children){
            foreach($this->children as $child){
                if(is_object($child)) $texto .= $child->toString();
                else if(is_string($child) or is_numeric($child)) $texto .= $child;
            }
        }
        $texto .= $this->close();
        return $texto;
    }
    
    public function toStringFormat(){
        $texto = "";
        if($this->brothers){
            foreach ($this->brothers as $brother){
                $texto .= $brother->toString();
            }
        }
        $texto .= $this->showIndent();
        $texto .= $this->open();
        if($this->children){
            foreach($this->children as $child){
                if(is_object($child)) $texto .= $child->toStringFormat();
                else if(is_string($child) or is_numeric($child)) 
                    $texto .= $this->showIndent()."  ".$child;
            }
        }
        $close = true;
        foreach($this->no_close_tags as $tag){
            if($this->tag == $tag){
                $close = false;
                break;
            }
        }
        if($close) $texto .= $this->showIndent();
        $texto .= $this->close();
        return $texto;
    }
    
    public function showIndent(){
//        if($this->no_indent) return "";
        $ind = "\n";
        for($i=0;$i<$this->indent;$i++){
            $ind .= "  ";
        }
        return $ind;
    }
    
    public function show(){
        echo $this->toStringFormat();
    }
    
    public function getChildren(){
        if(isset($this->children)) return $this->children;
    }
    
    public function getBrothers(){
        if($this->brothers) return $this->brothers;
    }

    public function get($property){
        if(isset($this->properties[$property])) return $this->properties[$property];
        else return null;
    }
    
    public function getTag(){
        return $this->tag;
    }
	
    public function toArrayJson(){
            if($this->style) $this->properties["style"] = $this->style;
            $vetor = array(
                "tag" => $this->tag,
                "properties" => $this->properties
            );
            if($this->children){
                $children = array();
                foreach($this->children as $child){
                    if(is_numeric($child)){
                        $children[] = array("tag" => "number", "value" => $child);
                    }
                    else if(is_string($child)){
                        $children[] = array("tag" => "textNode", "value" => $child);
                    }
                    else if(is_object($child)){
                        $brothers = $child->getBrothers();
                        if($brothers){
                            foreach ($brothers as $brother){
                                $children[] = $brother->toArrayJson();
                            }
                        }
                        $children[] = $child->toArrayJson();
                    }
                }
                $vetor["children"] = $children;
            }
            return $vetor;
    }
    
}