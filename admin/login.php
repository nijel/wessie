<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Web Site System version 0.1                                          |
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
$page_title=$site_name.':Administration:Login';
Header('Content-Type: text/html; charset='.$admin_charset);
if (isset($HTTP_POST_VARS['submit'])){
    $pass=$HTTP_POST_VARS['pass'];
    $user=$HTTP_POST_VARS['user'];

    include_once('../db_connect.php');
    if (!($id_result=mysql_query('SELECT count(user) as count from '.$table_prepend_name.$table_users.' where user="'.$user.'" and pass="'.$pass.'"',$db_connection)))
            do_error(1,'SELECT '.$table_prepend_name.$table_users.': '.mysql_error());
    $auth=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if ($auth['count']!=1){
        Header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI).'/login.php?badlogin');
        die();
    }


    setcookie ("user", $user,time()+2592000, dirname($REQUEST_URI), $SERVER_NAME);//valid one month
    $hash=md5 (uniqid (rand()));
    setcookie ("hash",$hash ,time()+3600, dirname($REQUEST_URI), $SERVER_NAME);//valid one hour

    $ip=$REMOTE_ADDR;
    $headers = getallheaders();
    while (list ($header, $value) = each ($headers)) {
        if ($header=='X-Forwarded-For') {
            $ip.=' ('.$value.')';
        }
    }

    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_users." set hash='".$hash."', time=NOW(), ip= '".$ip."' where user='".$user."' and pass='".$pass."' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_users.': '.mysql_error());

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Final//EN">
<HTML>
<HEAD>
   <META HTTP-EQUIV="Refresh" CONTENT="0;url=http://<?php echo $SERVER_NAME.dirname($REQUEST_URI)?>/index.php">
</HEAD>
<BODY>
</BODY>
</HTML>
<?php
    die();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Final//EN">
<HTML>
<HEAD>
    <TITLE><?php echo $page_title?></TITLE>
    <link rel="home" href="<?php echo $site_home?>">
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php echo $admin_charset?>">
    <META NAME="Author" CONTENT="<?php echo $wss_author?>">
    <link rel="copyright" href="mailto:<?php echo $wss_author?>">
    <META NAME="Generator" CONTENT="<?php echo $wss_version.', Copyright (C) 2001 '.$wss_author?>">
  <SCRIPT language="JavaScript">
  <!--
     if(top != self) { window.top.location.href=location; }
  //-->
  </SCRIPT>
</HEAD>
<body bgcolor="gray" text="white" link="#eeee00" alink="yellow" vlink="#dddd00">
<table border="0" width="100%">
<tr>
<td align="center">
<h2><?php echo $page_title?></h2>
</td>
</tr>
</table>
<hr width="100%">
<center>
<?php
if ($QUERY_STRING=='expired'){?>
<b><font color="red">Your login has expired!</font></b><br>
<?php }elseif ($QUERY_STRING=='badip'){?>
<b><font color="red">You changed ip address!</font></b><br>
<?php }elseif ($QUERY_STRING=='unauthorised'){?>
<b><font color="red">You are not authorised to access this!</font></b><br>
<?php }elseif ($QUERY_STRING=='badlogin'){?>
<b><font color="red">Bad login!</font></b><br>
<?php }elseif ($QUERY_STRING=='logout'){?>
<b>Logout successful!</b><br>
<?php }
//elseif ($QUERY_STRING==''){
//}
?>
You must login before accessing administration.<br>
<br><form action="login.php" method="POST">
<table>
  <tr>
    <th>Username:</th>
    <td><input type="text" name="user" value="<?php echo isset($user)?$user:''?>"></td>
  </tr>
  <tr>
    <th>Password:</th>
    <td><input type="password" name="pass"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="reset" value=" Reset ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" Login "></td>
  </tr>
</table>
<input type="hidden" name="submit" value=1>
</form><br><br>
<hr width="100%">
<small>Your browser must have cookies enabled to administrate this site.</small>
</center>
</BODY>
</HTML>
