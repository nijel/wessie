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
$page_name='Users';
require_once('./admin_header.php');
require_once('./user_common.php');

?>
<table class="filter">
  <tr>
    <td class="filtertext">
      Filter:
    </td>
    <td  class="filtercontent">
      <form method="get" action="user.php" class="filter">
        &nbsp;User&nbsp;name:
        <input type="text" name="filter_user" <?php if(isset($filter_user)){ echo 'value="'.$filter_user.'"'; }?> class="text" />
        &nbsp;Name:
        <input type="text" name="filter_name" <?php if(isset($filter_name)){ echo 'value="'.$filter_name.'"'; }?> class="text" />
        &nbsp;Mail:
        <input type="text" name="filter_mail" <?php if(isset($filter_mail)){ echo 'value="'.$filter_mail.'"'; }?> class="text" />
        &nbsp;Web:
        <input type="text" name="filter_web" <?php if(isset($filter_web)){ echo 'value="'.$filter_web.'"'; }?> class="text" />
        &nbsp;<input type="submit" value=" Go " class="go" />
      </form>
    </td>
  </tr>
</table><br />
<?php

$cond = '1';
if (isset($filter_user) && $filter_user!='') {
    $cond .= ' and user like "%'.$filter_user.'%"';
}
if (isset($filter_name) && ($filter_name != '')) {
    $cond.=' and name like "%'.$filter_name.'%"';
}
if (isset($filter_mail) && ($filter_mail != '')) {
    $cond.=' and mail like "%'.$filter_mail.'%"';
}
if (isset($filter_web) && ($filter_web != '')) {
    $cond.=' and web like "%'.$filter_web.'%"';
}

if (!$id_result=mysql_query(
'SELECT * from '.$table_prepend_name.$table_users.
' where '.$cond.
' order by user'))
    show_error("Can't select users! (".mysql_error().')');

if (mysql_num_rows($id_result) == 0){
    echo "Nothing...";
} else {
    echo '<table class="data"><tr><th>User name</th><th>Name</th><th>Mail</th><th>Web</th><th>Actions</th></tr>'."\n";
    $even=1;
    while ($item = mysql_fetch_array ($id_result)) {
        $url='user_edit.php?id='.$item['user'];
        make_row($even);
        $even = 1 - $even;
        echo make_cell(htmlspecialchars($item['user']),$url);
        echo make_cell(htmlspecialchars($item['name']),$url);
        echo make_cell('<a href="mailto:'.htmlspecialchars($item['mail']).'">'.htmlspecialchars($item['mail']).'</a>');
        echo make_cell('<a href="'.htmlspecialchars($item['web']).'" target="_blank">'.htmlspecialchars($item['web']).'</a>');
        echo '<td>&nbsp;<a href="'.$url.'">Edit</a>&nbsp;|&nbsp;'.($item['user']=='admin'?'<a class="disabled">Delete</a>':'<a href="user_delete.php?id='.$item['user'].'">Delete</a>').'</td></tr>'."\n";
    }
    echo "</table>\n";
    echo 'Listed users: '.mysql_num_rows($id_result);
}
?>
<form action="user_edit.php" method="get">
Create new user
<input type="submit" value=" Go " class="go" />
<input type="hidden" name="action" value="new" />
</form>
<?php
require_once('./admin_footer.php');
?>
