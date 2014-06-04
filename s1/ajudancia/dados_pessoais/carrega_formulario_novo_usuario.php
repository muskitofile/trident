<?php
include_once '../../componente1/Table1.class.php';
include_once '../../componente1/Paragraph1.class.php';
include_once '../../componente1/Fieldset1.class.php';
include_once '../../componente1/Element1.class.php';
include_once '../../componente1/forms/Text1.class.php';
include_once '../../componente1/forms/Select1.class.php';
include_once '../../componente1/forms/Button1.class.php';
include_once '../../componente1/forms/Form1.class.php';
include_once '../../componente1/complexos/calendario/calend.class.php';
include_once '../../bd/Conexao1.class.php';

session_start();
//if(!isset($_SESSION['estado'])) $_SESSION['estado'] = $_GET['estado'];
//else if($_SESSION['estado']<$_GET['estado']) $_SESSION['estado'] = $_GET['estado'];

if(true){// verificar se o usuario logado tem permissões para tal
    if($_GET['estado']=="0"){
        $form_ident = new Form1("form_ident");
        $field = $form_ident->add(new Fieldset1("Identificação"));
        $field->id = "fld_ident";
        $tbl_int = $field->add(new Table1("tbl_ident"));
        $rowInt = $tbl_int->addRow();
        $cellInt = $rowInt->addCell("Nome:");
        $cellInt->class = "label";
        $cmpNome = new Text1("nome");
        $cmpNome->style['width'] = "100%";
        $cellInt = $rowInt->addCell($cmpNome);
        $cellInt->colspan = "3";

        $rowInt = $tbl_int->addRow();
        $cellInt = $rowInt->addCell("Posto/Grad:");
        $cellInt->class = "label";
        $postos = Conexao1::campoUnico("select sigla from posto order by ordem");
        $slc_posto = new Select1("posto");
        $slc_posto->addItems($postos);
        $rowInt->addCell($slc_posto);
        $cellInt = $rowInt->addCell("Quadro:");
        $cellInt->class = "label";
        $quadros = array("QOAV","QSS BMA","QSS BCO","QESA SAD");
        $slc_quadro = new Select1("quadro");
        $slc_quadro->addItems($quadros);
        $rowInt->addCell($slc_quadro);

        $rowInt = $tbl_int->addRow();
        $cellInt = $rowInt->addCell("Saram:");
        $cellInt->class = "label";
        $cmpSaram = new Text1("saram");
        $cmpSaram->maxlength = "7";
        $cellInt = $rowInt->addCell($cmpSaram);
        $cellInt = $rowInt->addCell("Data de Praça:");
        $cellInt->class = "label";
        $cellInt = $rowInt->addCell(new Text1("praca"));
        $cellInt->add(new Calendario1("calend"));

        $rowInt = $tbl_int->addRow();
        $cellInt = $rowInt->addCell("Identidade:");
        $cellInt->class = "label";
        $rowInt->addCell(new Text1("identidade"));
        $cellInt = $rowInt->addCell("Antiguidade na OM:");
        $cellInt->class = "label";
        $rowInt->addCell(new Select1("antiguidade"));

        $rowInt = $tbl_int->addRow();
        $cellInt = $rowInt->addCell("CPF:");
        $cellInt->class = "label";
        $rowInt->addCell(new Text1("cpf"));
        $cellInt = $rowInt->addCell("Login:");
        $cellInt->class = "label";
        $rowInt->addCell(new Text1("login"));
        
//        $hr = $form_ident->add(new Element1("hr"));
//        $hr->style['margin-top'] = "25px";
//        
//        $p = $form_ident->add(new Paragraph1());
//        $btn_cnl = new Button1("btn_cancelar");
//        $btn_cnl->value = "Cancelar";
//        $btn_cnl->onclick = "cancelar()";
//        $p->add($btn_cnl);
//        $btn_prox = new Button1("btn_proximo");
//        $btn_prox->value = "Próximo >";
//        $btn_prox->onclick = "wizard.send()";
//        $p->add($btn_prox);
//        $p->style['width'] = "100%";
//        $p->align = "right";
        
        echo json_encode($form_ident->toArrayJson());
    }
    else if($_GET['estado']=="1"){
        $form_ctt = new Form1("form_ctt");
        $field_ctt = $form_ctt->add(new Fieldset1("Telefones"));
        $table_fone = $field_ctt->add(new Table1("tbl_fone"));
        $row = $table_fone->addRow();
        $slc_fone = new Select1("slc_fone");
        $usuario = $_SESSION['usuario'];
        $fones = Conexao1::campoUnico("select concat('(',ddd,')',telefone) from ".
                "telefone where usuario='{$usuario['saram']}'");
        $slc_fone->addItems($fones);
        $slc_fone->multiple = "";
        $slc_fone->size = "3";
        $cell = $row->addCell($slc_fone);
        
//        $hr = $form_ctt->add(new Element1("hr"));
//        $hr->style['margin-top'] = "25px";
//        
//        $p = $form_ctt->add(new Paragraph1());
//        $btn_cnl = new Button1("btn_cancelar");
//        $btn_cnl->value = "< Anterior";
//        $btn_cnl->onclick = "cancelar()";
//        $p->add($btn_cnl);
//        $btn_prox = new Button1("btn_proximo");
//        $btn_prox->value = "Próximo >";
//        $btn_prox->onclick = "wizard.send()";
//        $p->add($btn_prox);
//        $p->style['width'] = "100%";
//        $p->align = "right";
        
        echo json_encode($form_ctt->toArrayJson());
    }
    
    else if($_GET['estado']=="2"){
        $form_ctt = new Form1("form_ctt");
        $field_ctt = $form_ctt->add(new Fieldset1("Telefones"));
        $table_fone = $field_ctt->add(new Table1("tbl_fone"));
        $row = $table_fone->addRow();
        $slc_fone = new Select1("slc_fone");
        $usuario = $_SESSION['usuario'];
        $fones = Conexao1::campoUnico("select email from ".
                "email where usuario='{$usuario['saram']}'");
        $slc_fone->addItems($fones);
        $slc_fone->multiple = "";
        $slc_fone->size = "3";
        $cell = $row->addCell($slc_fone);
        
//        $hr = $form_ctt->add(new Element1("hr"));
//        $hr->style['margin-top'] = "25px";
//        
//        $p = $form_ctt->add(new Paragraph1());
//        $btn_cnl = new Button1("btn_cancelar");
//        $btn_cnl->value = "< Anterior";
//        $btn_cnl->onclick = "cancelar()";
//        $p->add($btn_cnl);
//        $btn_prox = new Button1("btn_proximo");
//        $btn_prox->value = "Concluir";
//        $btn_prox->onclick = "wizard.send()";
//        $p->add($btn_prox);
//        $p->style['width'] = "100%";
//        $p->align = "right";
        
        echo json_encode($form_ctt->toArrayJson());
    }
}
?>
