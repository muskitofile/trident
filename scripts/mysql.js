proibidos = new Array("'",";");
permitidos = new Array("´","");

function sanitize(str){
	//if(str==undefined || str==null) return;
	var saida = str;
	var index;
	for(var i=0;i<proibidos.length;i++){
		index = str.indexOf(proibidos[i]);
		if(index>=0){
			saida = str.substring(0,index)+permitidos[i]+
				sanitize(str.substring(index+proibidos[i].length,str.length));
			console.log("index: "+index);
		}
	}
	console.log("novo value: "+saida);
	return saida;
}

function sanitizeForMysql(form){
	/*var inputs = new Array();
	var formInputs = form.childNodes;
	alert(form+": "+form.childNodes);
	for(var i=0;i<formInputs.length;i++){
		if(formInputs[i].tagName=="input") inputs.push(formInputs[i]);
	}*/
	var inputs = form.getElementsByTagName("input");
	for(var i=0;i<inputs.length;i++){
		if(inputs[i].type=="text") inputs[i].value = sanitize(inputs[i].value);
		else if(inputs[i].type=="password") inputs[i].value = sanitize(inputs[i].value);
	}
	var opts = form.getElementsByTagName("option");
	for(i=0;i<opts.length;i++){
		if(opts[i].selected) opts[i].value = sanitize(opts[i].value);
	}
	var areas = form.getElementsByTagName("textarea");
	for(i=0;i<areas.length;i++){
		areas[i].innerText = sanitize(areas[i].innerText);
	}
}