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
include_once('./plugins/common.php');

if (addPageType('article')) {

    echo 'Creating table for storing articles...';
    if (!isset($table_article)) {
        echo '$table_article was not set, assuming default...';
        $table_article='article';
        if (!config_set_option('\$table_article','$table_article = '."'article';\n",'//##/TABLES##')){
            echo "\n".'<div class="error">failed setting default value in config!</div>';
            $error .= 'Failed setting default value in config!<br/>';
        }
    }
    if ($error==''){
        if (!$id_result=mysql_query("CREATE TABLE $db_prepend$table_article (
        content text NOT NULL,
        last_change timestamp NOT NULL,
        page smallint unsigned NOT NULL default '0',
        lng tinyint unsigned NOT NULL default '0',
        PRIMARY KEY  (page,lng))",$db_connection)) {
            echo "\n".'<div class="error">Failed creating new table!</div>';
            $error .= 'Failed creating new table!<br/>';
        } else {
            echo "DONE\n";
        }
    }
}
?>
