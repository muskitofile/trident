<?php
session_start();
$_SESSION['escolha'] = $_GET['escolha'];
$_SESSION['active-tab-central-s1'] = $_GET['aba'];
header("location: ../index.php");
?>
