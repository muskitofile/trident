<?php

$msgs = Conexao::query("select mensagem.*,msg_usuario.status as status from 
        mensagem,msg_usuario where id in ".
        "(select mensagem from msg_usuario where usuario='{$usuario['saram']}')".
        " and mensagem.id=msg_usuario.mensagem and msg_usuario.status<2");
        
//$script = <<< script
//function mudaStatus(id){
//    var btn = document.getElementById("btn"+id);
//    var msg = document.getElementById("msg"+id);
//    if(btn.value=="Ciente"){
//        msg.style.color = "#aaa";
//        btn.value = 'Arquivar';
//    }
//    else msg.style.display = "none";
//    var ajax = 
//}
//script;
//
//$jscript = $fieldset->add(new Script1());
//$jscript->addExe($script);
        
$script = new Script("s1/ajudancia/notificacoes/notifica.js");
$fieldset->add($script);

$regra = <<< regra
.nlida td{
    color: black;
    background: #e0f0ff;
}
        
.nlida input{
    /*border: solid 1px black;*/
}        
        
.lida td{
    color: #aaa;
    background: #fff;
}

.lida input{
    /*border: solid 1px #aaa;*/
}
        
#tbl_msg td{
    padding: 10px;
    border-bottom: solid 1px #bdf;
}
regra;

$style = $fieldset->add(new Style());
$style->addRegra($regra);

$tabela_msg = $fieldset->add(new Table());
$tabela_msg->id = "tbl_msg";
$tabela_msg->cellspacing = "0";
$tabela_msg->style['width'] = "100%";
$class = "nlida";

if(sizeof($msgs)>0){
    foreach($msgs as $msg){
        if($msg['status']<2){// a mensagem ainda não foi lida
            if($msg['status']==1) $class = "lida";
            else $class = "nlida";
            $row = $tabela_msg->addRow();
            $row->id = "msg".$msg['id'];
            $row->class = $class;
            $cell = $row->addCell(Conexao1::converteDataHora($msg['datahora']));
            $lbl_titulo = new Label(utf8_encode($msg['titulo']));
            $lbl_titulo->style['font-weight'] = "bold";
            $cell = $row->addCell($lbl_titulo);
            $cell->add("<br/>");
            $cell->add(utf8_encode($msg['texto']));
            $cell->style['max-width'] = "400px";
            $cell = $row->addCell(utf8_encode(Conexao1::direct(
                    "select concat(posto,' ',guerra) from usuario where saram='{$msg['origem']}'")));
            $button = new Input("button");
            $cell = $row->addCell($button);
            if($class=="nlida") $button->value = "Ciente";
            else $button->value = "Arquivar";
            $button->onclick = "mudaStatus('{$msg['id']}')";
            $button->style['width'] = "80px";
            $button->id = "btn".$msg['id'];
        }
   }
}
else{// não há mensagens ou todas já foram lidas
    $row = $tabela_msg->addRow();
    $cell = $row->addCell("Nenhuma mensagem a ser exibida.");
    $cell->class = "aviso_interno";
    //$cell->style['font-style'] = "italic";
}

//$listaOptions = new List1();
//$tabs->addToTab($listaOptions, 0);
//$listaOptions->addItem(new Anchor1("s1/computa_militar_opcao.php?escolha=s1_militar_dados&aba=0","Dados Pessoais"));
//$listaOptions->addItem(new Anchor1("s1/computa_militar_opcao.php?escolha=s1_militar_afastamentos&aba=0","Afastamentos"));
//$listaOptions->addItem(new Anchor1("s1/computa_militar_opcao.php?escolha=s1_militar_cursos&aba=0","Cursos"));
//$listaOptions->addItem(new Anchor1("s1/computa_militar_opcao.php?escolha=s1_militar_escalas&aba=0","Escalas e Indisponibilidade"));
//$listaOptions->addItem(new Anchor1("s1/computa_militar_opcao.php?escolha=s1_militar_outros&aba=0","Outros Dados"));
?>
