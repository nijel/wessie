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
$page_name='Menu';
require_once('./admin_header.php');
?>
<form action="menu.php" method="get">
Edit menu for <?php
language_edit(isset($lng)?$lng:-1,FALSE,'lng');
category_edit(isset($category)?$category:-1,isset($lng)?$lng:0,'category');
?>
<input type="submit" value=" Go " />
</form>
<?php

function add_childs($child_id,$depth){
global $site_name,$site_author,$site_author_email,$site_name,$site_home,$page_title,$category_name,$wessie_version,$wessie_author,$browser,$os,
        $wessie_author_email,$wessie_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
        $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;
global $db_connection,$table_menu,$table_page,$table_prepend_name,$lng,$category,$even;

if (!($id_result=(mysql_query('SELECT id,name,description,page,category,parent,expand,rank from '.$table_prepend_name.$table_menu.' where lng='.$lng.' and parent='.$child_id.' and category='.$category.' order by rank',$db_connection)))&&($child_id=0))
        do_error(1,'SELECT '.$table_prepend_name.$table_menu.': '.mysql_error());
while ($item = mysql_fetch_array ($id_result)){

        if (!($id2_result=mysql_query('SELECT name,description from '.$table_prepend_name.$table_page.' where lng='.$lng.' and id='.$item['page'].' limit 1',$db_connection)))
                do_error(1,'SELECT '.$table_prepend_name.$table_page.': '.mysql_error());
        $page=mysql_fetch_array($id2_result);
        mysql_free_result($id2_result);

        if ((!isset($item['name']))||($item['name']=='')) $name=$page['name'];
        else $name=$item['name'];

        if ((!isset($item['description']))||($item['description']=='')) $desc=$page['description'];
        else $desc=$item['description'];



        if ($even == 1) {
            echo '<tr bgcolor="#5f5f5f"><td>';
        } else {
            echo '<tr bgcolor="#8f8f8f"><td>';
        }
        $even = 1 - $even;

        for ($i=0; $i<$depth; $i++) echo '&nbsp;&nbsp;';

        eval('?' . '>' . $name . '</td><td>' . $desc );
        echo '</td><td>' . $depth;
        echo '</td><td>' . $item['rank'];
        echo '</td><td>' . $item['expand'];
        echo '</td><td><a href="menu_edit.php?id=',$item['page'].'&amp;lng='.$lng.'">Edit</a></td><td><a href="menu_edit.php?parent=',$item['page'].'&amp;lng='.$lng.'">Add child</a></td><td><a href="menu_delete.php?id=',$item['page'].'&amp;lng='.$lng.'">Delete</a></td><td><a href="'.make_url($item['page'],$lng).'" target="_blank">View</a></td></tr>'."\n";

//        eval('?'.'>'.make_menu_item(make_url($item['page'],$lng),$name,$category['name'],$category['short'],$desc,$item['page']==$id,$depth).'<?php ');
//        if (($item['expand']==1) || ($item['page']==$id) || in_array ($item['id'],$parents)){
            add_childs($item['id'],$depth+1);
        //}
}
mysql_free_result($id_result);
}


if (isset($category)){
    echo '<table border="0"><tr><th>Title</th><th>Description</th><th>Depth</th><th>Rank</th><th>Expand</th><th colspan="4">Action</th></tr>'."\n";
    $even=0;
    add_childs(0,0);
    echo '</table><br/>';
    echo '<a href="menu_edit.php?category=',$category.'&amp;lng='.$lng.'&amp;parent=0">Add root item</a>';
}

require_once('./admin_footer.php');
?>
