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

$page_name='Download group:Delete';
require_once('./download_header.php');

function delete_download_group(){
    global $id,$db_prepend,$table_download_group;

    if (!mysql_query('DELETE FROM '.$db_prepend.$table_download_group.' where id='.$id.' limit 1')){
        show_error("Can't delete download group! (".mysql_error().')');
        exit;
    }
    show_info_box('Download group deleted',array(),'download_group.php');
    include_once('./admin_footer.php');
    exit;
}

if (isset($action) && ($action=='delete') && isset($id)){
    if (!isset($members)){
        show_error_box('You have to choose what will happen to other items that belong to this download group!');
        include_once('./admin_footer.php');
        exit();
    }
    if ($members=='delete'){
        delete_donwloads_download_group($id,FALSE);
    } elseif ($members=='deletewithfiles'){
        delete_donwloads_download_group($id,TRUE);
    }elseif ($members=='move'){
        change_downloads_download_group($id,$group);
    }
    delete_download_group();
}elseif (isset($id)){
//    if ($admin_confirm_delete){
        if (!$id_result=mysql_query(
        'SELECT id, name, count '.
        ' from '.$db_prepend.$table_download_group.
        ' where id='.$id))
            show_error("Can't get download group info! (".mysql_error().')');

        $download_group=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
//    }else{
//        delete_download_group();
//    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

?>
Do you want to delete following download group?<br />
<table class="yesno">
  <tr>
    <td>
<form action="download_group_delete.php" method="post" class="delete">
<input type="hidden" name="id" value="<?php echo $download_group['id']; ?>" />
<input type="hidden" name="action" value="delete" />
<p class="message">
If there are any downloads in this download group, they should be:
</p>
<p class="radios">
<label class="radios"><input type="radio" name="members" value="delete" class="radio" checked="checked" /> Deleted <span class="warning">(this does NOT delete any files)</span></label><br />
<label class="radios"><input type="radio" name="members" value="deletewithfiles" class="radio" checked="checked" /> Deleted and delete also files <span class="warning">(this deletes ALL local files in this category)</span></label><br />
<label class="radios"><input type="radio" name="members" value="move" class="radio" /> Moved to download group: <?php download_group_edit(-1,'group',FALSE,'select',array($download_group['id'])); ?></label><br />
<label class="radios"><input type="radio" name="members" value="keep" class="radio" /> Keept in current download group <span  class="warning">(This is NOT recommended)</span></label><br />
</p>
<input type="submit" value=" Yes " class="delete" />
</form>
    </td>
    <td><?php make_return_button(' No ');?> </td>
  </tr>
</table>

<table class="item">
<tr><th>
Download group ID:
</th><td>
<?php echo $download_group['id'];?>
</td></tr>
<tr><th>
Name:
</th><td>
<?php echo htmlspecialchars($download_group['name']) ?>
</td></tr>
<tr><th>
Count:
</th><td>
<?php echo $download_group['count'] ?>
</td></tr>
</table>

<?php
require_once('./admin_footer.php');
?>