function criaAjax(){
    var xmlHttp=null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch(e)
    {
        //Internet Explorer
        try{
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e){
            try{xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}
            catch(e){}
        }
    }
    return xmlHttp;
}

function criaAjaxEnviaForm(url,form){
    var ajax = criaAjax();
    if(ajax!==null){
        var divUsuario = document.createElement("div");
        var dialogStrt;
        var dialog;
        ajax.onreadystatechange = function(){
            if(ajax.readyState===1){
                divUsuario.appendChild(document.createTextNode("Aguarde o carregamento."));
                divUsuario.style.fontSize = "9pt";
                divUsuario.style.fontFamily = "Arial";
                dialogStrt = {
                    modal: true,
                    autoOpen: true,
                    title: "Carregando...",
                    width: "600px",
                    close: function(){
                        $(this).dialog("destroy");
                    }
                };
                dialog = $(divUsuario).dialog(dialogStrt);
            }
            if(ajax.readyState === 4){// reposta pronta
                dialog.dialog("close");
            }
        };
    }
    var formData = new FormData(form);
    ajax.open("post",url,false);
    ajax.send(formData);
    esperaAjax(ajax,function(){
        dialog.dialog("close");
        msgDialog("Erro de servidor","O servidor demorou muito a responder.\n"+
            "Tente novamente mais tarde.",null,null);
    });
    return ajax;
}

function simpleAjax(fn1,fn4){
    var ajax = criaAjax();
    
    if(ajax!==null){
        ajax.onreadystatechange = function(){
            if(ajax.readyState===1){
                if(fn1!==null) fn1();
            }
            if(ajax.readyState===4){
                if(fn4!==null) fn4();
            }
        };
    }
    return ajax;
}

function renderizar(parent, root){ // converte json em html
	if(parent===null) parent = document.createElement("div");
	while(parent.childNodes.length>0){
		parent.removeChild(parent.firstChild);
	}
	if(root.length){
		for(var element in root){
			parent.appendChild(toHTML(root[element]));
		}
	}
	else{
		parent.appendChild(toHTML(root));
	}
	return parent;
}

function toJsCss(css){
//	alert("comando toJsCss('"+css+"')");
	css = css.toLowerCase();
	var splitedCss = css.split("-");
	css = splitedCss[0];
	for(var i=1;i<splitedCss.length;i++){
		css += splitedCss[i].charAt(0).toUpperCase();
		try{css += splitedCss[i].substring(1);}
		catch(ex){}
	}
	return css;
}

function toHTML(obj){
	var element; // elemento a ser retornado como uma vers�o HTML do objeto json
//	try{alert(elem.tag);}
//	catch(ex){alert(ex.message+": "+elem)};
	if(obj!=null){
		if(obj.tag=="number" || obj.tag=="textNode"){
			element = document.createTextNode(obj.value);
			//alert(element);
		}
		else{
			element = document.createElement(obj.tag);
			if(obj.properties!=null){
				for(var key in obj.properties){
					if(key=="style"){
						var estilos = obj.properties["style"];
						for(var css in estilos){
							element.style[toJsCss(css)] = estilos[css];
						}
					}
					//else if(key=="class") element.setAttribute("className",elem.properties[key]);
					else element.setAttribute(key,obj.properties[key]);
				}
			}
			if(obj.children!=null){
				//alert("O elemento <"+elem.tag+"> tem "+elem.children.length+" filhos.")
				var filhos = obj.children;
				for(var filho in filhos){
					//alert(filho);
					var append = toHTML(filhos[filho]);
					if(append!=null) element.appendChild(append);
				}
			}
		}
	}
	return element;
}

function esperaAjax(ajax,funcao){
//	console.log("Funcao esperaAjax() chamada.");
	var timer = window.setTimeout(function(){
//		console.log("Timer finalizado.");
			if(ajax.readyState != 4 || ajax.status != 200){
				ajax.abort();
				funcao();
			}
			else if(ajax.readyState == 4 && ajax.status == 200){
				window.clearTimeout(timer);
			}
		},30000);
//	console.log("Timer iniciado.");
}