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
$page_name='Downloads';
require_once('./admin_header.php');
?>
<table class="tabs">
  <tr>
<?php

make_tab_edit('./download_item.php','Downloads','/download_item');
make_tab_edit('./download_group.php','Download groups','/download_group');
make_tab_edit('./upload.php','Upload files','/upload');
?>
  </tr>
</table>

<table class="filter">
  <tr>
    <td class="filtertext">
      Filter:
    </td>
    <td class="filtercontent">
      <form method="get" action="download_item.php" class="filter">
        Filename:
        <input type="text" name="filter_name" <?php if(isset($filter_name)){ echo 'value="'.$filter_name.'"'; }?> class="text"/>
        &nbsp;<input type="submit" value=" Go " class="go" />
      </form>
    </td>
  </tr>
</table><br />
<?php

$cond = '1';
if (isset($filter_name) && ($filter_name != '')) {
    $cond.=' and filename like "%'.$filter_name.'%"';
}

if (!$id_result=mysql_query(
'SELECT id, filename, grp, count '.
' from '.$table_prepend_name.$table_download.
' where '.$cond.
' order by id'))
    show_error("Can't select downloads! (".mysql_error().')');

if (mysql_num_rows($id_result) == 0){
    echo "Nothing...";
} else {
    echo 'Listed downloads: '.mysql_num_rows($id_result);
    echo '<table class="data"><tr><th>Id</th><th>Filename</th><th>Group</th><th>Count</th><th>Actions</th></tr>'."\n";
    $even=1;
    while ($item = mysql_fetch_array ($id_result)) {
        make_row($even,'download_edit.php?id='.$item['id']);
        $even = 1 - $even;
        echo $item['id'].'</td><td>'.htmlspecialchars($item['filename']).'</td><td>'.$item['grp'].'</td><td>'.$item['count'].'</td>';
        echo '<td>&nbsp;<a href="download_edit.php?id='.$item['id'].'">Edit</a>&nbsp;|&nbsp;<a href="download_delete.php?id='.$item['id'].'">Delete</a>&nbsp;|&nbsp;<a href="../download.php?id='.$item['id'].'" target="_blank">Download</a>&nbsp;</td></tr>'."\n";
    }
    echo "</table>\n";
}
?>
<form action="download_edit.php" method="get">
Create new download
<input type="submit" value=" Go " class="go" />
<input type="hidden" name="action" value="new" />
</form>
<?php
require_once('./admin_footer.php');
?>
