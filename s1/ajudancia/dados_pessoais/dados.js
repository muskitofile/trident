var dialog;
var wizard;

function novoUsuario(){
    wizard = new Wizard("Novo Usuário",
                    "s1/dados pessoais/carrega_formulario_novo_usuario.php?estado=",0);
    wizard.open();
    wizard.send();
//    var ajax = criaAjax();
//    if(ajax!==null){
//        ajax.onreadystatechange = function(){
//            if(ajax.readyState === 1){
//                msgNoUser("Carregando","Aguarde o término do carregamento.",null);
//            }
//            else if(ajax.readyState === 4){
//                wizard = new Wizard("Novo Usuário",toHTML(JSON.parse(ajax.responseText)),
//                    "s1/dados pessoais/carrega_formulario_novo_usuario.php?estado=",0,ajax);
//                wizard.open();
//            }
//        }
//    }
//    ajax.open("post","s1/dados pessoais/carrega_formulario_novo_usuario.php?estado=0",true);
//    wizard.open();
}

function mudaUsuario(){
    var slc = document.getElementById("slc_usuario");
    var usuario = slc.options[slc.selectedIndex].value;
//    alert(usuario);
//    var items = slc.getElementsByTagName("option");
//    var usuario;
//    for(var i=0; i<items.length; i++){
//        if(items[i].selected) usuario= items[i].nodeValue;
//    }
    var form = document.createElement("form");
    form.action = "s1/ajudancia/muda_usuario.php";
    form.method = "get";
    form.style.display = "none";
    var inputUser = form.appendChild(document.createElement("input"));
    inputUser.type = "hidden";
    inputUser.name = "usuario";
    inputUser.value = usuario;
    document.body.appendChild(form);
    form.submit();
    msgNoUser("Carregando...","Aguarde o carregamento da página.",null);
}

var semFoto = "s1/dados_pessoais/imagens/foto.png";

function alterarFoto(){
    var file = document.getElementById("file_foto");
    file.click();
}

function carregaFoto(){
    var imagem = document.getElementById("foto");
    var file = document.getElementById("file_foto");
    var arq = file.files[0];
    if(arq!==null || arq.mediaType==="image/*"){
        var reader = FileReader();
        reader.readAsDataURL(arq);
        reader.onloadend = function(){
            imagem.src = reader.result;
        }
    }
    else msgDialog("Erro ao abrir arquivo",
                "O arquivo que você abriu não é uma imagem válida.",
                null,null);//alert("Erro. file = "+file);
}

function excluirFoto(){
    var imagem = document.getElementById("foto");
    if(endsWith(imagem.src,semFoto)){
        msgDialog("Foto vazia","Este usuário já se encontra com sua foto não definida.<br/>"+
            "Este estado se confirmará após o recarregamento da página.",null,
                {width: "auto", 
                 maxWidth: "700px",
                 minWidth: "500px"});
    }
    else{
        cfmDialog("Excluir Foto do Usuário","Tem certeza de deseja excluir a foto deste usuário?",
            simExcluirFoto);
    }
}

function endsWith(str1,str2){
    if(str1.length<str2.length) return false;
    return str1.indexOf(str2,str1.length-str2.length)!==-1;
}

function simExcluirFoto(){
    var imagem = document.getElementById("foto");
    var file = document.getElementById("file_foto");
    imagem.src = semFoto;
    file.value = null;
}

function preparaForm(form){
    var file = document.getElementById("file_foto");
    if(file.value===undefined || file.value===null || file.value==="") file.disabled = true;
//    var campos = form.getElementsByTagName("input");
////    campos.push(form.getElementsByTagName("select"));
//    var area = form.getElementsByTagName("textarea");
//    if(area.length>0 && area[0]!==null){
//        var content = area[0].innerText;
//        var hidden = document.createElement("input");
//        hidden.type = "hidden";
//        hidden.name = "logradouro";
//        hidden.value = content;
//        form.appendChild(hidden);
//    }
//    alert(hidden.value);
//    for(var i=0; i<campos.length;i++){
//        alert(campos[i].value);
//        campos[i].disabled = false;
//    }
//    return false;
}

//function estiloItalico(textbox){
//    if(textbox.value.length===0) textbox.style.fontStyle = "italic";
//    else textbox.style.fontStyle = "normal";
//}

function addFone(dddId,foneId){
    var ddd = dddId.value;
    var fone = foneId.value;
    if(ddd==="" || ddd.length<2){
        msgDialog("DDD Incompleto","Digite o DDD com 2 dígitos.",null,null);
            return;
        dddId.focus();
    }
    if(fone==="" || fone.length<8){
        msgDialog("Telefone Incompleto","Digite o número do telefone com 8 dígitos sem o traço.",null,null);
            return;
        foneId.focus();
    }
    var list = document.getElementById("slc_fones");
    var options = list.getElementsByTagName("option");
    for(var i=0;i<options.length;i++){
        if(options[i].value === ddd+"-"+fone){
            options[i].selected = true;
            options[i].focus = true;
            msgDialog("Telefone Repetido","O telefone digitado já está na lista.",null,null);
            return;
        }
    }
    for(i=0;i<options.length;i++){
        options[i].selected = false;
    }
    var option = document.createElement("option");
    option.value = ddd+"-"+fone;
    option.selected = true;
    option.appendChild(document.createTextNode(ddd+"-"+fone));
    list.appendChild(option);
    dddId.value = "";
    foneId.value = "";
}

