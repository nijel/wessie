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

if (isset($search) && trim($search) == '') unset($search);

$root_dir = substr($SCRIPT_FILENAME,0,-strlen($SCRIPT_NAME));
$root_dir_len = strlen($root_dir);

if (!isset($dir)){
    $dir = $root_dir;
}else{
    $dir = stripslashes($dir);
    if (!@chdir($dir)||!@is_dir($dir)){
        echo '<div class="error">Error: Selected directory ("'.$dir.'") not accessible!</div>';
        $dir = $root_dir;
    }else{
        $dir = getcwd();
    }
}

if ($admin_fm_restrict && (strlen($dir) < $root_dir_len || strpos($dir,$root_dir)  != 0)) {
    echo '<div class="error">Error: Directory restriction does not allow you to work in selected directory ("'.$dir.'")!</div>';
    $dir = $root_dir;
}

?>

<table class="filter">
  <tr>
    <td class="filtertext">
      Search for file:
    </td>
    <td class="filtercontent">
      <form method="get" action="files.php" class="filter">
        <label>Filename:
        <input type="text" name="search" <?php if(isset($search)){ echo 'value="'.$search.'"'; }?> class="text"/></label>
        &nbsp;<label><input type="checkbox" name="regexp" <?php if(isset($regexp)){ echo "checked=\"checked\""; }?> class="check"/> regular expression</label>
        &nbsp;<label><input type="checkbox" name="case" <?php if(isset($case)){ echo "checked=\"checked\""; }?> class="check"/> case sensitive</label>
        <br>search in
        <label><input type="radio" name="where" value="1" class="radio" <?php if ((!isset($where))||$where==1) echo "checked=\"checked\"";?>/> subfolders of current directory (<?php echo $dir; ?>)</label>
        <label><input type="radio" name="where" value="2" class="radio" <?php if (isset($where)&&$where==2) echo "checked=\"checked\"";?>/> web tree</label>
        &nbsp;<input type="submit" value=" Go " class="go" />
        <input type="hidden" name="dir" value="<?php echo $dir; ?>" />
      </form>
    </td>
  </tr>
</table><br />

<?php

echo 'Quickjump: <a href="files.php?'.(isset($case)?'case=&amp;':'').(isset($regexp)?'regexp=&amp;':'').'dir='.urlencode($root_dir).'">web tree root</a>';
reset($admin_fm_quickjump);
while (list ($key, $val) = each ($admin_fm_quickjump)){
    if ($val[0]=='/') $qj_dir=$val;
    else $qj_dir=$root_dir.'/'.$val;
    echo '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="files.php?'.(isset($case)?'case=&amp;':'').(isset($regexp)?'regexp=&amp;':'').'search=&amp;dir='.urlencode($qj_dir).'">'.$val.'</a>';
}
echo "<br/>\n";

if (strlen($dir) < $root_dir_len){
    $webdir = '<b>out of web tree!</b>';
} else {
    $webdir = substr($dir,$root_dir_len);
    if ($webdir == '') $webdir = '/';
}

if (isset($search)) {
    $dirs = array();
    if (!isset($dir)||!isset($where)||$where==2) $dir=$root_dir;
    $files = find_file($search,$dir,isset($regexp),isset($case));
} else {
    $files = array();
    $dirs = array();

    if (!read_folder($dir,$dirs,$files)){
        show_error('Can not read directory info!');
        exit;
    }
}

echo 'Current directory: '.$webdir.' (real path: '.$dir.')<br/>';

natsort($files);
natsort($dirs);
$list=add_file_info($dir,$dirs);
join_array($list,add_file_info($dir,$files));

echo '<table class="data"><tr><th>Filename</th>';
if($admin_fm_show_size) echo '<th>Size</th>';
if($admin_fm_show_type) echo '<th>Type</th>';
if($admin_fm_show_mtime) echo '<th>MTime</th>';
if($admin_fm_show_ctime) echo '<th>CTime</th>';
if($admin_fm_show_atime) echo '<th>ATime</th>';
if($admin_fm_show_allowed) echo '<th>Allowed</th>';
if($admin_fm_show_rights) echo '<th>Rights</th>';
if($admin_fm_show_owner) echo '<th>Owner</th>';
if($admin_fm_show_group) echo '<th>Group</th>';
echo "<th>Actions</th></tr>\n";

