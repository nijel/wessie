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
function log_error($what){
global $error_log_file;
$fh=fopen($error_log_file,'a');
fwrite($fh,'--- '. GMDate('D, d M Y H:i:s')." ---\n");
fwrite($fh,$what."\n");
fclose($fh);
}

function do_error($err_no,$err_nfo){
/*
1 - database
2 - language file
*/
global $SERVER_PROTOCOL, $site_name;
header ($SERVER_PROTOCOL.' 503 Service temporarily unavailable');
echo "<html><head><title>$site_name</title></head><body>
<h2> $site_name site is temporary unavailable</h2>
<h3> $SERVER_PROTOCOL 503 Service temporarily unavailable</h3>";
//<!--";
$err_msg="Internal error $err_no: ";
switch ($err_no){
	case 1:
		$err_msg.='Error occured while working with database!';
		break;
	case 2:
		$err_msg.='Error occured while loading language file!';
		break;
	case 3:
		$err_msg.='Error occured while loading template file!';
		break;
	case 4:
		$err_msg.='Error occured while loading data file!';
		break;
	default:
		$err_msg.='Unknown error';
}
$err_msg.="\nError info: $err_nfo\n";
echo $err_msg;
log_error($err_msg);
echo '<br>This site has currently some technical problems. Please try connecting later.<br>
There is no need to contact administrator, because he surely knows about this....
</body></html>';
exit;
}
?>