function delFone(){
    var list = document.getElementById("slc_fones");
    var options = list.getElementsByTagName("option");
    var valor;
    for(var i=0;i<options.length;i++){
        if(options[i].selected === true){
            valor = options[i].value;
            list.removeChild(options[i]);
            break;
        }
    }
    
    var ddd = document.getElementById("text_ddd");
    ddd.value = valor.substr(0,2);
    var fone = document.getElementById("text_fone");
    fone.value = valor.substring(3,valor.length);
}

function upFone(){
    var list = document.getElementById("slc_fones");
    if(list.firstElementChild.selected) return;
    var options = list.getElementsByTagName("option");
    var vetor = new Array();
    var ultimo = options[0];
    
    for(var i=1;i<options.length;i++){
        if(options[i].selected || options[i].focused){
            vetor.push(options[i]);
        }
        else{
            vetor.push(ultimo);
            ultimo = options[i];
        }
    }
    vetor.push(ultimo);
    for(option in vetor){
        list.appendChild(vetor[option]);
    }
}

function downFone(){
    var list = document.getElementById("slc_fones");
    if(list.lastElementChild.selected) return;
    var options = list.getElementsByTagName("option");
    var vetor = new Array();
    var aux=null;
    
    for(var i=0;i<options.length;i++){
        if(options[i].selected || options[i].focused){
            aux = options[i];
        }
        else{
            vetor.push(options[i]);
            if(aux!==null){
                vetor.push(aux);
                aux = null;
            }
        }
    }
    for(option in vetor){
        list.appendChild(vetor[option]);
    }
}

function addEmail(){
    var txtEmail = document.getElementById("text_email");
    var email = txtEmail.value;
    var slcTipo = document.getElementById("slc_tipo");
    var arroba = false;
    
    for(i=2;i<email.length-2;i++){
        if(email[i]==="@"){
            arroba = true;
            break;
        }
    }
    var tipos = slcTipo.getElementsByTagName("option");
    var tipo;
    if(!arroba){
        msgDialog("Email Inválido","O email que você digitou é inválido.",null,null);
        return;
    }
    else{
        for(i=0;i<tipos.length;i++){
            if(tipos[i].selected){
                tipo = tipos[i].value;
                break;
            }
        }
        var slc_emails = document.getElementById("slc_emails");
        var emails = slc_emails.getElementsByTagName("option");
        for(var i=0; i<emails.length; i++){
            if(emails[i].value === email+"-"+tipo){
                msgDialog("Email Repetido",
                        "O email que você digitou já consta na lista.",null,null);
                return;
            }
        }
        var new_option = document.createElement("option");
        new_option.value = email+"-"+tipo;
        new_option.appendChild(document.createTextNode(email));
        slc_emails.appendChild(new_option);
        new_option.selected = true;
        for(i=0;i<tipos.length;i++){
            tipos[i].selected = false;
        }
    }
    txtEmail.value = "";
}

function delEmail(){
    var list = document.getElementById("slc_emails");
    var options = list.getElementsByTagName("option");
    var valor;
    for(var i=0;i<options.length;i++){
        if(options[i].selected === true){
            valor = options[i].value;
            list.removeChild(options[i]);
            break;
        }
    }
    var _email = "";
    var _tipo = "";
    for(i=0;i<valor.length;i++){
        if(valor[i]==="-"){
            _tipo = valor.substring(i+1);
            break;
        }
        else _email += valor[i];
    }
    var email = document.getElementById("text_email");
    email.value = _email;
    var tipo = document.getElementById("slc_tipo");
    var tipos = tipo.getElementsByTagName("option");
    for(i=0;i<tipos.length;i++){
        if(tipos[i].value===_tipo) tipos[i].selected = true;
        else tipos[i].selected = false;
    }
}

function upEmail(){
    var list = document.getElementById("slc_emails");
    if(list.firstElementChild.selected) return;
    var options = list.getElementsByTagName("option");
    var vetor = new Array();
    var ultimo = options[0];
    
    for(var i=1;i<options.length;i++){
        if(options[i].selected || options[i].focused){
            vetor.push(options[i]);
        }
        else{
            vetor.push(ultimo);
            ultimo = options[i];
        }
    }
    vetor.push(ultimo);
    for(option in vetor){
        list.appendChild(vetor[option]);
    }
}

function downEmail(){
    var list = document.getElementById("slc_emails");
    if(list.lastElementChild.selected) return;
    var options = list.getElementsByTagName("option");
    var vetor = new Array();
    var aux=null;
    
    for(var i=0;i<options.length;i++){
        if(options[i].selected || options[i].focused){
            aux = options[i];
        }
        else{
            vetor.push(options[i]);
            if(aux!==null){
                vetor.push(aux);
                aux = null;
            }
        }
    }
    for(option in vetor){
        list.appendChild(vetor[option]);
    }
}