function novoRegistro(setor){    
//    alert(setor);
    var fn4 = function(){
//        alert(ajax.responseText);
        $(renderizar(null,JSON.parse(ajax.responseText))).dialog({
            title: "Novo Registro de Material Carga Geral",
            width: "auto",
            modal: true,
            buttons:{
                Cancelar: function(){
                    $(this).dialog("destroy");
                },
                Salvar: function(){
                    var form = document.getElementById("form_"+setor);
                    msgNoUser("Aguarde...","Aguarde o recarregamento da página.");
                    form.submit();
                }
            }
        });
    };
    var ajax = simpleAjax(null,fn4);
    if(ajax!==null){
        ajax.open("get","s1/patrimonio/carrega_formulario_carga_geral.php?setor="+setor,true);
        ajax.send();
    }
}


