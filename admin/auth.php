<?
require_once('../init.php');
require_once('../config.php');
require_once('../errors.php');
require_once('../db_connect.php');

if((!isset($HTTP_COOKIE_VARS['user']))||(!isset($HTTP_COOKIE_VARS['hash']))){
header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI).(substr(dirname($REQUEST_URI),-5)!='admin'?'admin':'').'/login.php?unauthorised');
die();
}
$user=$HTTP_COOKIE_VARS['user'];
$hash=$HTTP_COOKIE_VARS['hash'];

if (!($id_result=mysql_query('SELECT count(user) as count from '.$table_prepend_name.$table_users.' where user="'.$user.'" and hash="'.$hash.'"',$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_users.': '.mysql_error());
$auth=mysql_fetch_array($id_result);
mysql_free_result($id_result);
if ($auth['count']!=1){
    Header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI).'/login.php?unauthorised');
    die();
}
if (!($id_result=mysql_query('SELECT ip from '.$table_prepend_name.$table_users.' where user="'.$user.'" and hash="'.$hash.'" and time>(NOW() - interval '.$admin_timeout.')',$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_users.': '.mysql_error());
if (mysql_num_rows($id_result)!=1){
    Header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI).'/login.php?expired');
    die();
}

$ip=$REMOTE_ADDR;
$headers = getallheaders();
while (list ($header, $value) = each ($headers)) {
    if ($header=='X-Forwarded-For') {
        $ip.=' ('.$value.')';
    }
}

$auth=mysql_fetch_array($id_result);
mysql_free_result($id_result);
if ($auth['ip']!=$ip){
    Header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI).'/login.php?badip');
    die();
}

if (!(mysql_query('UPDATE '.$table_prepend_name.$table_users." set time=NOW() where user='".$user."' and hash='".$hash."' limit 1",$db_connection)))
    do_error(1,'UPDATE '.$table_prepend_name.$table_users.': '.mysql_error());


?>