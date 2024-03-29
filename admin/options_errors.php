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
$page_name='Options:Errors';
require_once('./options_header.php');
if (isset($action) && $action=='save'){
    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    if (!config_set_option('\$show_error_detail','$show_error_detail = '.(isset($set_show_error_detail)?'TRUE':'FALSE').";\n",'//##/ERRORS##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$error_log_file',"\$error_log_file = '".$set_error_log_file."';\n",'//##/ERRORS##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_write()){
        show_error('Can not write configuration!');
        exit;
    }

    show_info_box('Error configuration saved.');
    include_once('./admin_footer.php');
    exit;
}

echo '<form action="options_errors.php" method="get"><input type="hidden" name="action" value="save" /><table class="item">';
echo "\n<tr><th>Show error details</th>\n";
echo '<td><input type="checkbox" class="check" name="set_show_error_detail" '.($show_error_detail?'checked="checked"':'').' /></td>'."</tr>\n";
echo "\n<tr><th>Error log filename</th>\n";
echo '<td><input type="text" class="text" name="set_error_log_file" value="'.htmlentities($error_log_file).'" /></td>'."</tr>\n";

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
