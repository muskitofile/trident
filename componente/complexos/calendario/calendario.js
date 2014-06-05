calendario = null;
dataSetada = false;

var clicked = false;
var ajax;

function Dia(semana){
    this.semana = semana;
}

function Mes(dias){
    this.dias = dias;
}

function Ano(meses){
    this.meses = meses;
}

function Calendario(id,primeiroAno, intervaloAnos, primeiroSemana){
	this.data;
    this.id = id;
	this.popped = false;
    this.anoAtual;
    this.mesAtual;
    this.hoje;
    this.anos = new Array(intervaloAnos+1);
    this.semanas = new Array('Domingo','Segunda-feira','Terça-feira',
            'Quarta-feira','Quinta-feira','Sexta-feira','Sábado');
    this.nomesMeses = new Array('janeiro','fevereiro','março','abril','maio',
            'junho','julho','agosto','setembro','outubro','novembro','dezembro');
	this.hiding = hiding;
	this.showing = showing;
	this.settingData = settingData;
	this.show = showCalend;
	this.hide = hideCalend;
    
    var semanaAtual = primeiroSemana;
    for(var i=0;i<this.anos.length;i++){
        var meses = new Array(12);
        var qtd_dias;
        for(var j=0;j<meses.length;j++){
            if(j==3 || j==5 || j==8 || j==10) qtd_dias = 30;
            else if(j==1){
                if(bissexto(i+primeiroAno)) qtd_dias = 29;
                else qtd_dias = 28;
            }
            else qtd_dias = 31;
            var dias = new Array(qtd_dias);
            for(var k=0;k<dias.length;k++){
                dias[k] = new Dia(semanaAtual);
                semanaAtual=(semanaAtual+1)%7;
            }
            meses[j] = new Mes(dias);
        }
        this.anos[i] = new Ano(meses);
    }
    window.onclick = outterClick;
}

function avancaAno(){
    calendario.anoAtual++;
    atualizaMapa();
    enviarData("01/"+formato(calendario.mesAtual+1)+"/"+calendario.anoAtual);//calendario.anoAtual+"-"+formato(calendario.mesAtual+1)+"-01");
    return false;
}

function avancaMes(){
    calendario.mesAtual++;
    atualizaMapa();
    enviarData("01/"+formato(calendario.mesAtual+1)+"/"+calendario.anoAtual);//calendario.anoAtual+"-"+formato(calendario.mesAtual+1)+"-01");
    return false;
}

function voltaAno(){
    calendario.anoAtual--;
    atualizaMapa();
    enviarData("01/"+formato(calendario.mesAtual+1)+"/"+calendario.anoAtual);//calendario.anoAtual+"-"+formato(calendario.mesAtual+1)+"-01");
    return false;
}

function voltaMes(){
    calendario.mesAtual--;
    atualizaMapa();
    enviarData("01/"+formato(calendario.mesAtual+1)+"/"+calendario.anoAtual);//calendario.anoAtual+"-"+formato(calendario.mesAtual+1)+"-01");
    return false;
}

function bissexto(ano){
    if(ano%400==0) return true;
    else if(ano%100==0) return false;
    else if(ano%4==0) return true;
    else return false;
}

function formato(nr){
    if(nr<10) return "0"+nr;
    else return new String(nr);
}

function existeData(_data){
	
	var _dia = "", _mes = "", _ano = "";
	var valor = "";
	var char;
	
	(function(){
		for(var index in _data){
			char = _data.charAt(index);
			if(char=="/"){
				if(_dia.length==0) _dia = valor;
				else if(_mes.length==0) _mes = valor;
				valor = "";
			}
			else valor += char;
		}
		_ano = valor;
	})();
	
	while(_dia.length<2){_dia = "0"+_dia;}
	while(_mes.length<2){_mes = "0"+_mes;}
	while(_ano.length<4){_ano = "0"+_ano;}
	_data = _dia+"/"+_mes+"/"+_ano;
	
    if(_data.length!=10) return false;
    
	for(var i=0;i<10;i++){
		if(i==2 || i==5){
			if(_data.charAt(i)!='/'){
				return false;
			}
		}
		else if(_data.charAt(i)<'0' || _data.charAt(i)>'9'){
			return false;
		}
	}
    
    var ano = parseInt(_data.substring(6,10),10);
    var mes = parseInt(_data.substring(3,5),10);
    var dia = parseInt(_data.substring(0,2),10);
        
    if(ano<1950 || ano>2050){
        return false;
    }
    if(mes<1 || mes>12){
        return false;
    }

    var indice = ano-1950;
    var meses = calendario.anos[indice].meses;
    var dias = meses[mes-1].dias;
    if(dias.length>=dia){
		calendario.data = _data;
		return true;
	}
    else{
        return false;
    }
}

