// deve ser utilizada com a biblioteca jQuery
var content; // deve ser sempre do tipo form
var ajax = criaAjax();
var dlgAguarde;
var wzrDialog;
var objCss;
var url;
var passo;

function Wizard(titulo,_url,_passo){
    //ajax = ajx;
    //content = iniContent;
    url = _url;
    passo = _passo;
    objCss = {
        width: "auto",
        title: titulo,
        autoOpen: true,
        modal: true
    };
    
    ajax.onreadystatechange = function(){
        if(ajax.readyState===1){
            dlgAguarde = msgNoUser("Carregando","Aguarde o término do carregamento...",null);
        }
        else if(ajax.readyState===4){
            if(dlgAguarde!==null) dlgAguarde.dialog("close");
            if(ajax.responseText!==null && 
                    ajax.responseText!==undefined &&
                    ajax.responseText.length>0){
                // gera nova janela de dialogo
                content = toHTML(JSON.parse(ajax.responseText));
                passo++;
                objCss.buttons = {
                    Cancelar: function(){
                        close();
                    },
                    "Próximo >": function(){
                        send();
                    }
                };
                open();
            }
            else{// encerra janelas do wizard
                if(wzrDialog!==null) wzrDialog.dialog("destroy");
            }
        }
    };
    
    this.open = open;
    this.send = send;
    this.close = close;
}

function open(){
    wzrDialog = $(content).dialog(objCss);
}

function send(){
    if(wzrDialog!==null) wzrDialog.dialog("close");
    ajax.open("post",url+passo,true);
    var formData = new FormData(content);
    ajax.send(formData);
    //if(wzrDialog!==null) wzrDialog.dialog("close");
}

function close(){
    if(wzrDialog!==null) wzrDialog.dialog("destroy");
}