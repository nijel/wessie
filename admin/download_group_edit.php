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

$page_name='Download group:Edit';
require_once('./download_header.php');

if (isset($action) && ($action=='save')){
    if (!mysql_query('UPDATE '.$db_prepend.$table_download_group.' set name="'.opt_addslashes($name).'" WHERE id='.$id)){
        show_error("Can't save download group info! (".mysql_error().')');
        exit;
    }
    show_info_box('Download group saved',array('id'=>$id));
    include_once('./admin_footer.php');
    exit;
}elseif(isset($action) && ($action=='create_new')){
    if (!mysql_query('INSERT '.$db_prepend.$table_download_group.' set name="'.opt_addslashes($name).'"'.(($id==-1)?'':(', id='.$id)))){
        show_error("Can't save download group info! (".mysql_error().')');
        exit;
    }
    if (!$id_result=mysql_query('SELECT id FROM '.$db_prepend.$table_download_group.' where name="'.opt_addslashes($name).'"'.(($id==-1)?'':(' AND id='.$id)))){
        show_error("Can't get download group info! (".mysql_error().')');
        exit;
    }
    $item=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    show_info_box('Download group created',array('id'=>$item['id']));
    include_once('./admin_footer.php');
    exit;
}elseif (isset($action) && ($action=='new')){
    $action='create_new';
    if (isset($id)){
        if (!is_download_group_free($id)){
            show_error_box('This download group allready exists!');
            include_once('./admin_footer.php');
            exit();
        }
    } else {
        $id=-1;
    }
    $download=array('id'=>$id,'name'=>'','count'=>0);

}elseif (isset($id)){
    $action='save';
    if (!$id_result=mysql_query(
    'SELECT id, name, count '.
    ' from '.$db_prepend.$table_download_group.
    ' where id='.$id))
        show_error("Can't select download group! (".mysql_error().')');
    $download=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($download['id'])){
        show_error_box("This download group doesn't  exist!");
        exit();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

?>

<form action="download_group_edit.php" method="post" name="edit">
<input type="hidden" name="action" value="<?php echo $action?>" />
<table class="item">
<tr><th>
Download group ID:
</th><td>
<input type="hidden" name="id" value="<?php echo $download['id']; ?>" />
<?php echo ($download['id']!=-1?$download['id']:'Download group not created yet'); ?>
</td></tr>
<tr><th>
Name:
</th><td>
<?php sized_edit('name', $download['name']) ?>
</td></tr>
<tr><th>
</th><td>
<table class="savereset">
  <tr>
    <td><input type="submit" value=" Save " class="save" /></td>
    <td><input type="reset" value=" Reset " class="reset" /></td>
  </tr>
</table>
</td></tr>
</table>

</form>
<?php
require_once('./admin_footer.php');
?>