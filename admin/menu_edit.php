<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// / wessie - web site system                                             |
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
$page_name='Menu:Edit';
require_once('./admin_header.php');
?>
<?php

if (isset($id)&&isset($lng)&&!isset($name)){
    if (!($id_result=(mysql_query('SELECT id,name,description,lng,page,category,parent,expand,rank from '.$table_prepend_name.$table_menu.' where lng='.$lng.' and id='.$id,$db_connection)))&&($child_id=0)){
        show_error("Can't get menu item info! (".mysql_error().')');
        exit;
    }
    $item = mysql_fetch_array ($id_result);
    mysql_free_result($id_result);

    if ($item['parent']!=0){
        if (!($id_result=(mysql_query('SELECT category from '.$table_prepend_name.$table_menu.' where lng='.$lng.' and id='.$item['parent'],$db_connection)))&&($child_id=0)){
            show_error("Can't get menu item info! (".mysql_error().')');
            exit;
        }
        $parent = mysql_fetch_array ($id_result);
        mysql_free_result($id_result);
    }

    if (!($id_result=mysql_query('SELECT name,description,category from '.$table_prepend_name.$table_page.' where lng='.$lng.' and id='.$item['page'].' limit 1',$db_connection))){
        show_error("Can't get page info! (".mysql_error().')');
        exit;
    }
    $page=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
} elseif (isset($category)&&isset($lng)&&!isset($name)){
    $item=array('lng'=>$lng,'category'=>$category,'parent'=>0,'rank'=>0,'expand'=>0);
    $page=array('name'=>'','description'=>'','category'=>-1);

} elseif (isset($parent)&&isset($lng)&&!isset($name)){
    if (!($id_result=(mysql_query('SELECT id,category from '.$table_prepend_name.$table_menu.' where lng='.$lng.' and id='.$parent,$db_connection)))&&($child_id=0)){
        show_error("Can't get menu item info! (".mysql_error().')');
        exit;
    }
    $parent = mysql_fetch_array ($id_result);
    mysql_free_result($id_result);

    $item=array('lng'=>$lng,'category'=>$parent['category'],'parent'=>$parent['id'],'rank'=>0,'expand'=>0);
    $page=array('name'=>'','description'=>'','category'=>-1);
} elseif (isset($id)){
    if (!($id_result=(mysql_query('UPDATE '.$table_prepend_name.$table_menu.
            ' set name="'.$name.'"'.
            ', description="'.$description.'"'.
            ', page='.$page.
            ', category='.$category.
            ', parent='.$parent.
            ', expand='.$expand.
            ', lng='.$lng.
            ', rank='.$rank.
            ' WHERE id='.$id
            ,$db_connection)))&&($child_id=0)){
        show_error("Can't update menu item info! (".mysql_error().')');
        exit;
    }
    show_info_box('Menu item saved',array('lng'=>$lng,'id'=>$id));
    include_once('./admin_footer.php');
    exit;
} else {
    if (!($id_result=(mysql_query('INSERT '.$table_prepend_name.$table_menu.
            ' set name="'.$name.'"'.
            ', description="'.$description.'"'.
            ', page='.$page.
            ', category='.$category.
            ', parent='.$parent.
            ', expand='.$expand.
            ', lng='.$lng.
            ', rank='.$rank
            ,$db_connection)))&&($child_id=0)){
        show_error("Can't create menu item info! (".mysql_error().')');
        exit;
    }
    if (!($id_result=(mysql_query('SELECT id from '.$table_prepend_name.$table_menu.' where '.
            'name="'.$name.'"'.
            ' and description="'.$description.'"'.
            ' and page='.$page.
            ' and category='.$category.
            ' and parent='.$parent.
            ' and expand='.$expand.
            ' and lng='.$lng.
            ' and rank='.$rank
            )))&&($child_id=0)){
        show_error("Can't get menu item info! (".mysql_error().')');
        exit;
    }
    $item = mysql_fetch_array ($id_result);
    mysql_free_result($id_result);

    show_info_box('Menu item created',array('lng'=>$lng,'id'=>$item['id']));
    include_once('./admin_footer.php');
    exit;
}
?>
<form action="menu_edit.php" method="post">
<?php if (isset($id)) echo '<input type="hidden" name="id" value="' . $id . '" />'; ?>
<input type="hidden" name="lng" value="<?php echo $lng; ?>" />
<input type="hidden" name="parent" value="<?php echo $item['parent']; ?>" />
<table border="0">
<tr><th valign="top"></th><th>Menu item values</th><th>Page <?php echo isset($item['page'])?$item['page']:''; ?> values</th></tr>
<tr><th valign="top">Name</th><td><?php sized_edit('name',isset($item['name'])?$item['name']:''); ?></td><td><?php echo htmlspecialchars($page['name']); ?></td></tr>
<tr><th valign="top">Description</th><td><?php sized_textarea('description',isset($item['description'])?$item['description']:'') ?></td><td><?php echo htmlspecialchars($page['description']); ?></td></tr>
<tr><th valign="top">Page</th><td><?php page_edit(isset($item['page'])?$item['page']:-1,$item['lng'],'page',TRUE); ?></td><td></td></tr>
<tr><th valign="top">Category</th><td>
<?php
if ($item['parent']!=0){
    echo '<input type="hidden" name="category" value="' . $parent['category'] . '" />' . htmlspecialchars(get_category_name($parent['category'],$item['lng']));
}else{
    category_edit($item['category'],$item['lng'],'category');
}
?></td><td><?php echo htmlspecialchars(get_category_name($page['category'],$item['lng'])); ?></td></tr>
<tr><th valign="top">
Language:
</th><td>
<input type="hidden" name="lng" value="<?php echo $item['lng']?>" />
<?php echo $lang_name[$item['lng']]?>
</td></tr>
<tr><th valign="top">Rank</th><td><input type="text" name="rank" value="<?php echo $item['rank']; ?>" /></td><td></td></tr>
<tr><th valign="top">Expand</th><td><select name="expand">
<?php
if ($item['expand']==0)
    echo'<option value="0" selected="selected">';
else
    echo'<option value="0">';
?>When selected</option>
<?php
if ($item['expand']==1)
    echo'<option value="1" selected="selected">';
else
    echo'<option value="1">';
?>Always</option>
</select>
</td><td></td></tr>
<tr><th valign="top">
</th><td>
<table border="0" width="100%">
  <tr>
    <td align="center"><input type="submit" value=" Save " /></td>
    <td align="center"><input type="reset" value=" Reset " /></td>
  </tr>
</table>
</td><td></td></tr>
</table>
</form>
<?php
require_once('./admin_footer.php');
?>
