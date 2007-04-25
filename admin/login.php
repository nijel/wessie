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
Header('Pragma: no-cache');
Header("Expires: " . GMDate("D, d M Y H:i:s") . " GMT");
error_reporting (E_ALL);
$remove_path='admin/';
require_once('../init.php');
require_once('../config.php');
require_once('./functions.php');
Header('Content-Type: text/html; charset='.$admin_charset);
$page_title=$site_name[0].':Administration:Login';

// enforce https also for redirects
if (isset($url) && ($admin_force_ssl || isset($HTTPS)))
    $url = ereg_replace('^http:','https:', $url);

if (isset($_POST['submit'])){
    $pass=md5($_POST['pass']);
    $user=opt_addslashes($_POST['user']);

    include_once('../db_connect.php');
    if (!($id_result=mysql_query('SELECT count(user) as count from '.$db_prepend.$table_users.' where user="'.$user.'" and pass="'.$pass.'"',$db_connection)))
            do_error(1,'SELECT '.$db_prepend.$table_users.': '.mysql_error());
    $auth=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if ($auth['count']!=1){
        Header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'').'/login.php?failure=badlogin');
        die();
    }

    if (!$admin_two_step_login) setcookie ('user', $user,time()+$admin_user_cookie, dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS));
    $hash=md5 (uniqid (rand()));
    setcookie ('hash',$hash ,time()+$admin_hash_cookie, dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS));

    $ip=$_SERVER['REMOTE_ADDR'];
    while (list ($header, $value) = each ($_ENV)) {
        if ($header=='X-FORWARDED-FOR') {
            $ip.=' ('.$value.')';
        }
    }

    if (!(mysql_query('UPDATE '.$db_prepend.$table_users." set hash='".$hash."', time=NOW(), ip= '".$ip."' where user='".$user."' and pass='".$pass."' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$db_prepend.$table_users.': '.mysql_error());

    if (!isset($url)){
        $url = ($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'') . '/index.php';

    }

    if ($admin_two_step_login) {
        $url2 = ($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'') . '/login.php?step2=1&amp;user='.urlencode($user).'&amp;url='.urlencode($url);
    } else {
        $url2 = $url;
    }

    show_html_head('REDIRECT','<meta http-equiv="Refresh" content="0; URL='.$url2.'" />');
?>
<body>
<a href="<?php echo $url2; ?>">REDIRECT</a>
</body>
</html>
<?php
    die();
} elseif ($admin_two_step_login && isset($_GET['step2']) && isset($_COOKIE['hash'])) {
    $user=opt_addslashes($_GET['user']);

    include_once('../db_connect.php');
    if (!($id_result=mysql_query('SELECT count(user) as count from '.$db_prepend.$table_users.' where user="'.$user.'" and hash="'.$_COOKIE['hash'].'"',$db_connection)))
            do_error(1,'SELECT '.$db_prepend.$table_users.': '.mysql_error());
    $auth=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if ($auth['count']!=1){
        Header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'').'/login.php?failure=badlogin');
        die();
    }

    setcookie ('user', $user,time()+$admin_user_cookie, dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS));

    if (!isset($url)){
        $url = ($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'') . '/index.php';

    }

    show_html_head('REDIRECT','<meta http-equiv="Refresh" content="0; URL='.$url.'" />');

?>
<body>
<a href="<?php echo $url; ?>">REDIRECT</a>
</body>
</html>
<?php
    die();

}
setcookie ('hash', '',time()-3600, dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS)); //delete cookie

show_html_head($page_title);
?>
<body>
<table class="upper">
<tr>
<td>
<h2><?php echo $page_title?></h2>
</td>
</tr>
</table>
<hr width="100%" />
<center>
<?php

if (isset($failure)){
    if ($failure=='expired'){
        echo '<p class="error">Your login has expired!</p>';
    }elseif ($failure=='badip'){
        echo '<p class="error">You changed ip address!</p>';
    }elseif ($failure=='unauthorised'){
        echo '<p class="error">You are not authorised to access this!</p>';
    }elseif ($failure=='badlogin'){
        echo '<p class="error">Bad login!</p>';
    }elseif ($failure=='logout'){
        echo '<p class="info">Logout successful!</p>';
    }
}
?>
<p class="info">You must login before accessing administration.</p>
<br />
<form action="login.php" method="post">
<?php
if (isset($url)){
    echo '<input type="hidden" name="url" value="' . $url . '" />';
}
?>
<table class="login">
  <tr>
    <th>Username:</th>
    <td><input type="text" name="user" value="<?php echo isset($user)?$user:''?>" class="username" /></td>
  </tr>
  <tr>
    <th>Password:</th>
    <td><input type="password" name="pass" class="password" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="reset" value=" Reset " class="reset" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" Login " class="login" /></td>
  </tr>
</table>
<input type="hidden" name="submit" value="1" />
</form><br /><br />
<hr width="100%" />
<?php
if (isset($HTTPS)) echo '<p class="info">Secure connection is being used.</p>';
else echo '<p class="error">Warning: Non-secure connection is being used.</p><p class="info"><a href="https://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).(substr(dirname($_SERVER['SCRIPT_NAME']),-5)!='admin'?'admin':'') . '/login.php'.(isset($url) ? '?url='.urlencode($url) : '' ).'">Try to use it</a></p>';
?>
<hr width="100%" />
<p class="note">Your browser must have cookies enabled to administrate this site.</p>
</center>
</body>
</html>
