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
require_once('./auth.php');
require_once('./functions.php');
Header('Content-Type: text/html; charset='.$admin_charset);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                  "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $admin_charset?>" />
    <title>wessie:Help</title>
    <meta name="Author" content="<?php echo $wessie_author?>" />
    <meta name="Generator" content="<?php echo $wessie_version.', Copyright (C) 2001 '.$wessie_author?>" />
    <link rel="home" href="<?php echo $site_home?>" />
    <link rel="copyright" href="mailto:<?php echo $wessie_author?>" />
    <link rel="StyleSheet" href="./admin.css" type="text/css" media="screen" />
    <script language="JavaScript" type="text/javascript" src="./admin.js"></script>
</head>
<body class="help">
<div class="close"><a href="javascript:window.close()" onclick="window.close()">Close</a></div>
<?php
if (!isset($QUERY_STRING)){
    echo '<span class="error">No help topic!</span>';
}elseif ($QUERY_STRING==''){
    echo '<span class="error">No help topic!</span>';
}elseif ($QUERY_STRING=='plugin.php'){
    echo 'plugin...';
}else{
    echo '<span class="error">Sorry, no help for this topic.</span>';
}
?>
</body>
</html>
