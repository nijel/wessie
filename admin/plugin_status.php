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
$page_name='Plugins';
require_once('./admin_header.php');
require_once('./file_functions.php');

if ($action!='install' && $action!='uninstall' ){
    show_error_box('Error: Bad action!');
    include_once('./admin_footer.php');
    exit;
}

if ($action=='uninstall' && $admin_confirm_uninstall && (!isset($confirm) || $confirm!='yes')) {
    $plugin_page=FALSE;
    $plugin_function=FALSE;
    if (file_exists('../plugins/'.$name.'/main.php')){
        require_once('../plugins/'.$name.'/main.php');
    } else {
        show_error_box('Error: Selected plugin ("'.$name.'") not accessible!');
        include_once('./admin_footer.php');
        exit;
    }
    echo 'Do you want to uninstall plugin '.$name."?<br />\n";
    if ($plugin_page) echo "It's page part is used by ".get_page_count($name)." pages.<br />\n";
    if ($plugin_function) echo "It's function part can be still used in some pages.<br />\n";
?>
<table class="yesno">
  <tr>
    <td>
<form action="plugin_status.php" method="post" class="delete">
<input type="hidden" name="action" value="uninstall" />
<input type="hidden" name="name" value="<?php echo $name; ?>" />
<input type="hidden" name="confirm" value="yes" />
<input type="submit" value=" Yes " class="delete" />
</form>
    </td>
    <td><?php make_return_button(' No ');?> </td>
  </tr>
</table>
<?php
} else {
    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    $error='';

    chdir('../');

    if (file_exists('./plugins/'.$name.'/'.$action.'.php')){
        echo ($action=='install'?'I':'Uni').'nstallation progress:<br /><pre>';
        require_once('./plugins/'.$name.'/'.$action.'.php');
    } else {
        show_error_box('Error: Selected plugin ("'.$name.'") not accessible!');
        include_once('./admin/admin_footer.php');
        exit;
    }

    echo '</pre>';

    chdir('admin');

    if ($error != ''){
        show_error_box('An error occured!<br/ >'.$error);
    } else {
        if ($action=='install'){
            $installed_plugins[]=$name;
        } else {
            $key = array_search($name,$installed_plugins);
            unset($installed_plugins[$key]);
        }

        $installed_plugins_text='';
        $del='';
        reset($installed_plugins);
        while (list($key,$val) = each($installed_plugins)) {
            $installed_plugins_text .= $del."'".$val."'";
            $del = ', ';
        }

        if (!config_set_option('\$installed_plugins','$installed_plugins = array('.$installed_plugins_text.");\n",'//##/PLUGIN_COMMON##')){
            show_error('Can not modify configuration!');
            exit;
        }

        if (!config_write()){
            show_error('Can not write configuration!');
            exit;
        }


        show_info_box('Action performed',array(),'plugin.php');
    }
}

require_once('./admin_footer.php');
?>
