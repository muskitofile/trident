function mudaStatus(id){
    var btn = document.getElementById("btn"+id);
    var msg = document.getElementById("msg"+id);
    var status = 0;
    if(btn.value==="Ciente"){
        msg.className = "lida";
        btn.value = 'Arquivar';
        status = 1;
    }
    else{
        var parent = msg.parentNode;
        parent.removeChild(msg);
        var linhas = parent.getElementsByTagName("tr");
        if(linhas.length===0){ 
            var linha = document.createElement("tr");
            parent.appendChild(linha);
            var celula = document.createElement("td");
            linha.appendChild(celula);
            celula.appendChild(document.createTextNode("Nenhuma mensagem a ser exibida."));
            celula.style.fontStyle = "italic";
        }
        status = 2;
    }
    var ajax = criaAjax();
//    if(ajax!=null){
//        ajax.onreadystatechange = function() {
//            if(ajax.readyState == 4){// reposta pronta
//                var xml = ajax.responseText;
//                //alert("status"+xml);
//            }
//        }
//    }
    ajax.open("get","s1/notificacoes/trata_msg_status.php?status="+status+"&id_msg="+id,true);
    ajax.send();
}

