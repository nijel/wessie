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

if (!ereg('^(do_)?(delete|move|copy|chmod)$',$action)){
    show_error_box('Unknown action!');
    require_once('./admin_footer.php');
    exit;
}

$fname = stripslashes($fname);

$root_dir = substr($SCRIPT_FILENAME,0,-strlen($SCRIPT_NAME));
$root_dir_len = strlen($root_dir);

if(isset($dname)){
    $dname=stripslashes($dname);
    $ddir = dirname($dname);

    if (!@chdir($ddir)||!@is_dir($ddir)){
        show_error_box('Selected destination directory not acessible!');
        chdir($orig_pwd);
        require_once('./admin_footer.php');
        exit;
    }else{
        $ddir = getcwd();
    }

    if ($admin_fm_restrict && (strlen($ddir) < $root_dir_len || strpos($ddir,$root_dir) != 0)) {
        show_error_box('Directory restriction does not allow you to work in selected destination directory! ('.$ddir.')');
        chdir($orig_pwd);
        require_once('./admin_footer.php');
        exit;
    }
}

$dir = dirname($fname);

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

if (!file_exists(basename($fname))){
    show_error_box('File not found!');
    echo basename($fname);
    chdir($orig_pwd);
    require_once('./admin_footer.php');
    exit;
}

if ($action == 'move'){
?>
    <form action="files_action.php" method="post">
    Move file <?php echo $fname;?> to:<br />
    <input type="hidden" name="action" value="do_move" />
    <?php sized_edit('filename','') ?><input type="button" class="browse" onclick="open_browse_window('<?php echo addslashes(htmlentities(dirname($fname)));?>','dirs');" value="..." /><br />
    <input type="hidden" name="fname" value="<?php echo htmlentities($fname); ?>" />
    <input type="submit" value=" Go " class="go" />
    </form>

<?php
} elseif ($action == 'do_move') {
    if (!isset($filename)){
        show_error_box('Not enough parameters!');
        chdir($orig_pwd);
        require_once('./admin_footer.php');
        exit;
    }

    $filename=stripslashes($filename);

    chdir($dir);
    if (@is_dir($filename)) {
        if (!@chdir($filename)) {
            show_error_box('Destination directory not accessible! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }
        $filename = getcwd();
        if ($admin_fm_restrict && (strlen($filename) < $root_dir_len || strpos($filename,$root_dir) != 0)) {
            show_error_box('Directory restriction does not allow you to work in selected destination directory! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }
        chdir($dir);
        if (!@rename($fname,$filename.'/'.basename($fname))){
            show_error_box('Rename failed! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }

        show_info_box('File moved to directory '.$filename,array('dir'=>$filename),'files.php');
        chdir($orig_pwd);
        include_once('./admin_footer.php');
        exit;

    } else {
        if ($filename{strlen($filename)-1} == '/') {
            show_error_box('Destination ends with / but is not a directory! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }
        if (!@is_dir(dirname($filename))) {
            show_error_box('Destination directory must exist! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }
        if (!@chdir(dirname($filename))) {
            show_error_box('Destination directory not accessible! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }
        $dirname = getcwd();
        if ($admin_fm_restrict && (strlen($dirname) < $root_dir_len || strpos($dirname,$root_dir) != 0)) {
            show_error_box('Directory restriction does not allow you to work in selected destination directory! ('.$dirname.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }
        chdir($dir);
        if (!@rename($fname,$filename)) {
            show_error_box('Rename failed! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }

        show_info_box('File renamed to '.$filename,dirname($filename)=='.'?array():array('dir'=>dirname($filename)),'files.php');
        chdir($orig_pwd);
        include_once('./admin_footer.php');
        exit;
    }
}

chdir($orig_pwd);
require_once('./admin_footer.php');
?>
