<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | wessie - web site system                                             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2001-2002 Michal Cihar                                 |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version.                                  |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 |
// | USA                                                                  |
// +----------------------------------------------------------------------+
// | Authors: Michal Cihar <cihar at email dot cz>                        |
// +----------------------------------------------------------------------+
//
// $Id$
$remove_path='admin/';
require_once('../init.php');
require_once('../config.php');
require_once('../errors.php');

require_once('../db_connect.php');
require_once('./functions.php');

if (isset($REQUEST_URI)){
    $url = '&url=' . urlencode('http://' . $SERVER_NAME . $REQUEST_URI);
}else{
    $url = '';
}

if((!isset($HTTP_COOKIE_VARS['user']))||(!isset($HTTP_COOKIE_VARS['hash']))){
header('Location: http://'.$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'').'/login.php?failure=unauthorised' . $url);
die();
}
$user=opt_addslashes($HTTP_COOKIE_VARS['user']);
$hash=$HTTP_COOKIE_VARS['hash'];

if (!($id_result=mysql_query('SELECT count(user) as count from '.$db_prepend.$table_users.' where user="'.$user.'" and hash="'.$hash.'"',$db_connection)))
    do_error(1,'SELECT '.$db_prepend.$table_users.': '.mysql_error());
$auth=mysql_fetch_array($id_result);
mysql_free_result($id_result);
if ($auth['count']!=1){
    Header('Location: http://'.$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'').'/login.php?failure=unauthorised' . $url);
    die();
}
if (!($id_result=mysql_query('SELECT ip,perms,name from '.$db_prepend.$table_users.' where user="'.$user.'" and hash="'.$hash.'" and time>(NOW() - interval '.$admin_timeout.')',$db_connection)))
    do_error(1,'SELECT '.$db_prepend.$table_users.': '.mysql_error());
if (mysql_num_rows($id_result)!=1){
    Header('Location: http://'.$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'').'/login.php?failure=expired' . $url);
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
    Header('Location: http://'.$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'').'/login.php?failure=badip' . $url);
    die();
}

if (!(mysql_query('UPDATE '.$db_prepend.$table_users." set time=NOW() where user='".$user."' and hash='".$hash."' limit 1",$db_connection)))
    do_error(1,'UPDATE '.$db_prepend.$table_users.': '.mysql_error());

setcookie ('hash',$hash ,time()+$admin_hash_cookie, dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':''));

$permissions = explode(':',$auth['perms']);

if ($user!='admin' && !in_array(basename($SCRIPT_NAME),$permissions)){
    Header('Content-Type: text/html; charset='.$admin_charset);
    if (!isset($page_title)) $page_title=@$site_name[0].':Administration:'.$page_name;
    show_html_head($page_title);
    show_error_box("You don't have permission to view this!");
    include_once('./admin_footer.php');
    exit;
}
$fullname = $auth['name'];

?>