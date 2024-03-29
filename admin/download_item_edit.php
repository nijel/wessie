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

$page_name='Download:Edit';
require_once('./download_header.php');
?>
<script language="JavaScript" type="text/javascript">
<!--
function check_remote(){
    if (gE('filename',window).value.indexOf(':/')==-1){
        gE('remote',window).checked=0;
    }else{
        gE('remote',window).checked=1;
    }
    return true;
}
//-->
</script>

<?php
if (isset($action) && ($action=='save')){
    if (!mysql_query('UPDATE '.$db_prepend.$table_download.' set filename="'.opt_addslashes($filename).'", remote='.(isset($remote)?$remote:'0').', grp='.$grp.' WHERE id='.$id)){
        show_error("Can't save download info! (".mysql_error().')');
        exit;
    }
//    show_info_box('Download saved',array('id'=>$id));
    show_info_box('Download saved',array(),'download_item.php');
    include_once('./admin_footer.php');
    exit;
}elseif(isset($action) && ($action=='create_new')){
    if (!mysql_query('INSERT '.$db_prepend.$table_download.' set filename="'.opt_addslashes($filename).'"'.(($id==-1)?'':(', id='.$id)).', remote='.(isset($remote)?$remote:'0').', grp='.$grp)){
        show_error("Can't save download info! (".mysql_error().')');
        exit;
    }
    if (!$id_result=mysql_query('SELECT id FROM '.$db_prepend.$table_download.' where filename="'.opt_addslashes($filename).'"'.(($id==-1)?'':(' AND id='.$id)).' AND remote='.(isset($remote)?$remote:'0').' AND  grp='.$grp)){
        show_error("Can't get download info! (".mysql_error().')');
        exit;
    }
    $item=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
//    show_info_box('Download created',array('id'=>$item['id']));
    show_info_box('Download created',array(),'download_item.php');
    include_once('./admin_footer.php');
    exit;
}elseif (isset($action) && ($action=='new')){
    $action='create_new';
    if (isset($id)){
        if (!is_download_free($id)){
            show_error_box('This download allready exists!');
            include_once('./admin_footer.php');
            exit();
        }
    } else {
        $id=-1;
    }
    $download=array('id'=>$id,'filename'=>'','remote'=>0,'grp'=>-1,'count'=>0);

}elseif (isset($id)){
    $action='save';
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
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

?>

<form action="download_item_edit.php" method="post" name="edit">
<input type="hidden" name="action" value="<?php echo $action?>" />
<table class="item">
<tr><th>
Download ID:
</th><td>
<input type="hidden" name="id" value="<?php echo $download['id']; ?>" />
<?php echo ($download['id']!=-1?$download['id']:'Download not created yet'); ?>
</td></tr>
<tr><th>
Filename:
</th><td>
<?php sized_edit('filename', $download['filename'], 'check_remote();') ?><input type="button" class="browse" onclick="open_browse_window('<?php echo addslashes(htmlspecialchars(dirname(dirname($_SERVER['SCRIPT_FILENAME'])))).(($download['filename']!='')?dirname($download['filename']):dirname(dirname($_SERVER['SCRIPT_FILENAME'])));?>');" value="..." />

</td></tr>
<tr><th>
Remote:
</th><td>
<?php echo '<input type="checkbox" id="remote" name="remote" value="1"  class="check"'.(($download['remote']==1)?'checked="checked"':'').' />'; ?>
<span class="note">(When filename is marked as being remote, then no attempt to get size of this file is made)</span>
</td></tr>
<tr><th>
Group:
</th><td>
<?php download_group_edit(isset($download['grp'])?$download['grp']:-1,'grp',2,'select'); ?>
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
