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

function delete_page(){
    global $id,$lng,$table_prepend_name,$table_page,$form_done_url;

    if (!mysql_query('DELETE FROM '.$table_prepend_name.$table_page.' where id='.$id.' and lng='.$lng.' limit 1')){
        show_error("Can't delete page! (".mysql_error().')');
        exit;
    }
    show_info_box('Page deleted',array(),$form_done_url);
    include_once('./admin_footer.php');
    exit;
}

if (isset($action) && ($action=='delete') && isset($lng) && isset($id)){
    delete_page();
}elseif (isset($lng) && isset($id)){
    if ($admin_confirm_delete){
        if (!$id_result=mysql_query(
            'SELECT lng, id, name, description, count, category, param, keywords'.
            ' from '.$table_prepend_name.$table_page.
            ' where lng='.$lng.' and id='.$id))
            show_error("Can't get page info! (".mysql_error().')');
        $page=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
        if (!isset($page['id'])){
            show_error_box("This page doesn't  exist!");
            exit();
        }
    }else{
        delete_page();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

$pars=5;
$sentences=15;
$words=20;
$letters=15;
$addHtml=3;
eval($page['param']);

?>
Do you want to delete following page?<br />
<table class="yesno">
  <tr>
    <td>
<form action="<?php echo $form_action; ?>" method="post" class="delete">
<input type="hidden" name="id" value="<?php echo $page['id']; ?>" />
<input type="hidden" name="lng" value="<?php echo $page['lng']; ?>" />
<input type="hidden" name="action" value="delete" />
<input type="submit" value=" Yes " class="delete" />
<?php echo $form_magic;?>
</form>
    </td>
    <td><?php make_return_button(' No ');?> </td>
  </tr>
</table>
<a href="<?php echo make_url($id,$lng)?>" target="_blank">Here</a> you can view page rendered in template.<br />

<table class="item">
<tr><th>
Page ID:
</th><td>
<?php echo ($page['id']!=-1?$page['id']:'Page not created yet')?>
</td></tr>
<tr><th>
Language:
</th><td>
<?php echo $lang_name[$page['lng']]?>
</td></tr>
<tr><th>
Name:
</th><td>
<?php echo htmlspecialchars($page['name']) ?>
</td></tr>
<tr><th>
Category:
</th><td>
<?php echo htmlspecialchars(get_category_name($page['category'],$page['lng'])) ?>
</td></tr>


<tr><th>
Description:
</th><td>
<?php echo htmlspecialchars($page['description']) ?>
</td></tr>
<tr><th>
Keywords:
</th><td>
<?php echo htmlspecialchars($page['keywords']) ?>
</td></tr>

<tr><th>
Paragraphs:
</th><td>
<?php echo $pars; ?>
</td></tr>
<tr><th>
Max. senteces per paragraph:
</th><td>
<?php echo $sentences; ?>
</td></tr>
<tr><th>
Max. words per sentece:
</th><td>
<?php echo $words; ?>
</td></tr>
<tr><th>
Max. letters per word:
</th><td>
<?php echo $letters; ?>
</td></tr>

<tr><th>
Add <code>&lt;p&gt;</code>:
</th><td>
<?php if (($addHtml & 1) == 1) echo 'Yes'; else echo 'No'; ?>
</td></tr>
<tr><th>
Add randomly <code>&lt;a&gt;</code>:
</th><td>
<?php if (($addHtml & 2) == 2) echo 'Yes'; else echo 'No'; ?>
</td></tr>

</table>
