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
$page_name='Upload';
require_once('./download_header.php');
require_once('./file_functions.php');
$orig_pwd = getcwd();

$root_dir = substr($SCRIPT_FILENAME,0,-strlen($SCRIPT_NAME));
$root_dir_len = strlen($root_dir);

if (!isset($dir)||!isset($file)){
    show_error_box('Error: Not enough parameters!<br/>This may be caused by attempting to upload too large file');
    chdir($orig_pwd);
    include_once('./admin_footer.php');
    exit();
}elseif (!@is_dir($dir)||!@chdir($dir)){
    show_error_box('Error: Selected directory ("'.$dir.'") not accessible!');
    chdir($orig_pwd);
    include_once('./admin_footer.php');
    exit();
}else{
    $dir = getcwd();
}

if ($admin_fm_restrict && (strlen($dir) < $root_dir_len || strpos($dir,$root_dir) === false)) {
    show_error_box('Error: Directory restriction does not allow you to work in selected directory ("'.$dir.'")!');
    chdir($orig_pwd);
    include_once('./admin_footer.php');
    exit();
}

if (strlen($dir) < $root_dir_len){
    $webdir = '<span class="error">out of web tree!</span>';
} else {
    $webdir = substr($dir,$root_dir_len);
    if ($webdir == '') $webdir = '/';
}

if (move_uploaded_file ($file, $dir.'/'.$file_name)){
    show_info_box('File uploaded into directory '.$dir.' (web path: '.$webdir.')<br/>Name = '.$file_name.'<br/>Size = '.$file_size.'<br/>Type = '.$file_type,array('dir'=>$dir),'files.php');
    chdir($orig_pwd);
    include_once('./admin_footer.php');
    exit;
}else{
    show_error_box("File couldn't be uploaded!");
    chdir($orig_pwd);
    include_once('./admin_footer.php');
    exit();
}

?>

<?php
chdir($orig_pwd);
require_once('./admin_footer.php');
?>