$even=1;
$counter=0;
while (list ($key, $val) = each($list)){
    $even = 1 - $even;
    if ($val['is_dir']){
        if (@chdir($dir.'/'.$val['filename'])){
            if (!$admin_fm_restrict || strncmp($root_dir,getcwd(),$root_dir_len)==0){
                make_row($even);
                $filename='<a href="files.php?'.(isset($case)?'case=&amp;':'').(isset($regexp)?'regexp=&amp;':'').'dir='.urlencode(getcwd()).'">'.($val['filename']=='..'?'.. [one level up]':$val['filename']).'</a>';
                $size='DIR';
                if ($val['filename'] == '..' || $webdir{0} != '/') $download_path = '';
                elseif (strncmp($root_dir,getcwd(),$root_dir_len)==0) $download_path = $webdir.$val['filename'];
                else $download_path = '';
            }else{
                make_row_js($even,"window.alert('This directory is outside web tree!');");
                $filename='<a class="disabled">'.($val['filename']=='..'?'.. [one level up]':$val['filename']).'</a>';
                $size='<span class="error">DIR</span>';
                $download_path = '';
            }
            $val['x']=TRUE;
        }else{
            make_row_js($even,"window.alert('You do not have permission to enter this directory!');");
            $filename='<a class="disabled">'.($val['filename']=='..'?'.. [one level up]':$val['filename']).'</a>';
            $size='<span class="error">DIR</span>';
            $download_path = '';
            $val['x']=FALSE;
        }
    }else{
        $filename=$val['filename'];
        make_row($even);
        $size=$val['hsize'];
        if ($webdir{0} == '/') $download_path = $webdir.($webdir{strlen($webdir)-1}=='/'?'':'/').$filename;
        else $download_path = '';
    }
    make_cell((isset($search)?'.':'').$filename);

    if($admin_fm_show_size) make_cell($size,'','size');
    if($admin_fm_show_type) make_cell($val['type']);
    if($admin_fm_show_mtime) make_cell(strftime('%c',$val['ctime']),'','date');
    if($admin_fm_show_ctime) make_cell(strftime('%c',$val['mtime']),'','date');
    if($admin_fm_show_atime) make_cell(strftime('%c',$val['atime']),'','date');
    if($admin_fm_show_allowed) make_cell(($val['r']?'r':'-').($val['w']?'w':'-').($val['x']?'x':'-'),'','perms');
    if($admin_fm_show_rights) make_cell(perms2str($val['perms']),'','perms');
    if($admin_fm_show_owner) make_cell($val['owner']);
    if($admin_fm_show_group) make_cell($val['group']);

    make_cell(($download_path==''?'<a class="disabled">Download</a>':'<a href="'.htmlentities($download_path).'">Download</a>').
/*        '&nbsp;|&nbsp;'.($val['filename']=='..'?'<a class="disabled">rm</a>':'<a href="files_action.php?action=delete&amp;dir='.urlencode($dir).'&amp;name='.urlencode($val['filename']).'">rm</a>').
        '&nbsp;|&nbsp;'.($val['filename']=='..'?'<a class="disabled">mv</a>':'<a href="files_action.php?action=move&amp;dir='.urlencode($dir).'&amp;name='.urlencode($val['filename']).'">mv</a>').
        '&nbsp;|&nbsp;'.($val['filename']=='..'?'<a class="disabled">cp</a>':'<a href="files_action.php?action=copy&amp;dir='.urlencode($dir).'&amp;name='.urlencode($val['filename']).'">cp</a>').*/
        '&nbsp;|&nbsp;'.($val['filename']=='..'?'<a class="disabled">Delete</a>':'<a href="files_action.php?action=delete&amp;fname='.urlencode($dir.'/'.$val['filename']).'">Delete</a>').
        '&nbsp;|&nbsp;'.($val['filename']=='..'?'<a class="disabled">Move</a>':'<a href="files_action.php?action=move&amp;fname='.urlencode($dir.'/'.$val['filename']).'">Move</a>').
        '&nbsp;|&nbsp;'.($val['filename']=='..'||$val['is_dir']?'<a class="disabled">Copy</a>':'<a href="files_action.php?action=copy&amp;fname='.urlencode($dir.'/'.$val['filename']).'">Copy</a>').
        '&nbsp;|&nbsp;'.($val['filename']=='..'||!$val['is_my']?'<a class="disabled">Chmod</a>':'<a href="files_action.php?action=chmod&amp;fname='.urlencode($dir.'/'.$val['filename']).'">Chmod</a>').
        //
        '');

    echo "</tr>\n";
    $counter++;
}

echo "</table>\n";
echo 'Listed files: '.$counter;

?>
<?php

if (!isset($search)) {
    if (is_writeable($dir)){
        ?>
        <table class="two_col">
        <tr>
            <td>
                <form action="files_upload.php" method="post" enctype="multipart/form-data">
                Upload file:
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $admin_fm_maxsize; ?>" />
                <input type="file" name="file" class="file" />
                <input type="hidden" name="dir" value="<?php echo $dir; ?>" />
                <input type="submit" value=" Go " class="go" />
                </form>
            </td>
            <td>
                <form action="files_action.php" method="get">
                Create directory:
                <input type="name" name="name" class="file" />
                <input type="hidden" name="fname" value="<?php echo $dir; ?>" />
                <input type="hidden" name="action" value="mkdir" />
                <input type="submit" value=" Go " class="go" />
                </form>
            </td>
        </tr>
        </table>
        <?php
    } else {
        echo '<div class="error">Upload and mkdir not possible, web server can not write to current directory!</div>';
    }
}
chdir($orig_pwd);
require_once('./admin_footer.php');
?>
