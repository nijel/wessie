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

if (isset($action) && ($action=='save')){
    $files=array();
    $dirs=array();

    $dir = dirname(dirname($SCRIPT_FILENAME)).'/plugins';
    if (!read_folder($dir,$dirs,$files)){
        show_error('Can not read directory info!');
        exit;
    }

    unset($files); //we don't need them
    natsort($dirs);

    if (!config_read()){
        show_error('Can not read configuration!');
        exit;
    }

    if (!config_set_option('\$allow_content_eval','$allow_content_eval = '.(($allow_page_eval==1)?'TRUE':'FALSE').";\n",'//##/PLUGIN_COMMON##')){
        show_error('Can not modify configuration!');
        exit;
    }


    $function_plugins='';
    $page_plugins='';
    config_del_options('\$page_plugins_options[^[]*\[[^[]*\]\[\'eval\'\]=');
    while (list ($key, $val) = each($dirs)){
        if ($val{0}!='.' && $val!='CVS'){
            if(file_exists($dir.'/'.$val.'/main.php')){
                include($dir.'/'.$val.'/main.php');
                if ($plugin_function && isset($plugins_function[$val]) && $plugins_function[$val]==1){
                    if ($function_plugins=='')
                        $function_plugins .= "'$val'";
                    else
                        $function_plugins .= ",'$val'";
                }
                if ($plugin_page){
                    if (isset($plugins_page[$val]) && $plugins_page[$val]==1){
                        if ($page_plugins=='')
                            $page_plugins .= "'$val'";
                        else
                            $page_plugins .= ",'$val'";
                    }
                    if (!config_set_option('\$page_plugins_options[^[]*\[\''.$val.'\'\]\[\'eval\'\]','$page_plugins_options[\''.$val.'\'][\'eval\'] = '.(($plugins_page_eval[$val]==1)?'TRUE':'FALSE').";\n",'//##/PLUGIN_OPTIONS##')){
                        show_error('Can not modify configuration!');
                        exit;
                    }
                }
            }
        }
    }

    if (!config_set_option('\$allowed_page_plugins','$allowed_page_plugins = array('.$page_plugins.");\n",'//##/PLUGIN_ALLOWED##')){
        show_error('Can not modify configuration!');
        exit;
    }
    if (!config_set_option('\$allowed_function_plugins','$allowed_function_plugins = array('.$function_plugins.");\n",'//##/PLUGIN_ALLOWED##')){
        show_error('Can not modify configuration!');
        exit;
    }

    if (!config_write()){
        show_error('Can not write configuration!');
        exit;
    }

    show_info_box('Plugins configuraton saved');
    include_once('./admin_footer.php');
    exit;
}
?>
<script language="JavaScript" type="text/javascript">
<!--
function show_plugin_info(val,plugin_name,plugin_version,plugin_release_date,plugin_author,plugin_email,plugin_web,plugin_credit,plugin_page,plugin_function){
    window.alert(
        "Name: "+plugin_name+"\n"+
        "Version: "+plugin_version+"; released: "+plugin_release_date+"\n"+
        "Author: "+plugin_author+"; his email: "+plugin_email+"\n"+
        "Website: "+plugin_web+"\n"+
        plugin_credit+
        "Capabilities: \n"+
        (plugin_page==1?" - page\n":"")+
        (plugin_function==1?" - function\n":"")
        );
    return true;
}
//-->
</script>

<form action="plugin.php" method="post" name="edit">
<input type="hidden" name="action" value="save" />
<?php
$files=array();
$dirs=array();

$dir = dirname(dirname($SCRIPT_FILENAME)).'/plugins';
if (!read_folder($dir,$dirs,$files)){
    show_error('Can not read directory info!');
    exit;
}

unset($files); //we don't need them
natsort($dirs);

$count=0;
echo '<table class="data"><tr><th>Directory</th><th>Name</th><th>Function</th><th>Page</th><th>Eval</th><th>Info</th><th>Status</th></tr>'."\n";
$even=1;
while (list ($key, $val) = each($dirs)){
    if ($val{0}!='.' && $val!='CVS'){
        if(file_exists($dir.'/'.$val.'/main.php')){
            // Load some defaults
            $plugin_name='Unknown';
            $plugin_version='Unknown';
            $plugin_release_date='Unknown';
            $plugin_author='Unknown';
            $plugin_email='Unknown';
            $plugin_web='Unknown';
            $plugin_page=FALSE;
            $plugin_function=FALSE;
            $need_install=FALSE;
            $plugin_credit='';
            include($dir.'/'.$val.'/main.php');
            $count++;

            make_row($even);
            $even = 1 - $even;
            make_cell($val,'');
            make_cell($plugin_name,'');
            make_cell('<input name="plugins_function['.$val.']" value="1" type="checkbox" '.($plugin_function?'class="check"':'class="check_disabled" disabled="disabled"').(in_array($val,$allowed_function_plugins)?' checked="checked"':'').'/>'.($plugin_function?'<a onclick="window.open(\'plugin_help.php?type=function&amp;name='.$val.'\',\'\',\'scrollbar=yes,menubar=no,location=no,status=no,toolbar=no,width='.$admin_help_width.',height='.$admin_help_height.'\');return false" href="plugin_help.php?type=function&amp;name='.$val.'" target="_blank">(help)</a>':''),'');
            make_cell('<input name="plugins_page['.$val.']" value="1" type="checkbox" '.($plugin_page?'class="check"':'class="check_disabled" disabled="disabled"').(in_array($val,$allowed_page_plugins)?' checked="checked"':'').'/>'.($plugin_page?'('.get_page_count($val).')':''),'');
            make_cell('<select name="plugins_page_eval['.$val.']" '.($plugin_page?'class="select"':'class="select_disabled" disabled="disabled"').'><option value="1"'.(isset($page_plugins_options[$val]['eval'])&&$page_plugins_options[$val]['eval']?' selected="selected"':'').'>Yes</option><option value="0"'.(!isset($page_plugins_options[$val]['eval'])||!$page_plugins_options[$val]['eval']?' selected="selected"':'').'>No</option></select>');
            make_cell('<input type="button" class="browse" onclick="'."show_plugin_info('$val','$plugin_name','$plugin_version','$plugin_release_date','$plugin_author','$plugin_email','$plugin_web',".(isset($plugin_credit)&&$plugin_credit!=''?"'Credits: $plugin_credit\\n'":"''").','.(int)$plugin_page.','.(int)$plugin_function.')" value="&nbsp;?&nbsp;" />');
            if ($need_install) {
                if (in_array($val,$installed_plugins)) {
                    make_cell('Installed (<a href="plugin_status.php?action=uninstall&amp;name='.$val.'">Uninstall</a>)');
                } else {
                    make_cell('NOT installed (<a href="plugin_status.php?action=install&amp;name='.$val.'">Install</a>)');
                }
            } else {
                make_cell('Ready (no installation required)');
            }
            echo "</tr>\n";
        }
    }
}
?>

<tr>
<td colspan="7">
    Listed plugins: <?php echo $count; ?><br />
    Allow anywhere evaling content of page:
    <select name="allow_page_eval" class="select">
    <option value="1"<?php if ($allow_content_eval) echo ' selected="selected"';?>>Yes</option>
    <option value="0"<?php if (!$allow_content_eval) echo ' selected="selected"';?>>No</option>
    </select><br />
    <table class="savereset">
    <tr>
        <td><input type="submit" value=" Save " class="save" /></td>
        <td><input type="reset" value=" Reset " class="reset" /></td>
    </tr>
    </table>
</td>
</tr>
</table>
</form>

<?php
require_once('./admin_footer.php');
?>
