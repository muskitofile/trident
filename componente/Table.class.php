<?php

class Table extends Element{
    
    private $rows;
    private $last = -1;
    private $lastCell;
    private $lastRow;
	
    public function __construct(){
        parent::__construct("table");
        if(func_num_args()>0){
            $id = func_get_arg(0);
            parent::__set("id",$id);
        }
    }
    
    public function addRow(){
        $this->lastRow = new Row();
        $this->rows[] = $this->lastRow;
        $this->last++;
        return parent::add($this->lastRow);
    }
        
    public function getRows(){
        return $this->rows;
    }
    
    public function addCell(){
        if(func_num_args()>0){
            if(func_num_args()>1){
                if(func_get_arg(1)=="cell"){
                    $this->lastCell = $this->rows[$this->last]->add(new Cell(func_get_arg(0)));
                    return $this->lastCell;
                }
                else if(func_get_arg(1)=="content"){
                    $this->lastCell = $this->rows[$this->last]->add(new Cell(func_get_arg(0)));
                    return func_get_arg(0);
                }
            }
            else{
                $this->lastCell = $this->rows[$this->last]->add(new Cell(func_get_arg(0)));
                return $this->lastCell;
            }
        }
        else{
            $this->lastCell = $this->rows[$this->last]->add(new Cell());
            return $this->lastCell;
        }
    }
    
    function lastCell(){
        return $this->lastCell;
    }
    
}
?>