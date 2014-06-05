<?php
class Conexao{

    static private $bd = "poseidon";
    static private $user = "root";
    static private $senha = "cabucu";
    
    static function setDB($bd){
        self::$bd = $bd;
    }
    
    static function execute($cmdo){
        $ret = false;
        $conn = mysql_connect('localhost',self::$user,self::$senha);
        mysql_select_db(self::$bd,$conn);
        mysql_query("SET NAMES 'utf8'", $conn);
        if(mysql_query($cmdo,$conn)) $ret = true;
        else echo mysql_error();
        mysql_close($conn);
        return $ret;
    }

    static function query($cmdo){
        $conn = mysql_connect('localhost',self::$user,self::$senha);
        mysql_select_db(self::$bd,$conn);
        mysql_query("SET NAMES 'utf8'", $conn);
        $vector = array();
        if($result = mysql_query($cmdo,$conn)){
            try{
                while($row = mysql_fetch_array($result)){
                    $vector[] = $row;
                }
            }
            catch(Exception $ex){}
        }
        else echo mysql_error();
        mysql_close($conn);
    	return $vector;
    }

    static function direct($cmdo){
    	$return = null;
    	$conn = mysql_connect('localhost',self::$user,self::$senha);
        mysql_select_db(self::$bd,$conn);
        mysql_query("SET NAMES 'utf8'", $conn);
    	if($result = mysql_query($cmdo,$conn)){
    		while($row = mysql_fetch_array($result)){
    			$return = $row[0];
    			break;
    		}
    	}
        else echo mysql_error();
    	mysql_close($conn);
    	return $return;
    }

    static function registroUnico($cmdo){
        $result = null;
        $conn = mysql_connect('localhost',self::$user,self::$senha);
        mysql_select_db(self::$bd,$conn);
        mysql_query("SET NAMES 'utf8'", $conn);
        if($res = mysql_query($cmdo,$conn)){
            while($row = mysql_fetch_array($res)){
                $result = $row;
                break;
            }
        }
        else echo mysql_error();
        mysql_close($conn);
        return $result;
    }

    static function campoUnico($cmdo){
    	$return = array();
    	$conn = mysql_connect('localhost',self::$user,self::$senha);
        mysql_select_db(self::$bd,$conn);
        mysql_query("SET NAMES 'utf8'", $conn);
    	if($result = mysql_query($cmdo,$conn)){
    		while($row = mysql_fetch_array($result)){
    			$return[] = $row[0];
    		}
    	}
        else echo mysql_error();
    	mysql_close($conn);
    	return $return;
    }
    
    // 2013-12-20  -->>>  20/12/2013
    static function converteData($data) {
        return substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4);
    }

    // 2013-12-20 10:38:23 -->>>  20/12/2013 às 10h38min23seg
    static function converteDataHora($datahora) {
        return substr($datahora, 8, 2) . "/" . substr($datahora, 5, 2) . "/" . substr($datahora, 0, 4) .
                " às " . substr($datahora, 11, 2) . "h" . substr($datahora, 14, 2) . "min"; //.substr($datahora,17,2)."s";
    }
}
?>