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

require_once('../config.php');
require_once('./auth.php');

header('Location: '.($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$SERVER_NAME.dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':'').'/login.php?failure=logout');

// Delete cookie
setcookie ('hash', '',time()-3600, dirname($SCRIPT_NAME).(substr(dirname($SCRIPT_NAME),-5)!='admin'?'admin':''),'', $admin_force_ssl || isset($HTTPS)); //delete cookie

// Delete authentication in db
if (!(mysql_query('DELETE FROM '.$db_prepend.$table_logged." where ip='".$user_info['ip']."' and user='".$HTTP_COOKIE_VARS['user']."' and hash='".$HTTP_COOKIE_VARS['hash']."'",$db_connection)))
        do_error(1,'DELETE FROM '.$db_prepend.$table_logged.': '.mysql_error());

?>