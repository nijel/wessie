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

$page_name='Category:Edit';
require_once('./admin_header.php');

if (isset($action) && ($action=='save')){
    if (!mysql_query('UPDATE '.$table_prepend_name.$table_category.' set name="'.$name.'", page='.$page.', short="'.$short.'", description="'.$description.'" WHERE id='.$id.' AND lng='.$lng)){
        show_error("Can't save article info! (".mysql_error().')');
        exit;
    }
    show_info_box('Category saved',array('lng'=>$lng,'id'=>$id));
    include_once('./admin_footer.php');
    exit;
}elseif(isset($action) && ($action=='create_new')){
    if (!mysql_query('INSERT '.$table_prepend_name.$table_category.' set name="'.$name.'"'.(($id==-1)?'':(', id='.$id)).', lng='.$lng.', page='.$page.', short="'.$short.'", description="'.$description.'"')){
        show_error("Can't save article info! (".mysql_error().')');
        exit;
    }
    if (!$id_result=mysql_query('SELECT id FROM '.$table_prepend_name.$table_category.' where name="'.$name.'" and lng='.$lng.' and page='.$page.' and short="'.$short.'" and description="'.$description.'"')){
        show_error("Can't get article info! (".mysql_error().')');
        exit;
    }
    $item=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    show_info_box('Category created',array('lng'=>$lng,'id'=>$item['id']));
    include_once('./admin_footer.php');
    exit;
}elseif (isset($action) && ($action=='new') && isset($lng)){
    $action='create_new';
    if (isset($id)){
        if (!is_category_free($id,$lng)){
            show_error_box('This category allready exists!');
            include_once('./admin_footer.php');
            exit();
        }
    } else {
        $id=-1;
    }
    $category=array('id'=>$id,'name'=>'','short'=>'','lng'=>$lng,'description'=>'','page'=>-1);

}elseif (isset($action) && ($action=='translate') && isset($from_lng) && isset($to_lng)){
    $action='create_new';
    if (!$id_result=mysql_query(
    'SELECT id, name, short, lng, description, page '.
    ' from '.$table_prepend_name.$table_category.
    ' where lng='.$from_lng.' and id='.$id))
        show_error("Can't get category info! (".mysql_error().')');
    $category=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($category['id'])){
        show_error_box("This category doesn't  exist!");
        exit();
    }
    $category['lng']=$to_lng;
}elseif (isset($lng) && isset($id)){
    $action='save';
    if (!$id_result=mysql_query(
    'SELECT id, name, short, lng, description, page '.
    ' from '.$table_prepend_name.$table_category.
    ' where lng='.$lng.' and id='.$id))
        show_error("Can't get category info! (".mysql_error().')');
    $category=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($category['page'])){
        show_error_box("This category desn't  exist!");
        exit();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

?>

<form action="category_edit.php" method="post">
<input type="hidden" name="action" value="<?php echo $action?>" />
<table class="item">
<tr><th>
Category ID:
</th><td>
<input type="hidden" name="id" value="<?php echo $category['id']?>" />
<?php echo ($category['id']!=-1?$category['id']:'Category not created yet')?>
</td></tr>
<tr><th>
Language:
</th><td>
<input type="hidden" name="lng" value="<?php echo $category['lng']?>" />
<?php echo $lang_name[$category['lng']]?>
</td></tr>
<tr><th>
Name:
</th><td>
<?php sized_edit('name', $category['name']) ?>
</td></tr>
<tr><th>
Short name:
</th><td>
<?php sized_edit('short', $category['short']) ?>
</td></tr>
<tr><th>
Page
</th><td>
<?php page_edit(isset($category['page'])?$category['page']:-1,$category['lng'],'page',TRUE); ?>
</td></tr>

<tr><th>
Description:
</th><td>
<?php sized_textarea('description',$category['description']) ?>
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
if ($action!='create_new'){
    $transl=get_category_translations($category['id']);
    if (sizeof($transl)<sizeof($lang_name)){
        echo '<form action="category_edit.php" method="get">';
        echo 'Translate to ';
        echo '<input type="hidden" name="action" value="translate" />';
        echo '<input type="hidden" name="id" value="'.$category['id'].'" />';
        echo '<input type="hidden" name="from_lng" value="'.$lng.'" />';
        language_edit(-1,FALSE,'to_lng',$transl);
        echo '<input type="submit" value=" Go " class="go" />';
        echo '</form>';
    }
}
?>

<?php
require_once('./admin_footer.php');
?>