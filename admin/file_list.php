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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                  "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $admin_charset?>" />
    <title>Browse list</title>
    <meta name="Author" content="<?php echo $wessie_author?>" />
    <meta name="Generator" content="<?php echo $wessie_version.', Copyright (C) 2001 '.$wessie_author?>" />
    <link rel="home" href="<?php echo $site_home?>" />
    <link rel="copyright" href="mailto:<?php echo $wessie_author?>" />
    <link rel="StyleSheet" href="./admin.css" type="text/css" media="screen" />
    <script language="JavaScript" type="text/javascript" src="./admin.js"></script>
</head>

<body onunload="window.opener.delwin();">
<p class="info">Select file:</p>

<?php
require_once('./file_functions.php');

$root_dir=dirname(dirname($SCRIPT_FILENAME));
$root_dir_len=strlen($root_dir);

if (!isset($dir)||!@is_dir($dir)){
    $dir = dirname(dirname($SCRIPT_FILENAME));
}elseif (!@chdir($dir)){
    $dir = dirname(dirname($SCRIPT_FILENAME));
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
                make_row_js($even,"window.location.replace('browse_list.php?dir=".urlencode(getcwd())."');",'even_hand','odd_hand');
                $filename='<a href="browse_list.php?dir='.urlencode(getcwd()).'">'.$val['filename'].'</a>';
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
    echo $filename.'</td><td class="size">'.$size."</td></tr>\n";
}

?>
</table>
</body>
</html>
