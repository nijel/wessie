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

//Load article info from database
if (!($id_result=mysql_query('SELECT UNIX_TIMESTAMP(last_change) as last_change, content from '.$db_prepend.$table_article.' where page='.$id.' and lng='.$lng.' limit 1',$db_connection)))
    do_error(1,'SELECT '.$db_prepend.$table_article.': '.mysql_error());
$article=mysql_fetch_array($id_result);
mysql_free_result($id_result);

//Return content
function get_content(){
    global $article;
    return $article['content'];
}

//Return last change
function get_last_change(){
    global $article;
    return $article['last_change'];
}


?>
