<?php

class Select extends Element{
    
    private $groups;
        
    public function __construct(){
        parent::__construct("select");
        if(func_num_args()>0){
            $name = func_get_arg(0);
            parent::__set("name",$name);
        }
    }
    
    
    /* o Método abaixo adiciona um item à lista (<option/>) sendo que, dependendo
     * da natureza ou quantidade de argumentos passados, o item terá os seguintes
     * tratamentos:
     * (1) - O argumento é uma única string: o item terá o valor e o texto iguais à string 
     *      e não fará parte de nenhum selectgroup.
     * (2) - O argumento são duas strings: o item terá a primeira string como valor e a 
     *      segunda como texto e não fará parte de nenhum selectgroup.
     * (3) - O argumento são três strings: o item terá a primeira string como valor, a segunda como texto
     *      e a terceira será o selectgroup.
     * (4) - O argumento é um vetor...
     *      a) ... de uma string: o mesmo que em (1).
     *      b) ... de duas strings: o mesmo que em (2).
     *      c) ... de três strings: o mesmo que em (3).
     */
    public function addItem(){
        $novo = new Element("option");
        $value = func_get_arg(0);
        if(!is_array($value)){// o argumento não é um vetor
            $novo->value = $value;
            if(func_num_args()>=2){// o item possui valor e texto
                $novo->add(func_get_arg(1));
                $novo->title = func_get_arg(1);
                if(func_num_args()==3){
                    $group = $this->addGroup(func_get_arg(2));
                    $group->addItem($novo);
                }
                else parent::add($novo);
            }
            else{
                $novo->add($value);
                $novo->title = $value;
                parent::add($novo);
            }
        }
        else{  // o argumento é um vetor
            $novo->value = $value[0];
            if(isset($value[1])){ // o vetor tem pelo menos duas strings
                $novo->add($value[1]);
                $novo->title = $value[1];
                if(isset($value[2])){ // o vetor tem as três strings
                    if(!isset($this->groups[$value[2]]))
                        $this->addGroup($value[2]);
                    $this->groups[$value[2]]->addItem($novo);
                }
                else parent::add($novo); // o vetor só tem duas strings
            }
            else{ // o vetor é uma única string
                $novo->add($value[0]);
                $novo->title = $value[0];
                parent::add($novo);
            }
        }
        return $novo; // retorna o item recém-criado
    }

    public function addSelectedItem(){
        $novo = $this->addItem(func_get_arg(0));
        $novo->selected = "selected";
        return $novo;
    }

    public function setSelectedItem($index){ // case-sensitive
        $children = parent::getChildren();
        $items = array();
        foreach($children as $child){
            if(get_class($child)=="SelectGroup"){
                $subitems = $child->getChildren();
                foreach ($subitems as $subitem) {
                    $items[] = $subitem;
//                    echo $subitem->show();
                }
            }
            else{
                $items[] = $child;
//                echo $child->show();
            }
        }
        if(is_numeric($index) and $index<sizeof($items)){
            foreach ($items as $item) {
                $item->selected = "UNDEFINED";
//                echo $item->show();
            }
            $items[$index]->selected = "selected";
        }
        else if(is_string($index)){ // index é o valor ou o rótulo do item
            foreach ($items as $item) {
                $item->selected = "UNDEFINED";
//                echo $item->show();
                $item_children = $item->getChildren();
                if($item->get("value")==$index or $item_children[0]==$index){
                    $item->selected = "selected";
                }
            }
        }
    }

    public function addItems($items){
        //$vetor = array();
        foreach ($items as $item) {
            $this->addItem($item);
            //$vetor[] = $item;
        }
        return $items;//$vetor;
    }
    
    public function addGroup($groupName){
        if(is_string($groupName)){
            $novo = new SelectGroup($groupName);
            parent::add($novo);
            $this->groups[$groupName] = $novo;
            return $novo;
        }
    }
}
?>