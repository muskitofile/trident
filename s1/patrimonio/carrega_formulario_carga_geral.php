<?php 
//include_once '../../../componente/Table.class.php';
//include_once '../../../componente/Style.class.php';
//include_once '../../../componente/forms/Select.class.php';
//include_once '../../../componente/forms/Text.class.php';
//include_once '../../../componente/forms/Form.class.php';
//include_once '../../../componente/forms/TextArea.class.php';
//include_once '../../../bd/Conexao.class.php';

//function __autoload($classe){
//    include_once '../../../componente/'.$classe.'.class.php';
//    include_once '../../../componente/forms/'.$classe.'.class.php';
//    include_once '../../../componente/jquery_php/'.$classe.'.class.php';
//    include_once '../../../db/'.$classe.'.class.php';
//}
include 'includes.php';

$setor = $_GET['setor'];

$form = new Form("form_$setor");
$form->method = "post";
$form->enctype = "multipart/form-data";
$form->action = "s1/patrimonio/salva_material_carga.php";

$table = $form->add(new Table("tbl_cg"));
$table->addRow();
$table->addCell("Setor ");
$slc_setor = $table->addCell(new Select("setor"),"content");
$table->lastCell()->colspan = "3";
    $setores = Conexao::query("select sigla,descricao,grupo from setor order by ordem");
    $slc_setor->addItems($setores);
    $slc_setor->setSelectedItem($setor);
    
$table->addRow();
$table->addCell("BMP: ");
$txt_bmp = $table->addCell(new Text("bmp"),"content");
$table->addCell("Sispat: ");
$table->addCell(new Text("sispat"));

$table->addRow();
$table->addCell("Classe: ");
$slc_classe = $table->addCell(new Select("classe"),"content");
    $classes= Conexao::query("select * from classe_pat");
    $slc_classe->addItems($classes);
$table->addCell("Conta: ");
$slc_conta = $table->addCell(new Select("conta"),"content");
    $contas= Conexao::query("select id,concat(id,' - ',descricao) from conta_pat");
    $slc_conta->addItems($contas);
    $slc_conta->style['width'] = "200px";
    
$table->addRow();
$table->addCell("Descrição: ");
$cell = $table->addCell(new TextArea("descricao"));
$cell->colspan = "3";

$table->addRow();
$table->addCell("Valor (R$): ");
$table->addCell(new Text("valor"));
$table->addCell("Detentor: ");
$slc_detentor = $table->addCell(new Select("detentor"),"content");
    $detentores = Conexao::query("select saram,concat(posto,' ',guerra) from usuario order by ordem");
    $slc_detentor->addItems($detentores);
    
$table->addRow();
$table->addCell("Situação: ");
$slc_situacao = $table->addCell(new Select("situacao"),"content");
    $situacoes = Conexao::campoUnico("select situacao from situacao_mat order by ordem");
    $slc_situacao->addItems($situacoes);
    $slc_situacao->style['width'] = "200px";
    

echo json_encode($form->toArrayJson());
//echo $form->show();
?>
