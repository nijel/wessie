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
require_once('./auth.php');
require_once('./functions.php');
$page_title=$site_name.':Administration:'.$page_name;
Header('Content-Type: text/html; charset='.$admin_charset);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                  "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $admin_charset?>" />
    <title><?php echo $page_title?></title>
    <meta name="Author" content="<?php echo $wss_author?>" />
    <meta name="Generator" content="<?php echo $wss_version.', Copyright (C) 2001 '.$wss_author?>" />
    <link rel="home" href="<?php echo $site_home?>" />
    <link rel="copyright" href="mailto:<?php echo $wss_author?>" />
  <script language="JavaScript" type="text/javascript">
  <!--
     if(top != self) { window.top.location.href=location; }
  //-->
  </script>
</head>

<body bgcolor="gray" text="white" link="#eeee00" alink="yellow" vlink="#dddd00">
<table border="0" width="100%">
<tr>
<td align="center" width="200">
<?php
    if ($fd = fopen('/proc/uptime', 'r')){
        $ar_buf = split( ' ', fgets( $fd, 4096 ) );
        fclose( $fd );

        $sys_ticks = trim( $ar_buf[0] );

        $min   = $sys_ticks / 60;
        $hours = $min / 60;
        $days  = floor( $hours / 24 );
        $hours = floor( $hours - ($days * 24) );
        $min   = floor( $min - ($days * 60 * 24) - ($hours * 60) );

        if ( $days != 0 ) {
                $result = $days.' d, ';
        } else $result = '';
        $result .= $hours.':'.sprintf('%02d',$min);
        echo 'Uptime:&nbsp;'.$result;
    }

    if ( $fd = fopen('/proc/loadavg', 'r') ) {
        $results = split( ' ', fgets( $fd, 4096 ) );
        echo '<br />Load:&nbsp;'.$results[0].'&nbsp;'.$results[1].'&nbsp;'.$results[2];
        fclose( $fd );
    }
?>
</td>
<td align="center">
<h2><?php echo $page_title?></h2>
</td>
<td align="center" width="200">
User:<?php echo $user?><br />
<a href="logout.php">Logout</a>
</td>
</tr>
</table>
<hr width="100%" />
<table width="100%" border="0">
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="12%" align="center"><a href="category.php">Categories</a></td>
    <td width="12%" align="center"><a href="menu.php">Menu</a></td>
    <td width="12%" align="center"><a href="pages.php">Pages</a></td>
    <td width="12%" align="center"><a href="articles.php">Articles</a></td>
    <td width="12%" align="center"><a href="downloads.php">Downloads</a></td>
    <td width="12%" align="center"><a href="plugins.php">Plugins</a></td>
    <td width="12%" align="center"><a href="users.php">Users</a></td>
    <td width="12%" align="center"><a href="options.php">Options</a></td>
    <td width="2%">&nbsp;</td>
  </tr>
</table>
<hr width="100%" />
