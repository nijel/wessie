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
show_html_head('wessie:Help');
?>
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
    echo '<span class="error">Sorry, no help available for this topic.</span>';
}
?>
</body>
</html>
