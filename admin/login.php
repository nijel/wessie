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
Header('Pragma: no-cache');
Header("Expires: " . GMDate("D, d M Y H:i:s") . " GMT");
error_reporting (E_ALL);
require_once('../init.php');
require_once('../config.php');
Header('Content-Type: text/html; charset='.$admin_charset);
$page_title=$site_name.':Administration:Login';
if (isset($HTTP_POST_VARS['submit'])){
    $pass=$HTTP_POST_VARS['pass'];
    $user=$HTTP_POST_VARS['user'];

    include_once('../db_connect.php');
    if (!($id_result=mysql_query('SELECT count(user) as count from '.$table_prepend_name.$table_users.' where user="'.$user.'" and pass="'.$pass.'"',$db_connection)))
            do_error(1,'SELECT '.$table_prepend_name.$table_users.': '.mysql_error());
    $auth=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if ($auth['count']!=1){
        Header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI).'/login.php?failure=badlogin');
        die();
    }


    setcookie ("user", $user,time()+2592000, dirname($REQUEST_URI));//valid one month
    $hash=md5 (uniqid (rand()));
    setcookie ("hash",$hash ,time()+3600, dirname($REQUEST_URI));//valid one hour

    $ip=$REMOTE_ADDR;
    $headers = getallheaders();
    while (list ($header, $value) = each ($headers)) {
        if ($header=='X-Forwarded-For') {
            $ip.=' ('.$value.')';
        }
    }

    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_users." set hash='".$hash."', time=NOW(), ip= '".$ip."' where user='".$user."' and pass='".$pass."' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_users.': '.mysql_error());

    if (!isset($url)){
        $url = 'http://' .  $SERVER_NAME . dirname($REQUEST_URI) . '/index.php';

    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                  "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Refresh" content="0; URL=<?php echo $url; ?>" />
    <link rel="StyleSheet" href="./admin.css" type="text/css" media="screen" />
</head>
<body>
<a href="<?php echo $url; ?>">REDIRECT</a>
</body>
</html>
<?php
    die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                  "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $admin_charset?>" />
    <title><?php echo $page_title?></title>
    <meta name="Author" content="<?php echo $wessie_author?>" />
    <meta name="Generator" content="<?php echo $wessie_version.', Copyright (C) 2001 '.$wessie_author?>" />
    <link rel="copyright" href="mailto:<?php echo $wessie_author?>" />
    <link rel="StyleSheet" href="./admin.css" type="text/css" media="screen" />
    <link rel="home" href="<?php echo $site_home?>" />
    <script language="JavaScript" type="text/javascript" src="./admin.js"></script>
</head>
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
<p class="note">Your browser must have cookies enabled to administrate this site.</p>
</center>
</body>
</html>
