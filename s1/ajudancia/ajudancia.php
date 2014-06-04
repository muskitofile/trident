<?php
//include_once 'jquery_php/Tabs.class.php';
//include_once 'componente1/Fieldset1.class.php';
//include_once 'componente1/Table1.class.php';
//include_once 'componente1/Image1.class.php';
//include_once 'componente1/Style1.class.php';
//include_once 'componente1/Paragraph1.class.php';
//include_once 'componente1/Header1.class.php';
//include_once 'componente1/forms/Select1.class.php';
//include_once 'componente1/forms/Input1.class.php';
//include_once 'bd/Conexao1.class.php';

$content = new Tabs("tabs");

$abas = array();
$abas[] = "Militar";
$abas[] = "Cursos";
$abas[] = "Afastamentos";
$abas[] = "Relatórios";
$abas[] = "Indisponibilidade";
$abas[] = "Escalas";
$abas[] = "Pesquisa";
$abas[] = "Aplicações";
$abas[] = "Agenda";

foreach($abas as $aba){
    $content->addTab($aba);
}

$content->script->addSrc("../jquery_ui/ui/jquery.ui.mouse.js");
$content->script->addSrc("../jquery_ui/ui/jquery.ui.sortable.js");
$content->script->addSrc("../jquery_ui/ui/jquery.ui.tabs.js");
$content->script->addSrc("../jquery_ui/ui/jquery.ui.button.js");
$content->script->addSrc("../jquery_ui/ui/jquery.ui.draggable.js");
$content->script->addSrc("../jquery_ui/ui/jquery.ui.resizable.js");
$content->script->addSrc("../jquery_ui/ui/jquery.ui.dialog.js");
$content->script->addSrc("../jquery_ui/ui/jquery.ui.position.js");
$content->script->addSrc("scripts/ajax.js");
$content->script->addSrc("s1/ajudancia/dados_pessoais/dados.js");
$content->script->addSrc("scripts/dialogs.js");

$content->estilo->addHref("s1/s1.css");
$content->estilo->addHref("s1/ajudancia/dados_pessoais/dados.css");

// esta variável de sessão é manipulada no script 'click_tabs_central_s1.php'
if(!isset($_SESSION['active-tab-central-s1'])) $_SESSION['active-tab-central-s1']=0;

$exe = <<<exe
$(function(){
    $("#tabs").tabs({active: {$_SESSION['active-tab-central-s1']}});
    // aqui mais código javascript para a página
});
exe;
$content->script->addExe($exe);

if(isset($_GET['opcao'])){ //se vem de uma solicitação interna
    if($_GET['opcao']=="Novo") include "ajudancia/dados_pessoais/novo_usuario.php";
    else if($_GET['opcao']=="Editar1" or $_GET['opcao']=="Anterior1"){
        include "dados_pessoais/edita_usuario1.php";
    }
    else if($_GET['opcao']=="Próximo1" or $_GET['opcao']=="Anterior2"){
        include "dados_pessoais/edita_usuario2.php";
    }
    else if($_GET['opcao']=="Próximo2"){
        include "dados_pessoais/edita_usuario3.php";
    }
}
else{
    
    $titulo = $content->addToTab(new Header("2"),0);
    $titulo->id = "titulo_s1";
    $titulo->style['width'] = "100%";
    $titulo->style['text-align'] = "center";
    $fieldset = new Fieldset("Usuário: ");
    $fieldset->style['border'] = "solid 1px #aaa";
    $fieldset->style['border-radius'] = "4px";
    $content->addToTab($fieldset, 0);
    $select = $fieldset->addToLegend(new Select());
    $select->id = "slc_usuario";
    $select->onchange = "mudaUsuario()";
    $_user = $_SESSION['usuario'];
    if(true){ // implementar aqui a verificação se o usuário logado é administrador
        $lista_usuarios = Conexao::query("select saram,".
                "concat(posto,' ',quadro,' ',guerra) from usuario order by ordem");
        foreach ($lista_usuarios as $lu){
            if($lu['saram']==$_user['saram']) $select->addSelectedItem($lu);
            else $select->addItem($lu);
        }
    }
    else{
        $fieldset->addToLegend("{$user['posto']} {$user['quadro']} {$user['guerra']}");
    }
    //inicializa a variável do usuário
    if(!isset($_SESSION['escolha'])) $_SESSION['escolha'] = "s1_militar_notificacoes";
    // preenche o painel com o conteúdo selecionado pelo operador
    switch ($_SESSION['escolha']){
        case "s1_militar_dados":
            $titulo->add("Dados Pessoais");
            include 'dados_pessoais/dados_pessoais.php'; break;
        case "s1_militar_notificacoes":
            $titulo->add("Mensagens e Notificações");
            include 'notificacoes/notificacoes.php'; break;
        case "s1_militar_afastamentos":
            $titulo->add("Afastamentos");
            include 'afastamentos/afastamentos.php'; break;
    }

    $listaOptions = new Lista();
    $content->addToTab($listaOptions, 0);
    if($_SESSION['escolha']!="s1_militar_dados"){
        $anchor = new Anchor(
            "s1/computa_militar_opcao.php?escolha=s1_militar_dados&aba=0",
                new Image("s1/ajudancia/dados_pessoais/imagens/dados2.png"));
        $listaOptions->addItem($anchor);
        $anchor->add("Dados Pessoais");
    }
    if($_SESSION['escolha']!="s1_militar_afastamentos"){
        $anchor = new Anchor(
            "s1/computa_militar_opcao.php?escolha=s1_militar_afastamentos&aba=0",
                new Image("s1/ajudancia/dados_pessoais/imagens/afastamento.png"));
        $listaOptions->addItem($anchor);
        $anchor->add("Afastamentos");
    }
    if($_SESSION['escolha']!="s1_militar_cursos"){
        $anchor = new Anchor(
            "s1/computa_militar_opcao.php?escolha=s1_militar_cursos&aba=0",
                new Image("s1/ajudancia/dados_pessoais/imagens/cursos.png"));
        $listaOptions->addItem($anchor);
        $anchor->add("Cursos");
    }
    if($_SESSION['escolha']!="s1_militar_notificacoes"){
        $anchor = new Anchor(
            "s1/computa_militar_opcao.php?escolha=s1_militar_notificacoes&aba=0",
                new Image("s1/ajudancia/dados_pessoais/imagens/mensagens.png"));
        $listaOptions->addItem($anchor);
        $anchor->add("Mensagens e Notificações");
    }
    if($_SESSION['escolha']!="s1_militar_escalas"){
        $anchor = new Anchor(
            "s1/computa_militar_opcao.php?escolha=s1_militar_escalas&aba=0",
                new Image("s1/ajudancia/dados_pessoais/imagens/servico.png"));
        $listaOptions->addItem($anchor);
        $anchor->add("Escalas e Disponibilidade");
    }
    if($_SESSION['escolha']!="s1_militar_outros"){
    $anchor = new Anchor(
            "s1/computa_militar_opcao.php?escolha=s1_militar_outros&aba=0",
            new Image("s1/ajudancia/dados_pessoais/imagens/outros.png"));
        $listaOptions->addItem($anchor);
        $anchor->add("Outros Dados");
    }
}
//$tabs->show();
?>
