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
$page_name='Downloads';
require_once('./download_header.php');
?>

<table class="filter">
  <tr>
    <td class="filtertext">
      Filter:
    </td>
    <td class="filtercontent">
      <form method="get" action="download_item.php" class="filter">
        Filename:
        <input type="text" name="filter_name" <?php if(isset($filter_name)){ echo 'value="'.$filter_name.'"'; }?> class="text"/>
        &nbsp;Group:
        <?php download_group_edit((isset($filter_group) && ($filter_group != 'any'))?$filter_group:-1,'filter_group',1,'select') ?>
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
if (isset($filter_group) && ($filter_group != 'any')) {
    $cond.=' and grp='.$filter_group;
}

if (!$id_result=mysql_query(
'SELECT id, filename, remote, grp, count '.
' from '.$table_prepend_name.$table_download.
' where '.$cond.
' order by id'))
    show_error("Can't select downloads! (".mysql_error().')');

if (mysql_num_rows($id_result) == 0){
    echo "Nothing...";
} else {
    echo '<table class="data"><tr><th>Id</th><th>Filename</th><th>Remote</th><th>Size</th><th>Group</th><th>Count</th><th>Actions</th></tr>'."\n";
    $even=1;
    while ($item = mysql_fetch_array ($id_result)) {
        if ($item['remote']==0){
            if (!file_exists('../'.$item['filename'])){
                $size='<span class="error">Not found</span>';
            }else{
                $size=human_readable_size(filesize('../'.$item['filename']));
            }
        }else{
            $file = @fopen ($item['filename'], 'r');
            if (!$file) {
                $size='<span class="error">Not found</span>';
            }else{
                $size='N/A';
                fclose($file);
            }
        }
        $url='download_item_edit.php?id='.$item['id'];
        make_row($even);
        $even = 1 - $even;
        make_cell($item['id'],$url);
        make_cell(htmlspecialchars($item['filename']),$url);
        make_cell($item['remote']==1?'yes':'no',$url);
        make_cell($size,$url);
        make_cell(htmlspecialchars(get_download_group_name($item['grp'])),$url);
        make_cell($item['count'],$url);
        echo '<td>&nbsp;<a href="'.$url.'">Edit</a>&nbsp;|&nbsp;<a href="download_item_delete.php?id='.$item['id'].'">Delete</a>&nbsp;|&nbsp;<a href="../get.php/'.$item['id'].'/'.basename($item['filename']).'" target="_blank">Download</a>&nbsp;</td></tr>'."\n";
    }
    echo "</table>\n";
    echo 'Listed downloads: '.mysql_num_rows($id_result);
}
?>
<form action="download_item_edit.php" method="get">
Create new download
<input type="submit" value=" Go " class="go" />
<input type="hidden" name="action" value="new" />
</form>
<?php
require_once('./admin_footer.php');
?>
