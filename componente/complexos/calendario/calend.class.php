<?php

class Calendario extends Element{

    private $cellAno;
    private $cellMes;
    private $cellMapa;
    private $divInt;
    private $styleLink;
    private $scriptLink;

	function __construct($id){
		parent::__construct("div");
		$this->class = "calend";
        $this->style['position'] = "relative";
		$this->style['display'] = "inline";
		parent::__set("id","calendario".$id);
        $this->onclick = "clickMe()";
        
        $this->styleLink = new Element("link");
        $this->styleLink->rel = "stylesheet";
        $this->styleLink->type = "text/css";
        $this->styleLink->href = "componente/complexos/calendario/calendario.css";
        parent::add($this->styleLink);
        
        $this->scriptLink = new Script("componente/complexos/calendario/calendario.js");
		$exe = "
calendario = new Calendario('{$id}',1950,100,0);
";
		if(isset($_SESSION['mes']))
			$exe .= "calendario.mesAtual = parseInt('".$_SESSION['mes']."')-1;
calendario.anoAtual = '".$_SESSION['ano']."';
";
		else $exe .= "calendario.mesAtual = parseInt('".Conexao1::direct("select month(now())")."')-1;
calendario.anoAtual = '".Conexao1::direct("select year(now())")."';
";
		$hoje = Conexao1::direct("select date(now())");
		$exe .= "calendario.hoje = '".substr($hoje,8,2)."/".substr($hoje,5,2)."/".substr($hoje,0,4)."';
//atualizaMapa();";
		$this->scriptLink->addExe($exe);
        parent::add($this->scriptLink);
		
		$this->divInt = new Element("div");
		$this->divInt->id = "div_table".$id;
        $this->divInt->class = "div_table";
        //$this->divInt->style['display'] = "none";
        //$this->divInt->style['position'] = "absolute";
		parent::add($this->divInt);
		
		$tableMae = new Table();
		$tableMae->cellspacing = "0";
		$tableMae->class = "mae";
        $this->divInt->add($tableMae);
        $row = $tableMae->addRow();
        $botaoVoltaAno = new Button();
        $botaoVoltaAno->value = "<<";
        $botaoVoltaAno->onclick = "voltaAno()";
		$botaoVoltaAno->class = "ctrl";
        $row->addCell($botaoVoltaAno);
		$this->cellAno = $row->addCell("");
		$this->cellAno->id = "cellAno".$id;
        $this->cellAno->style['text-align'] = "center";
        $botaoAvancaAno = new Button();
        $botaoAvancaAno->value = ">>";
        $botaoAvancaAno->onclick = "avancaAno()";
		$botaoAvancaAno->class = "ctrl";
        $cell = $row->addCell($botaoAvancaAno);
        $cell->style['text-align'] = "right";

        $row = $tableMae->addRow();
        $botaoVoltaMes = new Button();
        $botaoVoltaMes->value = "<";
        $botaoVoltaMes->onclick = "voltaMes()";
		$botaoVoltaMes->class = "ctrl";
        $row->addCell($botaoVoltaMes);
        $this->cellMes = $row->addCell("");
        $this->cellMes->id = "cellMes".$id;
        $this->cellMes->style['text-align'] = "center";
        $botaoAvancaMes = new Button();
        $botaoAvancaMes->value = ">";
        $botaoAvancaMes->onclick = "avancaMes()";
		$botaoAvancaMes->class = "ctrl";
        $cell = $row->addCell($botaoAvancaMes);
        $cell->style['text-align'] = "right";

        $row = $tableMae->addRow();
        $this->cellMapa = $row->addCell("");
        $this->cellMapa->id = "cellMapa".$id;
        $this->cellMapa->colspan = "3";
	}
	
    public function __set($property,$value){
        if($property!="id") parent::__set($property,$value);
    }
    
    public function setStyleLink($href){
        $this->styleLink->href = $href;
    }
    
    public function setScriptLink($src){
        $this->scriptLink->src = "$src";
    }
}