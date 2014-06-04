<?php
session_start();
$cont = 0;
foreach($_SESSION['tabs-central-s1'] as $tab){
    if($tab != $_POST['tab']) $cont++;
    else break;
}
$_SESSION['active-tab-central-s1'] = $cont;
?>
