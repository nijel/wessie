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
$page_name='Options:Information';
require_once('./options_header.php');
if (isset($action) && $action=='save'){
    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    if (!config_set_option('\$site_home',"\$site_home = '".$set_site_home."';\n",'##/INFO##')){
        show_error('Can not modify configuration!');
        exit;
    }

    if (!config_set_option('\$site_author_email',"\$site_author_email = '".$set_site_author_email."';\n",'##/INFO##')){
        show_error('Can not modify configuration!');
        exit;
    }

    if (!config_set_option('\$site_started',"\$site_started = mktime(0,0,0,".$set_site_started_m.",".$set_site_started_d.",".$set_site_started_y.");\n",'##/INFO##')){
        show_error('Can not modify configuration!');
        exit;
    }

    config_del_options('^[[:space:]]*\$site_author[[:space:]]*\[');
    config_del_options('^[[:space:]]*\$site_name[[:space:]]*\[');
    config_del_options('^[[:space:]]*\$site_name_long[[:space:]]*\[');
    config_del_options('^[[:space:]]*\$copyright[[:space:]]*\[');
    config_del_options('^[[:space:]]*\$special[[:space:]]*\[');

    reset($languages);
    while (list($key,$val) = each($languages)){
        if (!config_set_option('\$site_author['.$key.']',"\$site_author[$key] = '{$set_site_author[$key]}';\n",'##/INFO##')){
            show_error('Can not modify configuration!');
            exit;
        }
        if (!config_set_option('\$site_name['.$key.']',"\$site_name[$key] = '{$set_site_name[$key]}';\n",'##/INFO##')){
            show_error('Can not modify configuration!');
            exit;
        }
        if (!config_set_option('\$site_name_long['.$key.']',"\$site_name_long[$key] = '{$set_site_name_long[$key]}';\n",'##/INFO##')){
            show_error('Can not modify configuration!');
            exit;
        }
        if (!config_set_option('\$copyright['.$key.']',"\$copyright[$key] = '{$set_copyright[$key]}';\n",'##/INFO##')){
            show_error('Can not modify configuration!');
            exit;
        }
        if (!config_set_option('\$special['.$key.']',"\$special[$key] = '{$set_special[$key]}';\n",'##/INFO##')){
            show_error('Can not modify configuration!');
            exit;
        }
    }

    if (!config_write()){
        show_error('Can not write configuration!');
        exit;
    }

    show_info_box('Information configuration saved.');
    include_once('./admin_footer.php');
    exit;
}
echo '<form action="options_info.php" method="get"><input type="hidden" name="action" value="save"/><table class="item">';

echo "\n<tr><th>Site home</th>\n";
echo '<td><input type="text" class="text" name="set_site_home" value="'.htmlspecialchars($site_home).'" /></td>'."</tr>\n";
echo "\n<tr><th>Authors email</th>\n";
echo '<td><input type="text" class="text" name="set_site_author_email" value="'.htmlspecialchars($site_author_email).'" /></td>'."</tr>\n";
echo "\n<tr><th>Start date (D M Y)</th>\n";
echo '<td><input type="text" width="2" size="2" class="text" name="set_site_started_d" value="'.date('j',$site_started).'" /><input type="text" width="2" size="2" class="text" name="set_site_started_m" value="'.date('n',$site_started).'" /><input type="text" width="4" size="4" class="text" name="set_site_started_y" value="'.date('Y',$site_started).'" /></td>'."</tr>\n";

echo "\n<tr><td>Language dependant</td>\n";
reset($languages);
while (list($key,$val) = each($languages)){
    echo '<th>'.$val['name']."</th>\n";
}
echo "</tr>\n";

echo "\n<tr><th>Site author</th>\n";
reset($languages);
while (list($key,$val) = each($languages)){
    echo '<td><input type="text" class="text" name="set_site_author['.$key.']" value="'.htmlspecialchars($site_author[$key]).'" />'."</td>\n";
}
echo "</tr>\n";

echo "\n<tr><th>Site name</th>\n";
reset($languages);
while (list($key,$val) = each($languages)){
    echo '<td><input type="text" class="text" name="set_site_name['.$key.']" value="'.htmlspecialchars($site_name[$key]).'" />'."</td>\n";
}
echo "</tr>\n";

echo "\n<tr><th>Long site name</th>\n";
reset($languages);
while (list($key,$val) = each($languages)){
    echo '<td><input type="text" class="text" name="set_site_name_long['.$key.']" value="'.htmlspecialchars($site_name_long[$key]).'" />'."</td>\n";
}
echo "</tr>\n";

echo "\n<tr><th>Vopyright</th>\n";
reset($languages);
while (list($key,$val) = each($languages)){
    echo '<td><input type="text" class="text" name="set_copyright['.$key.']" value="'.htmlspecialchars($copyright[$key]).'" />'."</td>\n";
}
echo "</tr>\n";

echo "\n<tr><th>Special information</th>\n";
reset($languages);
while (list($key,$val) = each($languages)){
    echo '<td><input type="text" class="text" name="set_special['.$key.']" value="'.htmlspecialchars($special[$key]).'" />'."</td>\n";
}
echo "</tr>\n";

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
