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
    $cond.=' and name like "%'.opt_addslashes($filter_name).'%"';
}
if (isset($filter_desc) && ($filter_desc != '')) {
    $cond.=' and description like "%'.opt_addslashes($filter_desc).'%"';
}

if (!$id_result=mysql_query(
'SELECT lng, id, name, description, count, category, param'.
' from '.$db_prepend.$table_page.
' where type="bullshit" '.$cond.
' order by id,lng'))
    show_error("Can't select pages! (".mysql_error().')');

if (mysql_num_rows($id_result) == 0){
    echo "Nothing...";
} else {
    echo '<table class="data"><tr><th>Id</th><th>Name</th><th>Description</th><th>Language</th><th>Paragraphs</th><th>Actions</th></tr>'."\n";
    $even=1;
    while ($item = mysql_fetch_array ($id_result)) {
        $url=$edit_url.'&amp;id='.$item['id'].'&amp;lng='.$item['lng'];
        make_row($even);
        $even = 1 - $even;

        $pars=5;
        $sentences=15;
        $words=20;
        $letters=15;
        $addHtml=3;
        eval($item['param']);

        echo make_cell($item['id'],$url);
        echo make_cell(htmlspecialchars($item['name']),$url);
        echo make_cell(htmlspecialchars($item['description']),$url);
        echo make_cell($lang_name[$item['lng']],$url);
        echo make_cell($pars,$url);
        echo '<td>&nbsp;<a href="'.$url.'">Edit</a>&nbsp;|&nbsp;<a href="'.$delete_url.'&amp;id='.$item['id'].'&amp;lng='.$item['lng'].'">Delete</a>&nbsp;|&nbsp;<a href="'.make_url($item['id'],$item['lng']).'" target="_blank">View</a>&nbsp;'.((isset($admin_validator)&&($admin_validator!=''))?'|&nbsp;<a href="'.$admin_validator.urlencode(make_absolute_url($item['id'],$item['lng'])).'" target="_blank">Validate</a>&nbsp;':'').'</td></tr>'."\n";
    }
    echo "</table>\n";
    echo 'Listed pages: '.mysql_num_rows($id_result);
}
?>
<form action="<?php echo $edit_action;?>" method="get">
<?php echo $form_magic;?>
Create new bullshit page in language: <?php language_edit() ?>
<input type="submit" value=" Go " class="go" />
<input type="hidden" name="action" value="new" />
</form>
