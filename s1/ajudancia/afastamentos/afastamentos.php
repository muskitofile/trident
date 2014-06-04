<?php
//include_once 'componente1/Label1.class.php';
//
////////////////////////////////////////////////////////
//include_once 'jquery_php/Tabs.class.php';
//include_once 'componente1/Fieldset1.class.php';
//include_once 'componente1/Table1.class.php';
//include_once 'componente1/Image1.class.php';
//include_once 'componente1/Style1.class.php';
//include_once 'componente1/Paragraph1.class.php';
//include_once 'componente1/forms/Select1.class.php';
//include_once 'componente1/forms/Input1.class.php';
//include_once 'bd/Conexao1.class.php';
/////////////////////////////////////////////////////////

$tabs_afast = $fieldset->add(new Tabs("tabs_afast"));

$tabs_afast->add(new Script("s1/ajudancia/afastamentos/afastamentos.js"),0);
$tabs_afast->add(new Style("s1/ajudancia/afastamentos/afastamentos.css"),0);

$tabs_afast->addTab("Férias");
$tabs_afast->addTab("Comissionamentos");
$tabs_afast->addTab("Outras");

$ano = Conexao::direct("select year(now())");
$ferias = Conexao::registroUnico("select * from ferias where usuario='{$usuario['saram']}'".
        " and plano='{$ano}'");
if(isset($ferias) and sizeof($ferias)>0){
    $etapas = Conexao::query("select * from etapa_ferias where id_ferias=".$ferias['id']);
}
else{// não há afastamentos
    
}

/*$table_cab = $tabs_afast->addToTab(new Table1(),0);
$table_cab->id = "tbl_cab";
$table_cab->style['width'] = "100%";
$row = $table_cab->addRow();
$row->addCell(new Label1("Plano "));
$sel_plano = new Select1();
$row->addCell($sel_plano);
for($i=0;$i<5;$i++){
    if($i==3) $sel_plano->addSelectedItem($ano+$i-3);
    else $sel_plano->addItem($ano+$i-3);
}

$row->addCell(new Label1("Período Aquisitivo: "));
$row->addCell(Conexao1::converteData($ferias['inicio_pa'])
        ." a ".  Conexao1::converteData($ferias['termino_pa']));

$row->addCell(new Label1("Parcelas: "));
$row->addCell($ferias['parcelas']);

$row->addCell(new Anchor1("#","detalhes..."));

$row->addCell($ferias);
foreach($etapas as $etapa){
    
}*/
?>
