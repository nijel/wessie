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

//load configuration
require_once('./config.php');
//initialize variables from $PATH_INFO and set some wessie specific variables
require_once('./init.php');
//error handling
require_once('./errors.php');
//connect to database
require_once('./db_connect.php');

if (!($id_result=mysql_query("SELECT * from $db_prepend$table_download where id=$id limit 1",$db_connection)))
    do_error(1,'SELECT '.$db_prepend.$table_download.'---'."SELECT * from $db_prepend$table_download where id=$id limit 1");
$file=mysql_fetch_array($id_result);
mysql_free_result($id_result);

if ($file['grp']!=0){
    if (!(mysql_query("UPDATE $db_prepend$table_download_group set count=count+1 where id=".$file['grp'],$db_connection)))
        do_error(1,'UPDATE '.$db_prepend.$table_download_group.'---'."UPDATE $db_prepend$table_download_group set count=count+1 where id=".$file['grp']);
}
if (!(mysql_query("UPDATE $db_prepend$table_download set count=count+1 where id=$id",$db_connection)))
    do_error(1,'UPDATE '.$db_prepend.$table_download.'---'."UPDATE $db_prepend$table_download set count=count+1 where id=$id");
if ($file['remote']==1){
    header('Location: '.$file['filename']);
}else{
//    header('Location: '.$base_url.$file['filename']);
    header('Location: http://'.$SERVER_NAME.$file['filename']);
}
?>
