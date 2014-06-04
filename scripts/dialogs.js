function msgDialog(titulo,msg,fnClosing,objCss){ // objCss traz a estilização do dialog
	container = document.createElement("div");
	if(msg instanceof HTMLElement) container = msg;
	else container.innerHTML = msg;
	var objDial = {
		modal: true,
		title: titulo,
		autoOpen: true,
		height: "auto",
		buttons:{
			Ok: function(){
				$(this).dialog("close");
			}
		},
		close: function(){
			if(fnClosing!=null) fnClosing();
			$(this).dialog("destroy");
		}
	};
	if(objCss!=null)
		for(var prop in objCss){
			if(objCss.hasOwnProperty(prop)) objDial[prop] = objCss[prop];
		}
	var dialog = $(container).dialog(objDial).css("font-size","11pt");
//        var _top = (window.clientHeight-dialog.style.height)/2;
//        var _left = (window.clientWidth-dialog.style.width)/2;
        dialog.find(".ui-dialog-titlebar").find("button").css("display","none");
//        dialog.offset({top: _top, left: _left});
	$("button").css("font-size","11pt");
}

function msgDialogReload(titulo,msg,url,objCss){
	msgDialog(titulo,msg,function(){
		msgReloading("Recarregando...","Aguarde o recarregamento da página.",url);
	},objCss);
}

function msgReloading(titulo,msg,url,objCss){
	var container = document.createElement("div");
	if(msg instanceof HTMLElement) container.innerHTML = msg.innerHTML;
	else container.innerHTML = msg;
	var objDial = {
		modal: true,
		title: titulo,
		autoOpen: true,
		height: "auto",
		open: function(){
			window.location = url;
		}
	}
	if(objCss!=null)
		for(var prop in objCss){
			if(objCss.hasOwnProperty(prop)) objDial[prop] = objCss[prop];
		}
	$(container).dialog(objDial).css("font-size","11pt");
	$("button").css("font-size","11pt");
}

function msgNoUser(titulo,msg,objCss){
	var container = document.createElement("div");
	if(msg instanceof HTMLElement) container.innerHTML = msg.innerHTML;
	else container.innerHTML = msg;
	var objDial = {
		modal: true,
		title: titulo,
		autoOpen: true,
		height: "auto",
		close: function(){
			$(this).dialog("destroy");
		}
	}
	if(objCss!=null)
		for(var prop in objCss){
			if(objCss.hasOwnProperty(prop)) objDial[prop] = objCss[prop];
		}
	var dialog = $(container).dialog(objDial).css("font-size","11pt");
        dialog.find(".ui-dialog-titlebar").find("button").css("display","none");
        $("button").css("font-size","11pt");
	return dialog;
}

function cfmDialog(titulo,msg,fnYes,fnNo,fnCnl,objCss){
	var container = document.createElement("div");
	if(msg instanceof HTMLElement) container.innerHTML = msg.innerHTML;
	else container.innerHTML = msg;
	var objDial = {
		modal: true,
		title: titulo,
		autoOpen: true,
		height: "auto",
		buttons:{
			Sim: function(){
				$(this).dialog("close");
				if(fnYes!=null) fnYes();
			},
			Não: function(){
				$(this).dialog("close");
				if(fnNo!=null) fnNo();
			},
			Cancelar: function(){
				$(this).dialog("close");
				if(fnCnl!=null) fnCnl();
			}
		},
		close: function(){
			$(this).dialog("destroy");
		}
	}
	if(objCss!=null)
		for(var prop in objCss){
			if(objCss.hasOwnProperty(prop)) objDial[prop] = objCss[prop];
		}
	$(container).dialog(objDial).css("font-size","11pt");
	$("button").css("font-size","11pt");
}
