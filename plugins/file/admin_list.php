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

?>
<table class="filter">
  <tr>
    <td class="filtertext">
      Filter:
    </td>
    <td  class="filtercontent">
      <form method="get" action="<?php echo $filter_action;?>" class="filter">
        <?php echo $form_magic;?>
        Language:
        <?php language_edit((isset($filter_lng) && ($filter_lng != 'any'))?$filter_lng:-1,TRUE,'filter_lng',array(),'select') ?>
        &nbsp;Name:
        <input type="text" name="filter_name" <?php if(isset($filter_name)){ echo 'value="'.$filter_name.'"'; }?> class="text" />
        &nbsp;Description:
        <input type="text" name="filter_desc" <?php if(isset($filter_desc)){ echo 'value="'.$filter_desc.'"'; }?> class="text" />
        &nbsp;Filename:
        <input type="text" name="filter_filename" <?php if(isset($filter_filename)){ echo 'value="'.$filter_filename.'"'; }?> class="text" />
        &nbsp;<input type="submit" value=" Go " class="go" />
      </form>
    </td>
  </tr>
</table><br />
<?php

if (isset($filter_lng) && $filter_lng!='any') {
    $cond = ' and '.$db_prepend.$table_page.'.lng='.$filter_lng;
} else {
    $cond = '';
}
if (isset($filter_name) && ($filter_name != '')) {
    $cond.=' and name like "%'.$filter_name.'%"';
}
if (isset($filter_filename) && ($filter_filename != '')) {
    $cond.=' and param like "%'.$filter_filename.'%"';
}
if (isset($filter_desc) && ($filter_desc != '')) {
    $cond.=' and description like "%'.$filter_desc.'%"';
}

if (!$id_result=mysql_query(
'SELECT lng, id, name, description, count, category, param'.
' from '.$db_prepend.$table_page.
' where type="file" '.$cond.
' order by id,lng'))
    show_error("Can't select pages! (".mysql_error().')');

if (mysql_num_rows($id_result) == 0){
    echo "Nothing...";
} else {
    echo '<table class="data"><tr><th>Id</th><th>Name</th><th>Description</th><th>Filename</th><th>Pre</th><th>Language</th><th>Actions</th></tr>'."\n";
    $even=1;
    while ($item = mysql_fetch_array ($id_result)) {
        $url=$edit_url.'&amp;id='.$item['id'].'&amp;lng='.$item['lng'];
        make_row($even);
        $even = 1 - $even;
        $filename='UNKNOWN';
        $pre=FALSE;
        eval($item['param']);
        echo make_cell($item['id'],$url);
        echo make_cell(htmlspecialchars($item['name']),$url);
        echo make_cell(htmlspecialchars($item['description']),$url);
        echo make_cell(htmlspecialchars($filename),$url);
        echo make_cell($pre?'Yes':'No',$url);
        echo make_cell($lang_name[$item['lng']],$url);
        echo '<td>&nbsp;<a href="'.$url.'">Edit</a>&nbsp;|&nbsp;<a href="'.$delete_url.'&amp;id='.$item['id'].'&amp;lng='.$item['lng'].'">Delete</a>&nbsp;|&nbsp;<a href="'.make_url($item['id'],$item['lng']).'" target="_blank">View</a>&nbsp;'.((isset($admin_validator)&&($admin_validator!=''))?'|&nbsp;<a href="'.$admin_validator.urlencode(make_absolute_url($item['id'],$item['lng'])).'" target="_blank">Validate</a>&nbsp;':'').'</td></tr>'."\n";
    }
    echo "</table>\n";
    echo 'Listed pages: '.mysql_num_rows($id_result);
}
?>
<form action="<?php echo $edit_action;?>" method="get">
<?php echo $form_magic;?>
Create new file in language: <?php language_edit() ?>
<input type="submit" value=" Go " class="go" />
<input type="hidden" name="action" value="new" />
</form>
