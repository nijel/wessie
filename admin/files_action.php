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
$page_name='File management';
require_once('./download_header.php');
require_once('./file_functions.php');
$orig_pwd = getcwd();

if (!isset($fname) || !isset($action)){
    show_error_box('Not enough parameters!');
    require_once('./admin_footer.php');
    exit;
}

if (!ereg('^((do_)?(delete|move|copy|chmod))|(mkdir)$',$action)){
    show_error_box('Unknown action!');
    require_once('./admin_footer.php');
    exit;
}

$fname = opt_stripslashes($fname);

$root_dir = substr($SCRIPT_FILENAME,0,-strlen($SCRIPT_NAME));
$root_dir_len = strlen($root_dir);

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
    <?php sized_edit('filename','') ?><input type="button" class="browse" onclick="open_browse_window('<?php echo addslashes(htmlspecialchars(dirname($fname)));?>','dirs');" value="..." /><br />
    <input type="hidden" name="fname" value="<?php echo htmlspecialchars($fname); ?>" />
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

    $filename=otp_stripslashes($filename);

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
} elseif ($action == 'copy'){
?>
    <form action="files_action.php" method="post">
    Copy file <?php echo $fname;?> to:<br />
    <input type="hidden" name="action" value="do_copy" />
    <?php sized_edit('filename','') ?><input type="button" class="browse" onclick="open_browse_window('<?php echo addslashes(htmlspecialchars(dirname($fname)));?>','dirs');" value="..." /><br />
    <input type="hidden" name="fname" value="<?php echo htmlspecialchars($fname); ?>" />
    <input type="submit" value=" Go " class="go" />
    </form>

<?php
} elseif ($action == 'do_copy') {
    if (!isset($filename)){
        show_error_box('Not enough parameters!');
        chdir($orig_pwd);
        require_once('./admin_footer.php');
        exit;
    }

    $filename=opt_stripslashes($filename);

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
        if (!@copy($fname,$filename.'/'.basename($fname))){
            show_error_box('Copy failed! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }

        show_info_box('File copied to directory '.$filename,array('dir'=>$filename),'files.php');
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
        if (!@copy($fname,$filename)) {
            show_error_box('Copy failed! ('.$filename.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }

        show_info_box('File copied to '.$filename,dirname($filename)=='.'?array():array('dir'=>dirname($filename)),'files.php');
        chdir($orig_pwd);
        include_once('./admin_footer.php');
        exit;
    }
} elseif ((!$admin_fm_confirm_delete && $action == 'delete') || $action == 'do_delete'){
    if (@is_dir($fname)){
        if (!@rmdir($fname)) {
            show_error_box('Rmdir failed (maybe directory is not empty)! ('.$fname.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }

        show_info_box('Directory deleted',array('dir'=>dirname($fname)),'files.php');
        chdir($orig_pwd);
        include_once('./admin_footer.php');
        exit;
    } else {
        if (!@unlink($fname)) {
            show_error_box('Unlink failed! ('.$fname.')',array('dir'=>dirname($fname)),'files.php');
            chdir($orig_pwd);
            require_once('./admin_footer.php');
            exit;
        }

        show_info_box('File deleted',array('dir'=>dirname($fname)),'files.php');
        chdir($orig_pwd);
        include_once('./admin_footer.php');
        exit;
    }
} elseif ($action == 'delete'){
    if (@is_dir($fname)){
        echo 'Do you want to delete directory '.htmlspecialchars($fname).' (it must be empty)?';
    } else {
        echo 'Do you want to delete file '.htmlspecialchars($fname).'?';
    }
    ?>
    <table class="yesno">
    <tr>
        <td>
    <form action="files_action.php" method="post" class="delete">
    <input type="hidden" name="fname" value="<?php echo htmlspecialchars($fname); ?>" />
    <input type="hidden" name="action" value="do_delete" /><br />
    <input type="submit" value=" Yes " class="delete" />
    </form>
        </td>
        <td><?php make_return_button(' No ');?> </td>
    </tr>
    </table>
    <?php
} elseif ($action == 'mkdir'){
    if (!@chdir($fname)||!@is_dir($fname)){
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

    if (!mkdir($dir.'/'.$name, $admin_fm_mkdir_mode)) {
        show_error_box('Mkdir failed! ('.$dir.'/'.$name.')',array('dir'=>$dir),'files.php');
        chdir($orig_pwd);
        require_once('./admin_footer.php');
        exit;
    }

    show_info_box('Directory created',array('dir'=>$dir.'/'.$name),'files.php');
    chdir($orig_pwd);
    include_once('./admin_footer.php');
    exit;
} elseif ($action == 'do_chmod'){
    $perms=0;
    if (isset($owner_read)) $perms |= 0400;
    if (isset($owner_write)) $perms |= 0200;
    if (isset($owner_execute)) $perms |= 0100;
    if (isset($group_read)) $perms |= 040;
    if (isset($group_write)) $perms |= 020;
    if (isset($group_execute)) $perms |= 010;
    if (isset($any_read)) $perms |= 04;
    if (isset($any_write)) $perms |= 02;
    if (isset($any_execute)) $perms |= 01;
    if (isset($suid)) $perms |= 04000;
    if (isset($sgid)) $perms |= 02000;
    if (isset($sticky)) $perms |= 01000;

    if (!chmod($fname, $perms)) {
        show_error_box('Chmod failed! ('.$fname.')',array('dir'=>dirname($fname)),'files.php');
        chdir($orig_pwd);
        require_once('./admin_footer.php');
        exit;
    }

    show_info_box('Mode changed',array('dir'=>dirname($fname)),'files.php');
    chdir($orig_pwd);
    include_once('./admin_footer.php');
    exit;
} elseif ($action == 'chmod'){
    $perms = fileperms($fname);
    ?>
    <form action="files_action.php" method="post">
    Change mode of file <?php echo $fname;?>
    <input type="hidden" name="action" value="do_chmod" />
    <input type="hidden" name="fname" value="<?php echo htmlspecialchars($fname); ?>" />
    <p class="checks">
    Owner (<?php
    $arr = posix_getpwuid(fileowner($fname));
    echo $arr['name'];
    ?>):<br />
    <label class="checks"><input type="checkbox" name="owner_read" class="chmod"<? if(($perms & 0400)==0400) echo ' checked="checked"';?>>Read</label><br />
    <label class="checks"><input type="checkbox" name="owner_write" class="chmod"<? if(($perms & 0200)==0200) echo ' checked="checked"';?>>Write</label><br />
    <label class="checks"><input type="checkbox" name="owner_execute" class="chmod"<? if(($perms & 0100)==0100) echo ' checked="checked"';?>>Execute</label><br />
    <label class="checks"><input type="checkbox" name="suid" class="chmod"<? if(($perms & 04000)==04000) echo ' checked="checked"';?>>SUID</label>
    </p>
    <p class="checks">
    Group (<?php
    $arr = posix_getgrgid(filegroup($fname));
    echo $arr['name'];
    ?>):<br />
    <label class="checks"><input type="checkbox" name="group_read" class="chmod"<? if(($perms & 040)==040) echo ' checked="checked"';?>>Read</label><br />
    <label class="checks"><input type="checkbox" name="group_write" class="chmod"<? if(($perms & 020)==020) echo ' checked="checked"';?>>Write</label><br />
    <label class="checks"><input type="checkbox" name="group_execute" class="chmod"<? if(($perms & 010)==010) echo ' checked="checked"';?>>Execute</label><br />
    <label class="checks"><input type="checkbox" name="sgid" class="chmod"<? if(($perms & 02000)==02000) echo ' checked="checked"';?>>SGID</label>
    </p>
    <p class="checks">
    Anybody:<br />
    <label class="checks"><input type="checkbox" name="any_read" class="chmod"<? if(($perms & 04)==04) echo ' checked="checked"';?>>Read</label><br />
    <label class="checks"><input type="checkbox" name="any_write" class="chmod"<? if(($perms & 02)==02) echo ' checked="checked"';?>>Write</label><br />
    <label class="checks"><input type="checkbox" name="any_execute" class="chmod"<? if(($perms & 01)==01) echo ' checked="checked"';?>>Execute</label><br />
    <label class="checks"><input type="checkbox" name="sticky" class="chmod"<? if(($perms & 01000)==01000) echo ' checked="checked"';?>>Sticky</label>
    </p>
    <input type="submit" value=" Go " class="go" />
    </form>

<?php
} else {
    echo 'Action '.$action.' not yet implemented :-(';
}


chdir($orig_pwd);
require_once('./admin_footer.php');
?>
