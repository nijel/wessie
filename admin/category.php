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
$page_name='Categories';
require_once('./admin_header.php');
?>
<table class="filter">
  <tr>
    <td class="filtertext">
      Filter:
    </td>
    <td class="filtercontent">
      <form method="get" action="category.php" class="filter">
        Language:
        <?php language_edit((isset($filter_lng) && ($filter_lng != 'any'))?$filter_lng:-1,TRUE,'filter_lng',array(),'select') ?>
        &nbsp;Title:
        <input type="text" name="filter_title" <?php if(isset($filter_title)){ echo 'value="'.$filter_title.'"'; }?> class="text"/>
        &nbsp;Short name:
        <input type="text" name="filter_short" <?php if(isset($filter_short)){ echo 'value="'.$filter_short.'"'; }?> class="text"/>
        &nbsp;Description:
        <input type="text" name="filter_desc" <?php if(isset($filter_desc)){ echo 'value="'.$filter_desc.'"'; }?> class="text"/>
        &nbsp;<input type="submit" value=" Go " class="go" />
      </form>
    </td>
  </tr>
</table><br />
<?php

$cond = '1';
if (isset($filter_lng) && $filter_lng!='any') {
    $cond .= ' and lng='.$filter_lng;
}
if (isset($filter_title) && ($filter_title != '')) {
    $cond.=' and name like "%'.$filter_title.'%"';
}
if (isset($filter_short) && ($filter_short != '')) {
    $cond.=' and short like "%'.$filter_short.'%"';
}
if (isset($filter_desc) && ($filter_desc != '')) {
    $cond.=' and description like "%'.$filter_desc.'%"';
}

if (!$id_result=mysql_query(
'SELECT id, name, short, lng, description, page '.
' from '.$db_prepend.$table_category.
' where '.$cond.
' order by '.$category_order.',lng'))
    show_error("Can't select categories! (".mysql_error().')');

if (mysql_num_rows($id_result) == 0){
    echo "Nothing...";
} else {
    echo '<table class="data"><tr><th>Id</th><th>Name</th><th>Short</th><th>Description</th><th>Language</th><th>Page</th><th>Actions</th></tr>'."\n";
    $even=1;
    while ($item = mysql_fetch_array ($id_result)) {
        $url='category_edit.php?id='.$item['id'].'&amp;lng='.$item['lng'];
        make_row($even);
        $even = 1 - $even;
        make_cell($item['id'],$url);
        make_cell(htmlspecialchars($item['name']),$url);
        make_cell(htmlspecialchars($item['short']),$url);
        make_cell(htmlspecialchars($item['description']),$url);
        make_cell($lang_name[$item['lng']],$url);
        make_cell($item['page'],$url);
        echo '<td>&nbsp;<a href="'.$url.'">Edit</a>&nbsp;|&nbsp;<a href="category_delete.php?id='.$item['id'].'&amp;lng='.$item['lng'].'">Delete</a>&nbsp;|&nbsp;<a href="'.make_url($item['page'],$item['lng']).'" target="_blank">View</a>&nbsp;</td></tr>'."\n";
    }
    echo "</table>\n";
    echo 'Listed categories: '.mysql_num_rows($id_result);
}
?>
<form action="category_edit.php" method="get">
Create new category, in language: <?php language_edit() ?>
<input type="submit" value=" Go " class="go" />
<input type="hidden" name="action" value="new" />
</form>
<?php
require_once('./admin_footer.php');
?>
