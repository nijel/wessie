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
$page_name='Menu:Delete';
require_once('./admin_header.php');
?>
<?php

function delete_menuitem(){
    global $id,$lng,$table_prepend_name,$table_menu,$table_page;

    if (!mysql_query('DELETE FROM '.$table_prepend_name.$table_menu.' where id='.$id.' and lng='.$lng.' limit 1')){
        show_error("Can't delete menu item! (".mysql_error().')');
        exit;
    }
    show_info_box('Menu item deleted ',array(),'menu.php');
    include_once('./admin_footer.php');
    exit;
}

if (isset($id)&&isset($lng)&&!isset($action)){
    if ($admin_confirm_delete){
        if (!($id_result=(mysql_query('SELECT id,name,description,lng,page,category,parent,expand,rank from '.$table_prepend_name.$table_menu.' where lng='.$lng.' and id='.$id,$db_connection)))&&($child_id=0)){
            show_error("Can't get menu item info! (".mysql_error().')');
            exit;
        }
        $item = mysql_fetch_array ($id_result);
        mysql_free_result($id_result);

        if (!($id_result=mysql_query('SELECT name,description,category from '.$table_prepend_name.$table_page.' where lng='.$lng.' and id='.$item['page'].' limit 1',$db_connection))){
            show_error("Can't get page info! (".mysql_error().')');
            exit;
        }
        $page=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
        if (!isset($item['id'])){
            show_error_box("This menu item doesn't  exist!");
            exit();
        }
    }else{
        delete_menuitem();
    }
} elseif (isset($id)&&isset($lng)&&isset($action)){
    delete_menuitem();
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}
?>
Do you want to delete following menu item?<br />
<table class="yesno">
  <tr>
    <td>
<form action="menu_delete.php" method="post" class="delete">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="lng" value="<?php echo $lng; ?>" />
<input type="hidden" name="action" value="delete" />
<input type="submit" value=" Yes " class="delete" />
</form>
    </td>
    <td><?php make_return_button(' No ');?> </td>
  </tr>
</table>
<a href="<?php echo make_url($id,$lng)?>" target="_blank">Here</a> you can view menu rendered in template.<br />

<?php if (isset($id)) echo '<input type="hidden" name="id" value="' . $id . '" />'; ?>
<table class="item">
<tr><th></th><th>Menu item values</th><th>Page <?php echo isset($item['page'])?$item['page']:''; ?> values</th></tr>
<tr><th>Name</th><td><?php echo htmlspecialchars(isset($item['name'])?$item['name']:''); ?></td><td><?php echo htmlspecialchars($page['name']); ?></td></tr>
<tr><th>Description</th><td><?php echo htmlspecialchars(isset($item['description'])?$item['description']:''); ?></td><td><?php echo htmlspecialchars($page['description']); ?></td></tr>
<tr><th>Page</th><td><?php echo $item['page']; ?></td><td></td></tr>
<tr><th>Category</th><td>
<?php
    echo htmlspecialchars(get_category_name($item['category'],$item['lng']));
?></td><td><?php echo htmlspecialchars(get_category_name($page['category'],$item['lng'])); ?></td></tr>
<tr><th>
Language:
</th><td>
<?php echo $lang_name[$item['lng']]?>
</td></tr>
<tr><th>Rank</th><td><?php echo $item['rank']; ?></td><td></td></tr>
<tr><th>Expand</th><td>
<?php
if ($item['expand']==0)
    echo 'When selected';
elseif ($item['expand']==1)
    echo 'Always';
?>
</td><td></td></tr>
</table>
<?php
require_once('./admin_footer.php');
?>
