<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Web Site System version 0.1                                          |
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
<form method="GET">
Language: <select name="filter_lng">
  <option value="any">Any</option>
<?php
for($i=0;$i<count($languages);$i++){

echo '<option value='.$i.((isset($filter_lng) && ((int)$filter_lng)==$i)?' selected':'').'>'.$lang_name[$i]."</option>\n";
}
?>
</select>
<input type="submit">
</form><br>


<?php

if (isset($filter_lng) && $filter_lng!='any') {
    $cond = ' and '.$table_prepend_name.$table_page.'.lng='.$filter_lng;
} else {
    $cond = '';
}

if (!$id_result=mysql_query(
'SELECT content, last_change, page, '.$table_prepend_name.$table_article.'.lng as lng, id, name, description, count, category'.
' from '.$table_prepend_name.$table_article.','.$table_prepend_name.$table_page.
' where id=page and '.$table_prepend_name.$table_article.'.lng='.$table_prepend_name.$table_page.'.lng'.$cond.
' order by page,lng'))
    do_error(1,'SELECT '.$table_prepend_name.$table_article.','.$table_prepend_name.$table_page.': '.mysql_error());

if (mysql_num_rows($id_result) == 0){
echo "Nothing...";
} else {
    echo 'Displayed articles: '.mysql_num_rows($id_result);
    echo "<table border=0><tr><th>Page</th><th>Title</th><th>Description</th><th>Language</th><th colspan=2>Action</th></tr>\n";
    $even=1;
    while ($item = mysql_fetch_array ($id_result)) {
        if ($even == 1) {
            echo '<tr bgcolor="#5f5f5f"><td>';
        } else {
            echo '<tr bgcolor="#8f8f8f"><td>';
        }
        $even = 1 - $even;
        echo $item['page'].'</td><td>'.$item['name'].'</td><td>'.$item['description'].'</td><td>'.$lang_name[$item['lng']].'</td><td><a href="article_edit.php?id=',$item['page'].'&lng='.$item['lng'].'">Edit</a></td><td><a href="article_delete.php?id=',$item['page'].'&lng='.$item['lng'].'">Delete</a></td></tr>'."\n";
    }
    echo "</table>\n";
}

require_once('./admin_footer.php');
?>
