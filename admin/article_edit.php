<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Web Site System version 0.1                                          |
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

$page_name='Article:Edit';
require_once('./admin_header.php');

if (isset($action) && ($action=='save')){
    if (!mysql_query('UPDATE '.$table_prepend_name.$table_article.' set content="'.$content.'",last_change=NOW() where page='.$page.' and lng='.$lng)){
        show_error("Can't save article info! (".mysql_error().')');
        exit;
    }
    if (!mysql_query('UPDATE '.$table_prepend_name.$table_page.' set name="'.$name.'",description="'.$description.'",keywords="'.$keywords.'",category='.$category.' where id='.$page.' and lng='.$lng)){
        show_error("Can't save page info! (".mysql_error().')');
        exit;
    }
    show_info_box('Article saved',array('lng'=>$lng,'id'=>$page));
    include_once('./admin_footer.php');
    exit;
}

if (!$id_result=mysql_query(
'SELECT UNIX_TIMESTAMP(last_change) as last_change, page, '.$table_prepend_name.$table_article.'.lng as lng, name, description, keywords, count, category, content '.
' from '.$table_prepend_name.$table_article.','.$table_prepend_name.$table_page.
' where id=page and '.$table_prepend_name.$table_article.'.lng='.$table_prepend_name.$table_page.'.lng and '.$table_prepend_name.$table_article.'.lng='.$lng.' and id='.$id))
    show_error("Can't get article info! (".mysql_error().')');
$article=mysql_fetch_array($id_result);
if (!isset($article['page'])){
    exit();
}
mysql_free_result($id_result);


?>
<form action="article_edit.php" method="POST">
<input type="hidden" name="action" value="save">
<table border="0">
<tr><th valign="top">
Page ID:
</th><td>
<input type="hidden" name="page" value="<?php echo $article['page']?>">
<?php echo $article['page']?>
</td></tr>
<tr><th valign="top">
Language:
</th><td>
<input type="hidden" name="lng" value="<?php echo $article['lng']?>">
<?php echo $lang_name[$article['lng']]?>
</td></tr>
<tr><th valign="top">
Last change:
</th><td>
<?php echo strftime('%c',$article['last_change'])?>
</td></tr>
<tr><th valign="top">
Title:
</th><td>
<?php sized_edit('name', $article['name']) ?>
</td></tr>
<tr><th valign="top">
Category:
</th><td>
<?php category_edit($article['category'],$article['lng'],'category') ?>
</td></tr>


<tr><th valign="top">
Description:
</th><td>
<?php sized_textarea('description',$article['description']) ?>
</td></tr>
<tr><th valign="top">
Keywords:
</th><td>
<?php sized_textarea('keywords',$article['keywords']) ?>
</td></tr>
<tr><th valign="top">
Content:
</th><td>
<?php sized_textarea('content',$article['content']) ?>
</td></tr>
<tr><th valign="top">
</th><td>
</td></tr>
<tr><th valign="top">
</th><td>
<table border="0" width="100%">
  <tr>
    <td align="center"><input type="submit" value=" Save "></td>
    <td align="center"><input type="reset" value=" Reset "></td>
  </tr>
</table>
</td></tr>
</table>

</form>
<?php
require_once('./admin_footer.php');
?>