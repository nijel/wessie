<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | wessie - web site system                                             |
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
$page_title=$site_name[0].':Administration:'.$page_name;
$page_title_html='<a href="../index.php">'.$site_name[0].'</a>:<a href="index.php">Administration</a>:'.$page_name;
Header('Content-Type: text/html; charset='.$admin_charset);
show_html_head($page_title);

if (isset($onunload)){
    echo '<body onunload="'.$onunload.'">';
}else{
    echo '<body>';
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
User:<?php echo $user; ?><br />
<a href="logout.php">Logout</a>
</td>
</tr>
</table>
<?php
make_tab_start();
make_tab_item('./category.php','Categories','/category');
make_tab_item('./menu.php','Menu','/menu');
make_tab_item('./page.php','Pages','/page');
make_tab_item('./download_item.php','Downloads','/download');
make_tab_item('./plugin.php','Plugins','/plugin');
make_tab_item('./user.php','Users','/user');
make_tab_item('./options.php','Options','/option');
make_tab_item_window('./help.php?'.urlencode(basename($SCRIPT_NAME)),'?','/help.php');
make_tab_end();
?>
