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

if (isset($_SERVER['REQUEST_URI'])){
    $url = '&url=' . urlencode(($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
}else{
    $url = '';
}

if((!isset($_COOKIE['user']))||(!isset($_COOKIE['hash']))){
header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'').'/login.php?failure=unauthorised' . $url);
die();
}
$user=opt_addslashes($_COOKIE['user']);
$hash=$_COOKIE['hash'];

if (!($id_result=mysql_query('SELECT count(user) as count from '.$db_prepend.$table_users.' where user="'.$user.'" and hash="'.$hash.'"',$db_connection)))
    do_error(1,'SELECT '.$db_prepend.$table_users.': '.mysql_error());
$auth=mysql_fetch_array($id_result);
mysql_free_result($id_result);
if ($auth['count']!=1){
    Header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'').'/login.php?failure=unauthorised' . $url);
    die();
}
if (!($id_result=mysql_query('SELECT ip,perms,name from '.$db_prepend.$table_users.' where user="'.$user.'" and hash="'.$hash.'" and time>(NOW() - interval '.$admin_timeout.')',$db_connection)))
    do_error(1,'SELECT '.$db_prepend.$table_users.': '.mysql_error());
if (mysql_num_rows($id_result)!=1){
    Header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'').'/login.php?failure=expired' . $url);
    die();
}

$ip=$_SERVER['REMOTE_ADDR'];
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip .= ' (' . $_SERVER['HTTP_X_FORWARDED_FOR'] . ')';
}

$auth=mysql_fetch_array($id_result);
mysql_free_result($id_result);
if ($auth['ip']!=$ip){
    Header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'').'/login.php?failure=badip' . $url);
    die();
}

if (!(mysql_query('UPDATE '.$db_prepend.$table_users." set time=NOW() where user='".$user."' and hash='".$hash."' limit 1",$db_connection)))
    do_error(1,'UPDATE '.$db_prepend.$table_users.': '.mysql_error());

setcookie ('hash',$hash ,time()+$admin_hash_cookie, dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS));

$permissions = explode(':',$auth['perms']);

if ($user!='admin' && !in_array(basename($_SERVER['SCRIPT_NAME']),$permissions)){
    Header('Content-Type: text/html; charset='.$admin_charset);
    if (!isset($page_title)) $page_title=@$site_name[0].':Administration:'.$page_name;
    show_html_head($page_title);
    show_error_box("You don't have permission to view this!");
    include_once('./admin_footer.php');
    exit;
}
$fullname = $auth['name'];

?>