function atualizaMapa(){//id,dataAtual){

    var ano = calendario.anoAtual;
    var mes = calendario.mesAtual;
    
    if(mes>11){
        ano++;
        mes = mes%12;
    }
    else if(mes<0){
        ano--;
        mes += 12;
    }
    if(ano<1950) return false;
    else if(ano>2050) return false;

    calendario.anoAtual = ano;
    calendario.mesAtual = mes;
    
    var indice = ano-1950;
    var meses = calendario.anos[indice].meses;
    var dias = meses[mes].dias;
    var dia = dias[0].semana;

    var table = document.createElement("table"); // cria a tabela com os dias
    //table.className = "oculto";
    table.cellSpacing = 0;
    table.cellPadding = 0;

    cellMapa = document.getElementById("cellMapa"+calendario.id);
    if(cellMapa.childNodes.length>0) cellMapa.removeChild(cellMapa.firstChild);
	cellMapa.appendChild(table);
    
    cellAno = document.getElementById("cellAno"+calendario.id);
    if(cellAno.childNodes.length>0) cellAno.removeChild(cellAno.firstChild);
    cellAno.appendChild(document.createTextNode(ano));

    cellMes = document.getElementById("cellMes"+calendario.id);
    if(cellMes.childNodes.length>0) cellMes.removeChild(cellMes.firstChild);
    cellMes.appendChild(document.createTextNode(calendario.nomesMeses[mes]));

    var linhaTitulo = document.createElement("tr");
    table.appendChild(linhaTitulo);
    
//////////////// linha com os dias da semana ///////////////////////////
    var cell = document.createElement("td");
    linhaTitulo.appendChild(cell);
    var titulo = document.createTextNode("D");
    cell.appendChild(titulo);
    cell.style.border = "1px solid black";
    cell.style.textAlign = "center";
    cell.style.background = "lightblue";
    
    cell = document.createElement("td");
    linhaTitulo.appendChild(cell);
    titulo = document.createTextNode("S");
    cell.appendChild(titulo);
    cell.style.border = "1px solid black";
    cell.style.textAlign = "center";
    cell.style.background = "lightgray";
    
    cell = document.createElement("td");
    linhaTitulo.appendChild(cell);
    titulo = document.createTextNode("T");
    cell.appendChild(titulo);
    cell.style.border = "1px solid black";
    cell.style.textAlign = "center";
    cell.style.background = "lightgray";

    cell = document.createElement("td");
    linhaTitulo.appendChild(cell);
    titulo = document.createTextNode("Q");
    cell.appendChild(titulo);
    cell.style.border = "1px solid black";
    cell.style.textAlign = "center";
    cell.style.background = "lightgray";

    cell = document.createElement("td");
    linhaTitulo.appendChild(cell);
    titulo = document.createTextNode("Q");
    cell.appendChild(titulo);
    cell.style.border = "1px solid black";
    cell.style.textAlign = "center";
    cell.style.background = "lightgray";

    cell = document.createElement("td");
    linhaTitulo.appendChild(cell);
    titulo = document.createTextNode("S");
    cell.appendChild(titulo);
    cell.style.border = "1px solid black";
    cell.style.textAlign = "center";
    cell.style.background = "lightgray";

    cell = document.createElement("td");
    linhaTitulo.appendChild(cell);
    titulo = document.createTextNode("S");
    cell.appendChild(titulo);
    cell.style.border = "1px solid black";
    cell.style.textAlign = "center";
    cell.style.background = "lightblue";
////////////////////////////////////////////////////////////////////////

    var linha = null;
    var cell;
    for(var i=0;i<dia;i++){
        cell = document.createElement("td");
        if(i==0){
            linha = document.createElement("tr");
            table.appendChild(linha);
        }
        cell.appendChild(document.createTextNode(""));
		cell.className = "out";
        linha.appendChild(cell);
    }
    var aux = null;
    for(var i=0;i<dias.length;i++){
        cell = document.createElement("td");
        if(dias[i].semana==0) linha = document.createElement("tr");
        cell.appendChild(document.createTextNode(i+1));
        cell.title = formato(i+1)+"/"+formato(mes+1)+"/"+ano;//ano+"-"+formato(mes+1)+"-"+formato(i+1);
        cell.className = "calend";
        cell.onclick = setData;
        linha.appendChild(cell);
        if(dias[i].semana==6) table.appendChild(linha);
        aux = dias[i].semana;
        if(cell.title==calendario.hoje) cell.className = "hoje"; // enviar junto com a página PHP a variável "hoje"
    }
    aux = (aux+1)%7;
    while(aux>0 && aux<7){
        cell = document.createElement("td");
        cell.appendChild(document.createTextNode(""));
		cell.className = "out";
        linha.appendChild(cell);
        table.appendChild(linha);
        aux++;
    }
}

var showCalend = function(){
	if(!calendario.popped){
		atualizaMapa();
		var divCal = document.getElementById('div_table'+calendario.id);
		divCal.style['display'] = 'inline';
		calendario.popped = true;
		clicked = true;
	}
	calendario.showing();
}

function hideCalend(){
	if(calendario.popped){
		atualizaMapa();
		document.getElementById('div_table'+calendario.id).style['display'] = 'none';
		calendario.popped = false;
		clicked = false;
	}
	calendario.hiding();
}

function clickMe(){
    clicked = true;
}

function outterClick(e){
    if(calendario.popped && !clicked){
        if(e.target.id!="calendario"+calendario.id)
            calendario.hide();
    }
    clicked = false;
}

function setData(event){
	dataSetada = true;
	calendario.data = event.currentTarget.title;
	enviarData(event.currentTarget.title);
	calendario.settingData();
}
// podem ser implementadas externamente atraves de "calendario.settingData" e "calendario.hiding";
function settingData(){}
function hiding(){}
function showing(){}

function enviarData(data){
    calendario.anoAtual = parseInt(data.substring(6,10),10);
    calendario.mesAtual = parseInt(data.substring(3,5),10)-1;
    ajax = criaAjax();
    var mes = "";
    if(ajax!=null){
        if(calendario.mesAtual<9) mes = "0"+(calendario.mesAtual+1);
        else mes = ""+(calendario.mesAtual+1);
        ajax.open("GET","componente1/complexos/calendario/set_data_calendario.php?ano="+calendario.anoAtual+"&mes="+mes+"&dia="+data.substring(0,2),true);
        ajax.send(null);
    }
    else{
        alert("Impossível criar objeto XMLHttpRequest.");
    }
}