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
$page_name='Plugins';
require_once('./admin_header.php');
require_once('./file_functions.php');
?>
<script language="JavaScript" type="text/javascript">
<!--
function show_plugin_info(val,plugin_name,plugin_version,plugin_release_date,plugin_author,plugin_email,plugin_web,plugin_page,plugin_function){
    window.alert(
        "Information about "+plugin_name+" plugin:\n"+
        "Version: "+plugin_version+"; released: "+plugin_release_date+"\n"+
        "Author: "+plugin_author+"; his email: "+plugin_email+"\n"+
        "Website: "+plugin_web+"\n"+
        "Capabilities: \n"+
        (plugin_page==1?"page\n":"")+
        (plugin_function==1?"function\n":"")
        );
    return true;
}
//-->
</script>

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
echo '<table class="data"><tr><th>Directory</th><th>Name</th><th>Enable function</th><th>Enable page</th><th>Enable page eval</th><th>Info</th></tr>'."\n";
$even=1;
while (list ($key, $val) = each($dirs)){
    if ($val!='..'){
        if(file_exists($dir.'/'.$val.'/main.php')){
            include($dir.'/'.$val.'/main.php');
            $count++;

            make_row($even);
            $even = 1 - $even;
            make_cell($val,'');
            make_cell($plugin_name,'');
            make_cell('<input name="function['.$val.']" type="checkbox" '.($plugin_function?'class="check"':'class="check_disabled" disabled="disabled"').'>','');
            make_cell('<input name="page['.$val.']" type="checkbox" '.($plugin_page?'class="check"':'class="check_disabled" disabled="disabled"').'>','');
            make_cell('<select name="page_eval['.$val.']" '.($plugin_page?'class="select"':'class="select_disabled" disabled="disabled"').'><option value="1">Yes</option><option value="0">No</option></select>');
            make_cell('<input type="button" class="browse" onclick="'."show_plugin_info('$val','$plugin_name','$plugin_version','$plugin_release_date','$plugin_author','$plugin_email','$plugin_web',".(int)$plugin_page.','.(int)$plugin_function.')"'.'" value="?" />','');
        }
    }
}
echo "</table>\n";
echo 'Listed plugins: '.$count;

require_once('./admin_footer.php');
?>
