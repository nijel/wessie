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
$page_name='Options:Languages';
require_once('./options_header.php');

if (isset($_REQUEST['action']) && $_REQUEST['action']=='save'){
    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    if (!config_set_option('\$default_lang',"\$default_lang = ".$_REQUEST['set_default_lang'].";\n",'##/LANGUAGES##')){
        show_error('Can not modify configuration!');
        exit;
    }

    if (!config_set_option('\$lang_file',"\$lang_file = '".ereg_replace("'","\\'",$_REQUEST['set_lang_file'])."';\n",'##/LANGUAGES##')){
        show_error('Can not modify configuration!');
        exit;
    }


    //delete all options and then set them again

    config_del_options('^[[:space:]]*\$languages[[:space:]]*\[[[:space:]]*[0-9]*[[:space:]]*\]');
    config_del_options('^[[:space:]]*\$lang_alias[[:space:]]*\[');

    while (list($key,$val) = each($_REQUEST['set_languages'])){
        while (list($key2,$val2) = each($val)){
            if (!config_set_option('\$languages['.$key."]['$key2']","\$languages[$key]['$key2'] = '".ereg_replace("'","\\'",$val2)."';\n",'##/LANGUAGES##')){
                show_error('Can not modify configuration!');
                exit;
            }
        }
        $aliases = explode(',',$_REQUEST['set_aliases'][$key]);
        while (list($key2,$val2) = each($aliases)){
            if (!config_set_option('\$lang_alias['."'$val2']","\$lang_alias['$val2'] = $key;\n",'##/LANGUAGES##')){
                show_error('Can not modify configuration!');
                exit;
            }
        }
    }

    if (!config_write()){
        show_error('Can not write configuration!');
        exit;
    }

    show_info_box('Languages configuration saved.');
    include_once('./admin_footer.php');
    exit;
} elseif (isset($_REQUEST['action']) && $_REQUEST['action']=='create'){
    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    // find first empty key
    $key = 0;
    while (isset($languages[$key])) $key++;

    while (list($key2,$val2) = each($newlng)){
        if (!config_set_option('\$languages['.$key."]['$key2']","\$languages[$key]['$key2'] = '".ereg_replace("'","\\'",$val2)."';\n",'##/LANGUAGES##')){
            show_error('Can not modify configuration!');
            exit;
        }
    }

    $aliases = explode(',',$newaliases);
    while (list($key2,$val2) = each($aliases)){
        if (!config_set_option('\$lang_alias['."'$val2']","\$lang_alias['$val2'] = $key;\n",'##/LANGUAGES##')){
            show_error('Can not modify configuration!');
            exit;
        }
    }

    if (!config_write()){
        show_error('Can not write configuration!<br/>Now you should go to site information page and add there information in this language.');
        exit;
    }

    show_info_box('Language created.');
    include_once('./admin_footer.php');
    exit;
} elseif (isset($_REQUEST['action']) && $_REQUEST['action']=='delete'){
    if (!isset($languages[$_REQUEST['delete_language']])){
        show_error('You tried to delete non existent language!');
        exit;
    }

    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    config_del_options('^[[:space:]]*\$languages[[:space:]]*\[[[:space:]]*'.$_REQUEST['delete_language'].'[[:space:]]*\]');
    config_del_options('^[[:space:]]*\$lang_alias[[:space:]]*\[[[:space:]]*'."'[^']*'".'[[:space:]]*\][[:space:]]*=[[:space:]]*'.$_REQUEST['delete_language'].'[[:space:]]*;');

    if (!config_write()){
        show_error('Can not write configuration!');
        exit;
    }

    show_info_box('Language deleted.');
    include_once('./admin_footer.php');
    exit;
}

echo '<form action="options_languages.php" method="get"><input type="hidden" name="action" value="save"/><table class="item">';

echo "\n<tr><th>Default language</th>\n";
echo '<td colspan="5">';
language_edit($default_lang,FALSE,'set_default_lang');
echo '</td>'."</tr>\n";

echo "\n<tr><th>Language file</th>\n";
echo '<td colspan="5"><input type="text" class="text" name="set_lang_file" value="'.htmlspecialchars($lang_file).'" /></td>'."</tr>\n";

echo '<tr><th>Id</th>';
echo '<th>Short</th>';
echo '<th>Name</th>';
echo '<th>Image</th>';
echo '<th>Page ID</th>';
echo '<th>Alias(es)</th></tr>';

reset($languages);
while (list($key,$val) = each($languages)){
    echo '<tr><th>'.$key.'</th>';
    echo '<td><input type="text" class="text" name="set_languages['.$key."][short]".'" value="'.htmlspecialchars($val['short']).'" /></td>'."\n";
    echo '<td><input type="text" class="text" name="set_languages['.$key."][name]".'" value="'.htmlspecialchars($val['name']).'" /></td>'."\n";
    echo '<td><input type="text" class="text" name="set_languages['.$key."][image]".'" value="'.htmlspecialchars($val['image']).'" /></td>'."\n";
    echo '<td><input type="text" class="text" name="set_languages['.$key."][page]".'" value="'.htmlspecialchars($val['page']).'" /></td>'."\n";
    echo '<td><input type="text" class="text" name="set_aliases['.$key.']" value="';
    reset($lang_alias);
    $first = true;
    while (list($key2,$val2) = each($lang_alias)){
        if ($val2 == $key) {
            if ($first) $first = false;
            else echo ',';
            echo $key2;
        }
    }
    echo '" /></td>'."\n";
    echo "</tr>\n";
}

?>
<tr><th></th><td colspan="3">
<table class="savereset">
  <tr>
    <td align="center"><input type="submit" value=" Save " class="save" /></td>
    <td align="center"><input type="reset" value=" Reset " class="reset" /></td>
  </tr>
</table>
</td><td></td></tr>
</table>
</form>

<hr/>
<form action="options_languages.php" method="get"><input type="hidden" name="action" value="create" />
Create new language:<br/>
<table class="item">
<tr><th>Id</th>
<th>Short</th>
<th>Name</th>
<th>Image</th>
<th>Page ID</th>
<th>Alias(es)</th>
<th>&nbsp;</th></tr>
<tr><th>Auto</th>
<td><input type="text" class="text" name="newlng[short]"/></td>
<td><input type="text" class="text" name="newlng[name]"/></td>
<td><input type="text" class="text" name="newlng[image]"/></td>
<td><input type="text" class="text" name="newlng[page]"/></td>
<td><input type="text" class="text" name="newaliases" /></td>
<td><input type="submit" value=" Go " class="save" /></td>
</tr>
</table>
</tr>
</form>

<hr/>
<form action="options_languages.php" method="get"><input type="hidden" name="action" value="delete" />
Delete language (no confirmation!):<br/>
<?php language_edit($default_lang,FALSE,'delete_language'); ?><input type="submit" value=" Go " class="save" />
</form>
<?php
require_once('./admin_footer.php');
?>
