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
$page_name='Options:Design';
require_once('./options_header.php');
require_once('./file_functions.php');
if (isset($action) && $action=='save'){
    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    if (!config_set_option('\$use_adverts','$use_adverts = '.(isset($set_adverts)?'TRUE':'FALSE').";\n",'//##/DESIGN##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$site_logo',"\$site_logo = '".$set_logo."';\n",'//##/DESIGN##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$site_logo_alt',"\$site_logo_alt = '".$set_logo_alt."';\n",'//##/DESIGN##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$site_logo_width',"\$site_logo_width = ".$set_logo_width.";\n",'//##/DESIGN##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$site_logo_height',"\$site_logo_height = ".$set_logo_height.";\n",'//##/DESIGN##')){
        show_error('Can not modify configuration!');
        exit;
    }

    if (!config_set_option('\$category_order',"\$category_order = '".$set_order."';\n",'//##/DESIGN##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$top_pages_count',"\$top_pages_count = ".$set_top_count.";\n",'//##/DESIGN##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$template_name',"\$template_name = '".$set_template."';\n",'//##/DESIGN##')){
        show_error('Can not modify configuration!');
        exit;
    }


    if (!config_write()){
        show_error('Can not write configuration!');
        exit;
    }

    show_info_box('Design configuraton saved.');
    include_once('./admin_footer.php');
    exit;
}

echo '<form action="options_design.php" method="get"><input type="hidden" name="action" value="save"><table class="item">';

$files=array();
$dirs=array();

$dir = dirname(dirname($SCRIPT_FILENAME)).'/templates';
if (!read_folder($dir,$dirs,$files)){
    show_error('Can not read directory info!');
    exit;
}

unset($files); //we don't need them
natsort($dirs);

echo "\n<tr><th>Template</th>\n";
echo '<td><select class="select" name="set_template">'."\n";
while (list($key,$val)=each($dirs)){
    if ($val!='CVS' && $val{0}!='.'){
        echo '<option value="'.$val.'"'.($template_name==$val?' selected="selected"':'').'>'.$val."</option>\n";
    }
}
echo "</select></td></tr>\n";
echo "\n<tr><th>Site logo</th>\n";
echo '<td><input type="text" class="text" name="set_logo" value="'.$site_logo.'" /></td>'."</tr>\n";
echo "\n<tr><th>Site logo alt</th>\n";
echo '<td><input type="text" class="text" name="set_logo_alt" value="'.$site_logo_alt.'" /></td>'."</tr>\n";
echo "\n<tr><th>Site logo height</th>\n";
echo '<td><input type="text" class="text" name="set_logo_height" value="'.$site_logo_height.'" /></td>'."</tr>\n";
echo "\n<tr><th>Site logo width</th>\n";
echo '<td><input type="text" class="text" name="set_logo_width" value="'.$site_logo_width.'" /></td>'."</tr>\n";
echo "\n<tr><th>Order categories by</th>\n";
echo '<td><select class="select" name="set_order">'."\n";
if (!($id_result=(mysql_query('DESCRIBE '.$db_prepend.$table_category,$db_connection)))){
    show_error("Can't get category info! (".mysql_error().')');
    exit;
}
while ($item = mysql_fetch_array ($id_result)){
    echo '<option value="'.$item['Field'].'"'.($category_order==$item['Field']?' selected="selected"':'').'>'.$item['Field']."</option>\n";
}
mysql_free_result($id_result);
echo "</select></td></tr>\n";
echo "\n<tr><th>Use adverts</th>\n";
echo '<td><input type="checkbox" class="check" name="set_adverts" '.($use_adverts?'checked="checked"':'').' /></td>'."</tr>\n";
echo "\n<tr><th>Top pages count</th>\n";
echo '<td><select class="select" name="set_top_count">'."\n";
$vals = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,20);
while (list($key,$val)=each($vals)){
    echo '<option value="'.$val.'"'.($top_pages_count==$val?' selected="selected"':'').'>'.$val."</option>\n";
}
echo "</select></td></tr>\n";
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
