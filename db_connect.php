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

//load configuration
require_once('./config.php');
//error handling
require_once('./errors.php');
if (!isset($wessie_db_connect_php_loaded)){
    $wessie_db_connect_php_loaded=1;
    if ($db_persistent){
        if (!($db_connection=@mysql_pconnect($db_host,$db_user,$db_pass)))
            do_error(6,'pconnect');
    }else{
        if (!($db_connection=@mysql_connect($db_host,$db_user,$db_pass)))
            do_error(6,'connect');
    }
    if (!@mysql_select_db($db_name,$db_connection))
        do_error(6,'select_db');
}
?>
