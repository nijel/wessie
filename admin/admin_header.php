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
$now = gmdate('D, d M Y H:i:s') . ' GMT';
header('Expires: ' . $now);
header('Last-Modified: ' . $now);
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
error_reporting (E_ALL);
require_once('./auth.php');
require_once('./functions.php');
$page_title=$site_name[0].':Administration:'.$page_name;
$page_title_html='<a href="../index.php">'.$site_name[0].'</a>:<a href="index.php">Administration</a>:'.$page_name;
Header('Content-Type: text/html; charset='.$admin_charset);
show_html_head($page_title);

if (isset($onunload)){
    echo '<body onunload="'.$onunload.'">';
}else{
    echo '<body onunload="unloader()">';
} ?>
<table class="upper">
<tr>
<td class="left">
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
<td class="center">
<h1><?php echo $page_title_html; ?></h1>
</td>
<td class="right">
User:<a href="user_self.php"><?php echo $user_info['name']; ?></a><br />
<a href="logout.php">Logout</a>
</td>
</tr>
</table>
<?php
make_tab_start();
if ($user=='admin' || in_array('category.php',$permissions)) make_tab_item('./category.php','Categories','admin/category');
if ($user=='admin' || in_array('menu.php',$permissions)) make_tab_item('./menu.php','Menu','admin/menu');
if ($user=='admin' || in_array('page.php',$permissions)) make_tab_item('./page.php','Pages','admin/page');
if ($user=='admin' || in_array('download_item.php',$permissions)) make_tab_item('./download_item.php','Downloads','admin/download','admin/files');
if ($user=='admin' || in_array('plugin.php',$permissions)) make_tab_item('./plugin.php','Plugins','admin/plugin');
if ($user=='admin' || in_array('user.php',$permissions)) make_tab_item('./user.php','Users','admin/user');
if ($user=='admin' || in_array('options.php',$permissions)) make_tab_item('./options.php','Options','admin/option');
if ($user=='admin' || in_array('help.php',$permissions)) make_tab_item_window('./help.php?'.urlencode(basename($SCRIPT_NAME)),'?','admin/help.php');
make_tab_end();
?>
