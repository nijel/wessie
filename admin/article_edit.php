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

$page_name='Article:Edit';
require_once('./admin_header.php');

if (!$id_result=mysql_query(
'SELECT last_change, page, '.$table_prepend_name.$table_article.'.lng as lng, id, name, description, count, category, content '.
' from '.$table_prepend_name.$table_article.','.$table_prepend_name.$table_page.
' where id=page and '.$table_prepend_name.$table_article.'.lng='.$table_prepend_name.$table_page.'.lng and lng='.$lng.' and id='.$id))
    do_error(1,'SELECT '.$table_prepend_name.$table_article.','.$table_prepend_name.$table_page.': '.mysql_error());
<form action="article_edit.php" method="POST">
<input type="text" name="name">
  <textarea name="content" cols="40" rows="10"></textarea>
</form>
require_once('./admin_footer.php');
?>