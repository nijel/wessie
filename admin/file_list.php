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

Header('Pragma: no-cache');
Header("Expires: " . GMDate("D, d M Y H:i:s") . " GMT");
error_reporting (E_ALL);
require_once('./auth.php');
require_once('./functions.php');
Header('Content-Type: text/html; charset='.$admin_charset);
$onunload='window.opener.delwin();';
if ($limit=='dirs') {
    show_html_head('Select directory');
} else {
    show_html_head('Select file');
}

if ($limit=='limit' || ($limit!='dirs' && $admin_file_restrict)  || ($limit=='dirs' && $admin_fm_restrict)) $restrict=TRUE;
else $restrict=FALSE;

if (!isset($limit)) $limit='limit';
require_once('./file_functions.php');

$server_root_dir = substr($SCRIPT_FILENAME,0,-strlen($SCRIPT_NAME));

if ($restrict){
    $root_dir = $server_root_dir;
    $root_dir_len = strlen($root_dir);
} else {
    $root_dir = '';
    $root_dir_len = 0;
}

if (isset($dir)) $dir = stripslashes($dir);
if (!isset($dir)||$dir==''||!@is_dir($dir)){
    $dir = $server_root_dir;
}elseif (!@chdir($dir)){
    $dir = $server_root_dir;
}elseif ($restrict && (strlen($dir) < $root_dir_len || strpos($dir,$root_dir) != 0)) {
    echo '<div class="error">Error: Directory restriction does not allow you to work in selected directory ("'.$dir.'")!</div>';
    $dir = $server_root_dir;
}else{
    $dir = getcwd();
}

if ($limit=='dirs') {
    echo '<p class="info">Select directory ('.$dir."):</p>\n";
} else {
    echo '<p class="info">Select file ('.$dir."):</p>\n";
}

$files=array();
$dirs=array();

if (!read_folder($dir,$dirs,$files)){
    show_error('Can not read directory info "'.$dir.'"!');
    exit;
}
if ($limit=='dirs') {
    $files=array();
    echo "<a href=\"javascript:gE('filename',window.opener).value='".addslashes(htmlentities($dir))."/';window.close();\">Select current directory</a>";
}
natsort($files);
natsort($dirs);
$list=add_file_info($dir,$dirs);
join_array($list,add_file_info($dir,$files));

echo '<table class="filelist"><tr><th>Filename</th><th>Size</th></tr>'."\n";
$even=1;
while (list ($key, $val) = each($list)){
    $even = 1 - $even;
    if ($val['is_dir']){
        if (@chdir($dir.'/'.$val['filename'])){
            if (!$restrict || strncmp($root_dir,getcwd(),$root_dir_len)==0){
                make_row_js($even,"window.location.replace('file_list.php?limit=$limit&dir=".urlencode(getcwd())."');",'even_hand','odd_hand');
                $filename='<a href="file_list.php?limit='.$limit.'&amp;dir='.urlencode(getcwd()).'">'.$val['filename'].'</a>';
                $size='DIR';
            }else{
                make_row_js($even,"window.alert('This directory is outside web tree!');");
                $filename=$val['filename'];
                $size='<span class="error">DIR</span>';
            }
        }else{
            make_row_js($even,"window.alert('You do not have permission to enter this directory!');");
            $filename=$val['filename'];
            $size='<span class="error">DIR</span>';
        }
    }else{
        $filename=$val['filename'];
        make_row_js($even,"gE('filename',window.opener).value='".($restrict?substr($dir.'/'.$filename,$root_dir_len):$dir.'/'.$filename)."';if(window.opener.check_remote) window.opener.check_remote();window.close();");
        $size=$val['hsize'];
    }
    echo '<td>'.$filename.'</td><td class="size">'.$size."</td></tr>\n";
}

?>
</table>
</body>
</html>
