<?
function log_error($what){
global $error_log_file;
$fh=fopen($error_log_file,'a');
fwrite($fh,'--- '. GMDate('D, d M Y H:i:s')." ---\n");
fwrite($fh,$what."\n");
fclose($fh);
}

function do_error($err_no,$err_nfo){
/*
1 - database
2 - language file
*/
global $SERVER_PROTOCOL, $site_name;
header ($SERVER_PROTOCOL.' 503 Service temporarily unavailable');
echo "<html><head><title>$site_name</title></head><body>
<h2> $site_name site is temporary unavailable</h2>
<h3> $SERVER_PROTOCOL 503 Service temporarily unavailable</h3>";
//<!--";
$err_msg="Internal error $err_no: ";
switch ($err_no){
	case 1:
		$err_msg.='Error occured while working with database!';
		break;
	case 2:
		$err_msg.='Error occured while loading language file!';
		break;
	case 3:
		$err_msg.='Error occured while loading template file!';
		break;
	case 4:
		$err_msg.='Error occured while loading data file!';
		break;
	default:
		$err_msg.='Unknown error';
}
$err_msg.="\nError info: $err_nfo\n";
echo $err_msg;
log_error($err_msg);
echo '<br>This site has currently some technical problems. Please try connecting later.<br>
There is no need to contact administrator, because he surely knows about this....
</body></html>';
exit;
}
?>
