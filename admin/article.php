<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// / wessie - web site system                                             |
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

$page_name='Articles';
require_once('./admin_header.php');
?>
<br />
<table class="filter">
  <tr>
    <td class="filtertext">
      Filter:
    </td>
    <td  class="filtercontent">
      <form method="get" action="article.php" class="filter">
        Language:
        <?php language_edit((isset($filter_lng) && ($filter_lng != 'any'))?$filter_lng:-1,TRUE,'filter_lng',array(),'select') ?>
        &nbsp;Title:
        <input type="text" name="filter_title" <?php if(isset($filter_title)){ echo 'value="'.$filter_title.'"'; }?> class="text" />
        &nbsp;Description:
        <input type="text" name="filter_desc" <?php if(isset($filter_desc)){ echo 'value="'.$filter_desc.'"'; }?> class="text" />
        &nbsp;<input type="submit" value=" Go " class="go" />
      </form>
    </td>
  </tr>
</table><br />
<?php

if (isset($filter_lng) && $filter_lng!='any') {
    $cond = ' and '.$table_prepend_name.$table_page.'.lng='.$filter_lng;
} else {
    $cond = '';
}
if (isset($filter_title) && ($filter_title != '')) {
    $cond.=' and name like "%'.$filter_title.'%"';
}
if (isset($filter_desc) && ($filter_desc != '')) {
    $cond.=' and description like "%'.$filter_desc.'%"';
}

if (!$id_result=mysql_query(
'SELECT UNIX_TIMESTAMP(last_change) as last_change, page, '.$table_prepend_name.$table_article.'.lng as lng, id, name, description, count, category'.
' from '.$table_prepend_name.$table_article.','.$table_prepend_name.$table_page.
' where id=page and '.$table_prepend_name.$table_article.'.lng='.$table_prepend_name.$table_page.'.lng'.$cond.
' order by page,lng'))
    show_error("Can't select articles and pages! (".mysql_error().')');

if (mysql_num_rows($id_result) == 0){
    echo "Nothing...";
} else {
    echo 'Listed articles: '.mysql_num_rows($id_result);
    echo '<table class="data"><tr><th>Page</th><th>Title</th><th>Description</th><th>Language</th><th>Last change</th><th>Actions</th></tr>'."\n";
    $even=1;
    while ($item = mysql_fetch_array ($id_result)) {
        if ($even == 1) {
            echo '<tr class="even"';
        } else {
            echo '<tr class="odd"';
        }
        highlighter($admin_highlight_list);
        echo'><td>';
        $even = 1 - $even;
        echo $item['page'].'</td><td>'.htmlspecialchars($item['name']).'</td><td>'.htmlspecialchars($item['description']).'</td><td>'.$lang_name[$item['lng']].'</td><td>'.strftime('%c',$item['last_change']).'</td>';
        echo '<td>&nbsp;<a href="article_edit.php?id=',$item['page'].'&amp;lng='.$item['lng'].'">Edit</a>&nbsp;|&nbsp;<a href="article_delete.php?id=',$item['page'].'&amp;lng='.$item['lng'].'">Delete</a>&nbsp;|&nbsp;<a href="'.make_url($item['page'],$item['lng']).'" target="_blank">View</a>&nbsp;</td></tr>'."\n";
    }
    echo "</table>\n";
}
?>
<form action="article_edit.php" method="get">
Create new article, in language: <?php language_edit() ?>
<input type="submit" value=" Go " class="go" />
<input type="hidden" name="action" value="new" />
</form>
<?php
require_once('./admin_footer.php');
?>
