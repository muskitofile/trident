function Elo(linha){
	this.linha = linha;
	this.valor = null;
	this.anterior = null;
	this.proximo = null;
}

function Fila(){
	this.primeiro = null;
	this.tamanho = 0;
	this.insereElo = insereElo;
	this.insereNoFim = insereNoFim;
	this.insereNoInicio = insereNoInicio;
	this.insereCrescente = insereCrescente;
        this.insereDecrescente = insereDecrescente;
	this.removeDoInicio = removeDoInicio;
}

function insereElo(elo,posicao){// primeira posicao eh 0
	if(posicao>this.tamanho) return false;
	else if(posicao === this.tamanho){
		this.insereNoFim(elo);
		return true;
	}
	else if(posicao===0){
		this.insereNoInicio(elo);
		return true;
	}
	else{
		var i=0;
		var aux = null;
		if(this.primeiro === null) return false;
		aux = this.primeiro;
		while(i<posicao){
			aux = aux.proximo;
		}
		if(aux!==null){
			var aux2 = aux.anterior;
			this.primeiro = elo;
			aux2.proximo = elo;
			aux.anterior = elo;
			elo.anterior = aux2;
			elo.proximo = aux;
			this.tamanho++;
			return true;
		}
		else return false;
	}
}

function insereNoInicio(elo){
	if(this.primeiro===null) this.primeiro = elo;
	else{
		var aux = this.primeiro;
		this.primeiro = elo;
		elo.proximo = aux;
		aux.anterior = elo;
	}
	this.tamanho++;
}

function insereNoFim(elo){
	if(this.primeiro===null) this.primeiro = elo;
	else{
		var aux = this.primeiro;
		while(aux.proximo !== null){
			aux = aux.proximo;
		}
		aux.proximo = elo;
		elo.anterior = aux;
	}
	this.tamanho++;
}

function insereDecrescente(elo){
	aux = this.primeiro;
	while(aux !== null){
		if(elo.valor.nodeValue < aux.valor.nodeValue){
			aux = aux.proximo;
		}
		else break;
	}
	if(aux === null){
		this.insereNoFim(elo);
		return true;
	}
	else{
		var anterior = aux.anterior;
		elo.anterior = anterior;
		if(anterior !== null) anterior.proximo = elo;
		aux.anterior = elo;
		elo.proximo = aux;
		if(aux===this.primeiro) this.primeiro = elo;
		return true;
	}
	return false;
}

function insereCrescente(elo){
	aux = this.primeiro;
	while(aux !== null){
		if(elo.valor.nodeValue > aux.valor.nodeValue){
			aux = aux.proximo;
		}
		else break;
	}
	if(aux === null){
		this.insereNoFim(elo);
		return true;
	}
	else{
		var anterior = aux.anterior;
		elo.anterior = anterior;
		if(anterior !== null) anterior.proximo = elo;
		aux.anterior = elo;
		elo.proximo = aux;
		if(aux===this.primeiro) this.primeiro = elo;
		return true;
	}
	return false;
}

function removeDoInicio(){
	var aux = this.primeiro;
	if(this.primeiro!==null){
		this.primeiro = this.primeiro.proximo;
		if(this.primeiro!==null) this.primeiro.anterior = null;
		return aux;
	}
	else return false;
}

function ordenaTable(tabela,index,celula){
        var estado = celula.className;
	var linhas = tabela.getElementsByTagName("tr");
	var cabecalho = linhas[0];
	var fila = new Fila();
	var elo;
        var celulas;
        var img;
        if(estado==="no-order" || estado==="desc"){
            for(var i=1;i<linhas.length;i++){
                    elo = new Elo(linhas[i]);
                    celulas = linhas[i].getElementsByTagName("td");
                    elo.valor = celulas[index].childNodes[0];
                    fila.insereCrescente(elo);
            }
            celula.className = "ascend";
            img = celula.getElementsByTagName("img")[0];
            img.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gUKADsSjLYmmwAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAA6ElEQVQ4y92UPQrCQBCFv/EPtfZCHsATKNh4DK9hb+U9cgGbVDFFrELSRIuAEIW10JU1JJkgFuKDV+3bj92dmRVjDN9Uhy/rT4DyUFdEZmrYGKMaEGAOnIFJY7YFDKAHHAAD7FvkVS2fMOtpbTKKIg3WB4oS8FgVjOP4ceUkSZqA2xLMelE+2NsbpmlaBRsA1xrgyYbCMKwuSpZlZeCuBma9DoKgucqORsBNAV6Anru/qbFXQFcp2BDY1Da2ozEQK6ezvrnNLi5IRD6aX5fR0cYwz/PXuud5+nS0meWiKPB9v1VWfv7HvgN2k1q5vnvLWwAAAABJRU5ErkJggg==";
        }
        else {
            for(var i=1;i<linhas.length;i++){
                    elo = new Elo(linhas[i]);
                    celulas = linhas[i].getElementsByTagName("td");
                    elo.valor = celulas[index].childNodes[0];
                    fila.insereDecrescente(elo);
            }
            celula.className = "desc";
            img = celula.getElementsByTagName("img")[0];
            img.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gUKADoz2cQHhAAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAlUlEQVQ4y2NgGAWUAkYq6f1PSLEIAwPDbwYGhn9Q/B8PfsrAwMBJjAtmETDoP9SybGK9xMrAwPCdgGG/GRgYOJA1MeEx8DcDA0MbAUtXMjAw/CA18N/jcN0vBgYGFnJiMwZHxMynJHndRzP0FzSMyQYOaAbGUyMTnIUaeovcsEMHwtAIiqYwh6EAHwYGBmZqGjgKMAEAnHI7spRrydsAAAAASUVORK5CYII=";
            
        }
	var aux = fila.primeiro;
        var tds = cabecalho.getElementsByTagName("td");
        for(i=0;i<tds.length;i++){
            if(i!==index && tds[i].className !== "action"){
                tds[i].className = "no-order";
                img = tds[i].getElementsByTagName("img")[0];
                img.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gUJATkmjEN1dQAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAFUlEQVQ4y2NgGAWjYBSMglEwCqgDAAZUAAFDhx+cAAAAAElFTkSuQmCC";
            }
        }
        var tbody = tabela.tBodies[0];
	tbody.appendChild(cabecalho);
	aux = fila.primeiro;
	var novaLinha;
	while(aux !== null){
		novaLinha = fila.removeDoInicio().linha;
		tbody.appendChild(novaLinha);
		aux = fila.primeiro;
	}
}
















