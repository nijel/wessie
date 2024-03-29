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

if (isset($action) && ($action=='save')){
    if (!mysql_query('UPDATE '.$db_prepend.$table_article.' set content="'.opt_addslashes($content).'",last_change=NOW() where page='.$page.' and lng='.$lng)){
        show_error("Can't save article info! (".mysql_error().')');
        exit;
    }
    if (!mysql_query('UPDATE '.$db_prepend.$table_page.' set name="'.opt_addslashes($name).'",description="'.opt_addslashes($description).'",keywords="'.opt_addslashes($keywords).'",category='.$category.' where id='.$page.' and lng='.$lng)){
        show_error("Can't save page info! (".mysql_error().')');
        exit;
    }
    show_info_box('Article saved',array(),$form_done_url);
    include_once('./admin_footer.php');
    exit;
}elseif(isset($action) && ($action=='create_new')){
    $page=new_page($name,'article','',$description,$keywords,$lng,$category,$page);

    if (!mysql_query('INSERT '.$db_prepend.$table_article.' set content="'.opt_addslashes($content).'",last_change=NOW(), page='.$page.', lng='.$lng)){
        show_error("Can't save article info! (".mysql_error().')');
        exit;
    }
    show_info_box('Article created',array(),$form_done_url);
    include_once('./admin_footer.php');
    exit;
}elseif (isset($action) && ($action=='new') && isset($lng)){
    $action='create_new';
    if (isset($page)){
        if (!is_page_free($page,$lng)){
            show_error_box('This page allready exists!');
            include_once('./admin_footer.php');
            exit();
        }
    } else {
        $page=-1;
    }
    $article=array('name'=>'','description'=>'','keywords'=>'','content'=>'','category'=>-1,'lng'=>$lng,'page'=>$page);
}elseif (isset($action) && ($action=='translate') && isset($from_lng) && isset($to_lng)){
    $action='create_new';
    if (!$id_result=mysql_query(
    'SELECT UNIX_TIMESTAMP(last_change) as last_change, page, '.$db_prepend.$table_article.'.lng as lng, name, description, keywords, count, category, content '.
    ' from '.$db_prepend.$table_article.','.$db_prepend.$table_page.
    ' where id=page and '.$db_prepend.$table_article.'.lng='.$db_prepend.$table_page.'.lng and '.$db_prepend.$table_article.'.lng='.$from_lng.' and id='.$id))
        show_error("Can't get article info! (".mysql_error().')');
    $article=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($article['page'])){
        show_error_box("This page doesn't  exist!");
        exit();
    }
    $article['lng']=$to_lng;
}elseif (isset($lng) && isset($id)){
    $action='save';
    if (!$id_result=mysql_query(
    'SELECT UNIX_TIMESTAMP(last_change) as last_change, page, '.$db_prepend.$table_article.'.lng as lng, name, description, keywords, count, category, content '.
    ' from '.$db_prepend.$table_article.','.$db_prepend.$table_page.
    ' where id=page and '.$db_prepend.$table_article.'.lng='.$db_prepend.$table_page.'.lng and '.$db_prepend.$table_article.'.lng='.$lng.' and id='.$id))
        show_error("Can't get article info! (".mysql_error().')');
    $article=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($article['page'])){
        show_error_box("This page desn't  exist!");
        exit();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

?>
<form action="<?php echo $form_action;?>" method="post">
<?php echo $form_magic; ?>
<input type="hidden" name="action" value="<?php echo $action?>" />
<table class="item">
<tr><th>
Page ID:
</th><td>
<input type="hidden" name="page" value="<?php echo $article['page']?>" />
<?php echo ($article['page']!=-1?$article['page']:'Page not created yet')?>
</td></tr>
<tr><th>
Language:
</th><td>
<input type="hidden" name="lng" value="<?php echo $article['lng']?>" />
<?php echo $languages[$article['lng']]['name']; ?>
</td></tr>
<tr><th>
Last change:
</th><td>
<?php
if($action=='create_new'){
    echo 'New article';
}else{
    echo strftime('%c',$article['last_change']);
}
?>
</td></tr>
<tr><th>
Title:
</th><td>
<?php sized_edit('name', $article['name']) ?>
</td></tr>
<tr><th>
Category:
</th><td>
<?php category_edit($article['category'],$article['lng'],'category') ?>
</td></tr>


<tr><th>
Description:
</th><td>
<?php sized_textarea('description',$article['description']) ?>
</td></tr>
<tr><th>
Keywords:
</th><td>
<?php sized_textarea('keywords',$article['keywords']) ?>
</td></tr>
<tr><th>
Content:
</th><td>
<?php sized_textarea('content',$article['content']) ?>
</td></tr>
<tr><th>
</th><td>
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
    $transl=get_page_translations($article['page']);
    if (sizeof($transl)<sizeof($languages)){
        echo '<form action="'.$form_action.'" method="get">';
        echo 'Translate to ';
        echo '<input type="hidden" name="action" value="translate" />';
        echo '<input type="hidden" name="id" value="'.$article['page'].'" />';
        echo '<input type="hidden" name="from_lng" value="'.$lng.'" />';
        language_edit(-1,FALSE,'to_lng',$transl);
        echo '<input type="submit" value=" Go " class="go" />';
        echo $form_magic;
        echo '</form>';
    }
}
?>
