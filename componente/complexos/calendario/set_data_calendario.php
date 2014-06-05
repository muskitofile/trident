<?php
    session_start();
    if(isset($_GET['dia'])){
        $_SESSION['dia'] = $_GET['dia'];
        $_SESSION['mes'] = $_GET['mes'];
        $_SESSION['ano'] = $_GET['ano'];
        //echo $_GET['ano']."-".$_GET['mes']."-".$_GET['dia'];
    }
    else{
    	unset($_SESSION['dia']);
    	unset($_SESSION['mes']);
    	unset($_SESSION['ano']);
    }
?>