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

Header('Pragma: no-cache');
Header("Expires: " . GMDate("D, d M Y H:i:s") . " GMT");
error_reporting (E_ALL);
require_once('./auth.php');
require_once('./functions.php');
Header('Content-Type: text/html; charset='.$admin_charset);
show_html_head('Select file');
?>

<body onunload="window.opener.delwin();">
<p class="info">Select file:</p>

<?php
require_once('./file_functions.php');

$root_dir = substr($SCRIPT_FILENAME,0,-strlen($SCRIPT_NAME));
$root_dir_len = strlen($root_dir);

if (!isset($dir)||!@is_dir($dir)){
    $dir = $root_dir;
}elseif (!@chdir($dir)){
    $dir = $root_dir;
}else{
    $dir = getcwd();
}


$files=array();
$dirs=array();

if (!read_folder($dir,$dirs,$files)){
    show_error('Can not read directory info!');
    exit;
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
            if (strncmp($root_dir,getcwd(),$root_dir_len)==0){
                make_row_js($even,"window.location.replace('file_list.php?dir=".urlencode(getcwd())."');",'even_hand','odd_hand');
                $filename='<a href="file_list.php?dir='.urlencode(getcwd()).'">'.$val['filename'].'</a>';
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
        make_row_js($even,"gE('filename',window.opener).value='".substr($dir.'/'.$filename,$root_dir_len)."';window.opener.check_remote();window.close();");
        $size=$val['hsize'];
    }
    echo '<td>'.$filename.'</td><td class="size">'.$size."</td></tr>\n";
}

?>
</table>
</body>
</html>
