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

$page_name='Ctagory:Delete';
require_once('./admin_header.php');

function delete_category(){
    global $id,$lng,$db_prepend,$table_category;

    if (!mysql_query('DELETE FROM '.$db_prepend.$table_category.' where id='.$id.' and lng='.$lng.' limit 1')){
        show_error("Can't delete category! (".mysql_error().')');
        exit;
    }
    show_info_box('Category deleted',array(),'category.php');
    include_once('./admin_footer.php');
    exit;
}

if (isset($action) && ($action=='delete') && isset($lng) && isset($id)){
    if (!isset($members)){
        show_error_box('You have to choose what will happen to other items that belong to this category!');
        include_once('./admin_footer.php');
        exit();
    }
    if ($members=='delete'){
        delete_everywhere_category($id,$lng);
    }elseif ($members=='move'){
        change_everywhere_category($id,$category,$lng);
    }
    delete_category();
}elseif (isset($lng) && isset($id)){
//    if ($admin_confirm_delete){
        if (!$id_result=mysql_query(
        'SELECT id, name, short, lng, description, page '.
        ' from '.$db_prepend.$table_category.
        ' where lng='.$lng.' and id='.$id))
            show_error("Can't get category info! (".mysql_error().')');

        $category=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
//    }else{
//        delete_category();
//    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

?>
Do you want to delete following category?<br />
<table class="yesno">
  <tr>
    <td>
<form action="category_delete.php" method="post" class="delete">
<input type="hidden" name="id" value="<?php echo $category['id']; ?>" />
<input type="hidden" name="lng" value="<?php echo $category['lng']; ?>" />
<input type="hidden" name="action" value="delete" />
<p class="message">
If there are any articles, menu items etc. in this category, they should be:
</p>
<p class="radios">
<label class="radios"><input type="radio" name="members" value="delete" class="radio" checked="checked" /> Deleted <span class="warning">(this deletes also EVERYTHING what points to anything in this category)</span></label><br />
<label class="radios"><input type="radio" name="members" value="move" class="radio" /> Moved to category: <?php category_edit(-1,$lng,'category',FALSE,'select',array($category['id'])); ?></label><br />
<label class="radios"><input type="radio" name="members" value="keep" class="radio" /> Keept in current category <span  class="warning">(This is NOT recommended)</span></label><br />
</p>
<input type="submit" value=" Yes " class="delete" />
</form>
    </td>
    <td><?php make_return_button(' No ');?> </td>
  </tr>
</table>
<a href="<?php echo make_url($category['page'],$category['lng'])?>" target="_blank">Here</a> you can view default page for this category rendered in template.<br />

<table class="item">
<tr><th>
Category ID:
</th><td>
<?php echo $category['id'];?>
</td></tr>
<tr><th>
Language:
</th><td>
<?php echo $lang_name[$category['lng']]?>
</td></tr>
<tr><th>
Title:
</th><td>
<?php echo htmlspecialchars($category['name']) ?>
</td></tr>
<tr><th>
Short name:
</th><td>
<?php echo htmlspecialchars($category['short']) ?>
</td></tr>


<tr><th>
Description:
</th><td>
<?php echo htmlspecialchars($category['description']) ?>
</td></tr>
</table>

<?php
require_once('./admin_footer.php');
?>