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

$page_name='Download:Delete';
require_once('./download_header.php');

function delete_download(){
    global $id,$db_prepend,$table_download,$delete_file;

    if (isset($delete_file) && ($delete_file==1)){
        if (!$id_result=mysql_query(
        'SELECT id, filename, remote, grp, count '.
        ' from '.$db_prepend.$table_download.
        ' where id='.$id))
            show_error("Can't select download! (".mysql_error().')');
        $download=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
    }

    if (!mysql_query('DELETE FROM '.$db_prepend.$table_download.' where id='.$id.' limit 1')){
        show_error("Can't delete download! (".mysql_error().')');
        exit;
    }

    if (isset($delete_file) && ($delete_file==1)){
        echo '<p class="info">Attempting to delete file: '.$download['filename'].'</p>';
        if (!file_exists('../'.$download['filename'])){
            echo '<p class="info">File doesn\'t exist, so it wasn\'t deleted</p>';
        }elseif (!unlink('../'.$download['filename'])){
            echo '<p class="info">File couldn\'t be deleted</p>';
        }else{
            echo '<p class="info">File deleted</p>';
        }
    }

    show_info_box('Download deleted',array(),'download_item.php');
    include_once('./admin_footer.php');
    exit;
}

if (isset($action) && ($action=='delete') && isset($id)){
    delete_download();
}elseif (isset($id)){
    if ($admin_confirm_delete){
        if (!$id_result=mysql_query(
        'SELECT id, filename, remote, grp, count '.
        ' from '.$db_prepend.$table_download.
        ' where id='.$id))
            show_error("Can't select download! (".mysql_error().')');
        $download=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
        if (!isset($download['id'])){
            show_error_box("This download doesn't  exist!");
            exit();
        }
    }else{
        delete_download();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

?>
Do you want to delete following download?<br />
<table class="yesno">
  <tr>
    <td>
<form action="download_item_delete.php" method="post" class="delete">
<input type="hidden" name="id" value="<?php echo $download['id']; ?>" />
<input type="hidden" name="action" value="delete" />
<?php if ($download['remote']==0){ ?>
<p class="radios">
<label class="radios"><input type="checkbox" name="delete_file" value="1" class="check" checked="checked" />Also delete file on server</label><br />
</p>
<?php } ?>
<input type="submit" value=" Yes " class="delete" />
</form>
    </td>
    <td><?php make_return_button(' No ');?> </td>
  </tr>
</table>

<table class="item">
<tr><th>
Download ID:
</th><td>
<?php echo $download['id']; ?>
</td></tr>
<tr><th>
Filename:
</th><td>
<?php echo htmlspecialchars($download['filename']) ?>
</td></tr>
<tr><th>
Remote:
</th><td>
<?php echo $download['remote']==1?'yes':'no'; ?>
</td></tr>
<tr><th>
Group:
</th><td>
<?php echo get_download_group_name($download['grp']); ?>
</td></tr>
</table>

<?php
require_once('./admin_footer.php');
?>