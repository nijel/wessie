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
$page_name='Options:Database';
require_once('./options_header.php');

if (isset($action) && $action=='save'){
    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    if (!config_set_option('\$db_persistent','$db_persistent = '.(isset($set_persistent)?'TRUE':'FALSE').";\n",'//##/DATABASE##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$db_host',"\$db_host = '".$set_host."';\n",'//##/DATABASE##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$db_user',"\$db_user = '".$set_user."';\n",'//##/DATABASE##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$db_pass',"\$db_pass = '".$set_pass."';\n",'//##/DATABASE##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$db_name',"\$db_name = '".$set_name."';\n",'//##/DATABASE##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$db_prepend',"\$db_prepend = '".$set_prepend."';\n",'//##/DATABASE##')){
        show_error('Can not modify configuration!');
        exit;
    }

    while (list($key,$val) = each($set_table)){
        if (!config_set_option('\$table_'.$key,"\$table_$key = '".$set_table[$key]."';\n",'//##/TABLES##')){
            show_error('Can not modify configuration!');
            exit;
        }
    }

    if (!config_write()){
        show_error('Can not write configuration!');
        exit;
    }

    show_info_box('Database configuraton saved. <br />When you press button. new configuration will be used also for this session and if you changed anything related to authorisation, your will have to login again.');
    include_once('./admin_footer.php');
    exit;
}

show_warning('When you change database settings, all data may be inaccessible from web and you will have to transfer it to other MySQL account or edit configuration file (config.php) directly to set correct values.');
echo '<form action="options_database.php" method="get"><input type="hidden" name="action" value="save"><table class="item">';
echo "\n<tr><th>Host</th>\n";
echo '<td><input type="text" class="text" name="set_host" value="'.$db_host.'" /></td>'."</tr>\n";
echo "\n<tr><th>User</th>\n";
echo '<td><input type="text" class="text" name="set_user" value="'.$db_user.'" /></td>'."</tr>\n";
echo "\n<tr><th>Passowd</th>\n";
echo '<td><input type="text" class="text" name="set_pass" value="'.$db_pass.'" /></td>'."</tr>\n";
echo "\n<tr><th>Database</th>\n";
echo '<td><input type="text" class="text" name="set_name" value="'.$db_name.'" /></td>'."</tr>\n";
echo "\n<tr><th>Persistent</th>\n";
echo '<td><input type="checkbox" class="check" name="set_persistent" '.($db_persistent?'checked="checked"':'').' /></td>'."</tr>\n";
echo "\n<tr><th>Table prepend name</th>\n";
echo '<td><input type="text" class="text" name="set_prepend" value="'.$db_prepend.'" /></td>'."</tr>\n";



$tables = get_filtered_vars('table_');
reset($tables);
while (list($key,$val) = each($tables)){
    $name = substr($key,6);
    echo "\n<tr><th>Table <code>$name</code> name</th>\n";
    echo '<td><input type="text" class="text" name="set_table['.$name.']" value="'.$val.'" /></td>'."</tr>\n";
}

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
