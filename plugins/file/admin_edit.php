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
    $param=addslashes("\$filename='$filename';\n\$pre=".(isset($pre)?'TRUE':'FALSE').";\n\$code=".(isset($code)?'TRUE':'FALSE').";\n\$html=".(isset($html)?'TRUE':'FALSE').";\n\$highlight=".(isset($highlight)?'TRUE':'FALSE').";\n");
    if (!mysql_query('UPDATE '.$db_prepend.$table_page.' set name="'.opt_addslashes($name).'",description="'.opt_addslashes($description).'",keywords="'.opt_addslashes($keywords).'",category='.$category.',param="'.$param.'" where id='.$page.' and lng='.$lng)){
        show_error("Can't save page info! (".mysql_error().')');
        exit;
    }
    show_info_box('Page saved',array(),$form_done_url);
    include_once('./admin_footer.php');
    exit;
}elseif(isset($action) && ($action=='create_new')){
    $param=addslashes("\$filename='$filename';\n\$pre=".(isset($pre)?'TRUE':'FALSE').";\n\$code=".(isset($code)?'TRUE':'FALSE').";\n\$html=".(isset($html)?'TRUE':'FALSE').";\n");
    $page=new_page($name,'file',$param,$description,$keywords,$lng,$category,$page);

    show_info_box('Page created',array(),$form_done_url);
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
    $page=array('name'=>'','description'=>'','keywords'=>'','param'=>'','category'=>-1,'lng'=>$lng,'id'=>$page);
}elseif (isset($action) && ($action=='translate') && isset($from_lng) && isset($to_lng)){
    $action='create_new';
    if (!$id_result=mysql_query(
    'SELECT lng, id, name, description, count, category, param, keywords'.
    ' from '.$db_prepend.$table_page.
    ' where lng='.$from_lng.' and id='.$id))
        show_error("Can't get page info! (".mysql_error().')');
    $page=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($page['id'])){
        show_error_box("This page doesn't  exist!");
        exit();
    }
    $page['lng']=$to_lng;
}elseif (isset($lng) && isset($id)){
    $action='save';
    if (!$id_result=mysql_query(
    'SELECT lng, id, name, description, count, category, param, keywords'.
    ' from '.$db_prepend.$table_page.
    ' where lng='.$lng.' and id='.$id))
        show_error("Can't get page info! (".mysql_error().')');
    $page=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($page['id'])){
        show_error_box("This page desn't  exist!");
        exit();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

$filename='UNKNOWN';
$pre=TRUE;
$code=TRUE;
$html=TRUE;
$highlight=FALSE;
eval($page['param']);

?>

<form action="<?php echo $form_action;?>" method="post">
<?php echo $form_magic; ?>
<input type="hidden" name="action" value="<?php echo $action?>" />
<table class="item">
<tr><th>
Page ID:
</th><td>
<input type="hidden" name="page" value="<?php echo $page['id']?>" />
<?php echo ($page['id']!=-1?$page['id']:'Page not created yet')?>
</td></tr>
<tr><th>
Language:
</th><td>
<input type="hidden" name="lng" value="<?php echo $page['lng']?>" />
<?php echo $lang_name[$page['lng']]?>
</td></tr>
<tr><th>
Name:
</th><td>
<?php sized_edit('name', $page['name']) ?>
</td></tr>
<tr><th>
Category:
</th><td>
<?php category_edit($page['category'],$page['lng'],'category') ?>
</td></tr>
<tr><th>
Description:
</th><td>
<?php sized_textarea('description',$page['description']) ?>
</td></tr>
<tr><th>
Keywords:
</th><td>
<?php sized_textarea('keywords',$page['keywords']) ?>
</td></tr>

<tr><th>
Filename:
</th><td>
<?php sized_edit('filename', $filename) ?><input type="button" class="browse" onclick="open_browse_window('<?php echo (($filename!='')?dirname($filename):'');?>','nolimit');" value="..." />
</td></tr>

<tr><th>
Highlight php:
</th><td>
<?php echo '<input type="checkbox" name="highlight" value="1"  class="check"'.(($highlight)?'checked="checked"':'').' />'; ?><br/>
<span class="warning">When selected, following options take no effect!</span>
</td></tr>
<tr><th>
Add <code>&lt;pre&gt;</code>:
</th><td>
<?php echo '<input type="checkbox" name="pre" value="1"  class="check"'.(($pre)?'checked="checked"':'').' />'; ?>
</td></tr>
<tr><th>
Add <code>&lt;code&gt;</code>:
</th><td>
<?php echo '<input type="checkbox" name="code" value="1"  class="check"'.(($code)?'checked="checked"':'').' />'; ?>
</td></tr>
<tr><th>
Replace html entities:
</th><td>
<?php echo '<input type="checkbox" name="html" value="1"  class="check"'.(($html)?'checked="checked"':'').' />'; ?>
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
    $transl=get_page_translations($page['id']);
    if (sizeof($transl)<sizeof($lang_name)){
        echo '<form action="'.$form_action.'" method="get">';
        echo 'Translate to ';
        echo '<input type="hidden" name="action" value="translate" />';
        echo '<input type="hidden" name="id" value="'.$page['id'].'" />';
        echo '<input type="hidden" name="from_lng" value="'.$lng.'" />';
        language_edit(-1,FALSE,'to_lng',$transl);
        echo '<input type="submit" value=" Go " class="go" />';
        echo $form_magic;
        echo '</form>';
    }
}
?>
