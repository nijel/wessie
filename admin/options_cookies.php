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
$page_name='Options:Cookies';
require_once('./options_header.php');
if (isset($action) && $action=='save'){
    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    if (!config_set_option('\$cookie_count',"\$cookie_count = '".$set_cookie_count."';\n",'//##/COOKIES##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$cookie_lang',"\$cookie_lang = '".$set_cookie_lang."';\n",'//##/COOKIES##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$session_time',"\$session_time = ".$set_session_time.";\n",'//##/COOKIES##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$lang_time',"\$lang_time = ".$set_lang_time.";\n",'//##/COOKIES##')){
        show_error('Can not modify configuration!');
        exit;
    }

    if (!config_write()){
        show_error('Can not write configuration!');
        exit;
    }

    show_info_box('Cookie configuration saved.');
    include_once('./admin_footer.php');
    exit;
}

echo '<form action="options_cookies.php" method="get"><input type="hidden" name="action" value="save" /><table class="item">';
echo "\n<tr><th>Counter cookie name</th>\n";
echo '<td><input type="text" class="text" name="set_cookie_count" value="'.htmlentities($cookie_count).'" /></td>'."</tr>\n";
echo "\n<tr><th>Language cookie name</th>\n";
echo '<td><input type="text" class="text" name="set_cookie_lang" value="'.htmlentities($cookie_lang).'" /></td>'."</tr>\n";
echo "\n<tr><th>Session time</th>\n";
echo '<td><input type="text" class="text" name="set_session_time" value="'.$session_time.'" /></td>'."</tr>\n";
echo "\n<tr><th>Language cookie validity</th>\n";
echo '<td><input type="text" class="text" name="set_lang_time" value="'.$lang_time.'" /></td>'."</tr>\n";
?>
<tr><th></th><td>
<table class="savereset">
  <tr>
    <td align="center"><input type="submit" value=" Save " class="save" /></td>
    <td align="center"><input type="reset" value=" Reset " class="reset" /></td>
  </tr>
</table>
</td><td></td></tr>
</table>
</form>
<?php
require_once('./admin_footer.php');
?>
