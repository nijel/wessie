<?
if (!isset($WSS_db_connect_php_loaded)){
	$WSS_db_connect_php_loaded=1;
	if ($db_persistent){
		if (!($db_connection=mysql_pconnect($db_host,$db_user,$db_pass)))
			do_error(1,'pconnect');
	}else{
		if (!($db_connection=mysql_connect($db_host,$db_user,$db_pass)))
			do_error(1,'connect');
	}
	if (!mysql_select_db($db_name,$db_connection))
		do_error(1,'select_db');
}	
?>
