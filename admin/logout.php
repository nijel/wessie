<?
Header('Pragma: no-cache');
Header("Expires: " . GMDate("D, d M Y H:i:s") . " GMT");
setcookie ("hash", '',time()+1800, dirname($REQUEST_URI), $SERVER_NAME);//valid half hour
header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI).'/login.php?logout');
?>