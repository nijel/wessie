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
$page_name='File management';
require_once('./download_header.php');
require_once('./file_functions.php');
$orig_pwd = getcwd();

if (!isset($fname) || !isset($action)){
    show_error_box('Not enough parameters!');
    require_once('./admin_footer.php');
    exit;
}

if (!ereg('^(delete|move|copy|chmod)$',$action)){
    show_error_box('Unknown action!');
    require_once('./admin_footer.php');
    exit;
}

$dir = dirname($fname);

$root_dir = substr($SCRIPT_FILENAME,0,-strlen($SCRIPT_NAME));
$root_dir_len = strlen($root_dir);

if (!@chdir($dir)||!@is_dir($dir)){
    show_error_box('Selected directory not acessible!');
    chdir($orig_pwd);
    require_once('./admin_footer.php');
    exit;
}else{
    $dir = getcwd();
}

if ($admin_fm_restrict && (strlen($dir) < $root_dir_len || strpos($dir,$root_dir) != 0)) {
    show_error_box('Directory restriction does not allow you to work in selected directory! ('.$dir.')');
    chdir($orig_pwd);
    require_once('./admin_footer.php');
    exit;
}


chdir($orig_pwd);
require_once('./admin_footer.php');
?>
