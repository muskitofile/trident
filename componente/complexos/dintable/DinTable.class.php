<?php
//include_once 'componente1/Table1.class.php';
//include_once 'componente1/Script1.class.php';
//include_once 'componente1/Style1.class.php';
//include_once 'componente1/Image1.class.php';

class DinTable extends Table {

	public $header;
        private $cont = 0;
        private $script;
        private $estilo;
        private $divProps;

	public function  __construct(){
                parent::__construct();
                if(func_num_args()>0){
                    $id = func_get_arg(0);
                    parent::__set("id",$id);
                }
		$this->script = new Script();
                $this->estilo = new Style();
                $this->header = parent::addRow();
                $this->header->class = "header";
                parent::__set("class","dintable");
//                parent::__set("border","1");
	}
        
	public function addSortHeaderCell($child){
		$cell = $this->header->addCell($child);
		$cell->onclick = "ordenaTable(".
				parent::get("id").",".(sizeof($this->header->getChildren())-1).",this)";
                $cell->class = "no-order";
		$cell->add(new Image("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gUJATkmjEN1dQAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAFUlEQVQ4y2NgGAWjYBSMglEwCqgDAAZUAAFDhx+cAAAAAElFTkSuQmCC"));
                $cell->title = "Clique para classificar por esta coluna";
		return $cell;
	}
        
        public function addHeaderCell($child){
		$cell = $this->header->addCell($child);
                $cell->class = "action";
                return $cell;
	}

	public function addCell(){
            if($this->cont >= sizeof($this->header->getChildren()) or
                    sizeof(parent::getRows()) == 1){
//                echo " rows ".sizeof(parent::getRows());
//                echo " header ".sizeof($this->header);
                $this->cont = 0;
                parent::addRow();
            }
            $this->cont++;
            if(func_num_args()>0){
                $arg1 = func_get_arg(0);
                if(func_num_args()>1){
                    $arg2 = func_get_arg(1);
                    return parent::addCell($arg1,$arg2);
                }
                else return parent::addCell($arg1);
            }
            else return parent::addCell();
	}
        
        public function setScriptSrc($src){
            $this->script->addSrc($src);
        }
        
        public function setStyleHref($href){
            $this->estilo->addHref($href);
        }
        
        public function toString() {
            $texto = "";
            $texto .= $this->estilo->toString();
            $texto .= $this->script->toString();
            $texto .= parent::toString();
            return $texto;
        }
        
        public function toStringFormat() {
            $texto = "";
            $texto .= $this->estilo->toStringFormat();
            $texto .= $this->script->toStringFormat();
            $texto .= parent::toStringFormat();
            return $texto;
        }
}
?>