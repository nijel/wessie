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
$page_name='Menu';
require_once('./admin_header.php');
?>
<table class="filter">
  <tr>
    <td class="filtertext">
      Filter:
    </td>
    <td  class="filtercontent">
<form action="menu.php" method="get" class="filter">
Language:&nbsp;<?php
language_edit(isset($lng)?$lng:-1,TRUE,'lng');
echo ' Category:&nbsp;';
category_edit(isset($category)?$category:-1,isset($lng)?($lng=='any'?0:$lng):0,'category',TRUE);
?>
<input type="submit" value=" Go " class="go" />
</form>
    </td>
  </tr>
</table><br />
<?php

function add_childs($child_id,$depth,$item_lng){
global $site_name,$site_author,$site_author_email,$site_name,$site_home,$page_title,$category_name,$wessie_version,$wessie_author,$browser,$os,
    $wessie_author_email,$wessie_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
    $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path,$lng;
global $db_connection,$table_menu,$table_page,$db_prepend,$category,$even, $languages;
global $listed_items;

if (!($id_result=(mysql_query('SELECT id,name,description,lng,page,category,parent,expand,rank from '.$db_prepend.$table_menu
        .' where '.($item_lng=='any'?1:('lng='.$item_lng)).' and parent='.$child_id.' and '.($category=='any'?1:('category='.$category)).' order by lng,rank',$db_connection)))&&($child_id=0))
    show_error("Can't select menu items! (".mysql_error().')');

while ($item = mysql_fetch_array ($id_result)){
    if (!($id2_result=mysql_query('SELECT name,description from '.$db_prepend.$table_page.' where lng='.$item['lng'].' and id='.$item['page'].' limit 1',$db_connection)))
        show_error("Can't get page info! (".mysql_error().')');
    $page=mysql_fetch_array($id2_result);
    mysql_free_result($id2_result);

    if ((!isset($item['name']))||($item['name']=='')) $name=$page['name'];
    else $name=$item['name'];

    if ((!isset($item['description']))||($item['description']=='')) $desc=$page['description'];
    else $desc=$item['description'];

    $url='menu_edit.php?id='.$item['id'].'&amp;lng='.$item['lng'];
    $spaces = '';
    for ($i=0; $i<$depth; $i++) $spaces .= '&nbsp;&nbsp;&nbsp;&nbsp;';

    make_row($even);
    $even = 1 - $even;

    make_cell($item['id'],$url);
    make_cell($spaces.htmlspecialchars($name),$url);
    make_cell(htmlspecialchars(get_category_name($item['category'],$item['lng'])),$url);
    make_cell(htmlspecialchars($desc),$url);
    make_cell($languages[$item['lng']]['name'],$url);
    make_cell($depth,$url);
    make_cell($item['rank'],$url);
    make_cell($item['expand'],$url);
    make_cell($item['page'],$url);
    echo '<td>&nbsp;<a href="'.$url.'">Edit</a>&nbsp;|&nbsp;<a href="menu_edit.php?parent=',$item['id'].'&amp;lng='.$item['lng'].'">Add child</a>&nbsp;|&nbsp;<a href="menu_delete.php?id='.$item['id'].'&amp;lng='.$item['lng'].'">Delete</a>&nbsp;|&nbsp;<a href="'.make_url($item['page'],$item['lng']).'" target="_blank">View</a>&nbsp;</td></tr>'."\n";
    $listed_items++;

    add_childs($item['id'],$depth+1,$item['lng']);
}
mysql_free_result($id_result);
}


if (!isset($category)){
    $category='any';
    $lng='any';
}

echo '<table class="data"><tr><th>ID</th><th>Title</th><th>Category</th><th>Description</th><th>Language</th><th>Depth</th><th>Rank</th><th>Expand</th><th>Page</th><th>Actions</th></tr>'."\n";
$even=0;
$listed_items=0;
add_childs(0,0,$lng);
?>
</table>
<?php echo 'Listed menu items: '.$listed_items; ?>
<br />
<form action="menu_edit.php" method="get">
Create new menu item, in language: <?php language_edit($lng); ?>
<input type="submit" value=" Go " class="go" />
<input type="hidden" name="category" value="-1" />
</form>
<br />
<form action="menu_sync.php" method="get">
Synchronize menu items, in category <?php category_edit(-1,$lng=='any'?0:$lng,'category',TRUE); ?>
 from language: <?php language_edit($lng,FALSE,'lng_from'); ?>
 to language: <?php language_edit($lng,TRUE,'lng_to'); ?>
 overwrite existing items <input type="checkbox" name="overwrite" class="check" />
<input type="submit" value=" Go " class="go" />
</form>
<?php
require_once('./admin_footer.php');
?>
