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

$page_name='Article:Delete';
require_once('./admin_header.php');

function delete_article(){
    global $id,$lng,$table_prepend_name,$table_article,$table_page;

    if (!mysql_query('DELETE FROM '.$table_prepend_name.$table_page.' where id='.$id.' and lng='.$lng.' limit 1')){
        show_error("Can't delete page! (".mysql_error().')');
        exit;
    }
    if (!mysql_query('DELETE FROM '.$table_prepend_name.$table_article.' where page='.$id.' and lng='.$lng.' limit 1')){
        show_error("Can't delete page! (".mysql_error().')');
        exit;
    }
    show_info_box('Article deleted',array(),'article.php');
    include_once('./admin_footer.php');
    exit;
}

if (isset($action) && ($action=='delete') && isset($lng) && isset($id)){
    delete_article();
}elseif (isset($lng) && isset($id)){
    if ($admin_confirm_delete){
        if (!$id_result=mysql_query(
        'SELECT UNIX_TIMESTAMP(last_change) as last_change, page, '.$table_prepend_name.$table_article.'.lng as lng, name, description, keywords, count, category, content '.
        ' from '.$table_prepend_name.$table_article.','.$table_prepend_name.$table_page.
        ' where id=page and '.$table_prepend_name.$table_article.'.lng='.$table_prepend_name.$table_page.'.lng and '.$table_prepend_name.$table_article.'.lng='.$lng.' and id='.$id))
            show_error("Can't get article info! (".mysql_error().')');
        $article=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
        if (!isset($article['page'])){
            show_error_box("This page doesn't  exist!");
            exit();
        }
    }else{
        delete_article();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

?>
Do you want to delete following article?<br />
<table class="yesno">
  <tr>
    <td>
<form action="article_delete.php" method="post" class="delete">
<input type="hidden" name="id" value="<?php echo $article['page']; ?>" />
<input type="hidden" name="lng" value="<?php echo $article['lng']; ?>" />
<input type="hidden" name="action" value="delete" />
<input type="submit" value=" Yes " class="delete" />
</form>
    </td>
    <td><?php make_return_button(' No ');?> </td>
  </tr>
</table>
<a href="<?php echo make_url($id,$lng)?>" target="_blank">Here</a> you can view article rendered in template.<br />

<table class="item">
<tr><th>
Page ID:
</th><td>
<?php echo ($article['page']!=-1?$article['page']:'Page not created yet')?>
</td></tr>
<tr><th>
Language:
</th><td>
<?php echo $lang_name[$article['lng']]?>
</td></tr>
<tr><th>
Last change:
</th><td>
<?php
    echo strftime('%c',$article['last_change']);
?>
</td></tr>
<tr><th>
Title:
</th><td>
<?php echo htmlspecialchars($article['name']) ?>
</td></tr>
<tr><th>
Category:
</th><td>
<?php echo htmlspecialchars(get_category_name($article['category'],$article['lng'])) ?>
</td></tr>


<tr><th>
Description:
</th><td>
<?php echo htmlspecialchars($article['description']) ?>
</td></tr>
<tr><th>
Keywords:
</th><td>
<?php echo htmlspecialchars($article['keywords']) ?>
</td></tr>
<tr><th>
Content:
</th><td>
<?php echo htmlspecialchars($article['content']) ?>
</td></tr>
<tr><th>
</th><td>
</td></tr>
</table>

<?php
require_once('./admin_footer.php');
?>