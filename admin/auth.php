<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// / wessie - web site system                                             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2001 Michal Cihar                                      |
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

setcookie ("hash",$hash ,time()+3600, dirname($REQUEST_URI));//valid one hour
?>