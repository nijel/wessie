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
require_once('../db_connect.php');
Header('Content-Type: text/html; charset='.$admin_charset);
$page_title=$site_name[0].':Administration:Login';

// Enforce https also for redirects
if (isset($url) && ($admin_force_ssl || isset($HTTPS)))
    $url = ereg_replace('^http:','https:', $url);

// On each login attempt clean all old hashes
if (!(mysql_query('DELETE FROM '.$db_prepend.$table_logged.' where time<(NOW() - interval '.$admin_timeout.')', $db_connection)))
    do_error(1,'DELETE FROM '.$db_prepend.$table_logged.': '.mysql_error());


// Generate IP address identification
$ip=$REMOTE_ADDR;
$headers = getallheaders();
while (list ($header, $value) = each ($headers)) {
    if ($header=='X-Forwarded-For') {
        $ip.=' ('.$value.')';
    }
}


if (isset($HTTP_POST_VARS['submit'])){
    $pass=md5($HTTP_POST_VARS['pass']);
    $user=opt_addslashes($HTTP_POST_VARS['user']);

    // Check whether selected user exists
    if (!($id_result=mysql_query('SELECT count(user) as count from '.$db_prepend.$table_users.' where user="'.$user.'" and pass="'.$pass.'"',$db_connection)))
            do_error(1,'SELECT '.$db_prepend.$table_users.': '.mysql_error());
    $auth=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if ($auth['count']!=1){
        Header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'').'/login.php?failure=badlogin');
        die();
    }

    if (!$admin_two_step_login) setcookie ('user', $user,time()+$admin_user_cookie, dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS));
    $hash=md5 (uniqid (rand()));
    setcookie ('hash',$hash ,time()+$admin_hash_cookie, dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS));

    // Store authetication info into table
    if (!(mysql_query('REPLACE '.$db_prepend.$table_logged." set hash='".$hash."', time=NOW(), ip= '".$ip."', user='".$user."'",$db_connection)))
        do_error(1,'REPLACE '.$db_prepend.$table_logged.': '.mysql_error());

    if (!isset($url)){
        $url = ($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'') . '/index.php';

    }

    if ($admin_two_step_login) {
        $url2 = ($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'') . '/login.php?step2=1&amp;user='.urlencode($user).'&amp;url='.urlencode($url);
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
} elseif ($admin_two_step_login && isset($HTTP_GET_VARS['step2']) && isset($hash)) {
    $user=opt_addslashes($HTTP_GET_VARS['user']);

    include_once('../db_connect.php');
    if (!($id_result = mysql_query('SELECT count(user) as count from '.$db_prepend.$table_logged." where hash='".$hash."' and time>(NOW() - interval ".$admin_timeout.") and ip= '".$ip."' and user='".$user."'",$db_connection)))
        do_error(1,'SELECT count(user) as count from '.$db_prepend.$table_logged.': '.mysql_error());

    $auth=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if ($auth['count']!=1){
        Header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'').'/login.php?failure=badlogin');
        die();
    }

    setcookie ('user', $user,time()+$admin_user_cookie, dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS));

    if (!isset($url)){
        $url = ($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'') . '/index.php';

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
setcookie ('hash', '',time()-3600, dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS)); //delete cookie

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
else echo '<p class="error">Warning: Non-secure connection is being used.</p><p class="info"><a href="https://'.$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'') . '/login.php'.(isset($url) ? '?url='.urlencode($url) : '' ).'">Try to use it</a></p>';
?>
<hr width="100%" />
<p class="note">Your browser must have cookies enabled to administrate this site.</p>
</center>
</body>
</html>
