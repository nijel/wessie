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

//Return content
function get_content(){
    global $page;

    $filename='UNKNOWN';
    $pre=TRUE;
    $code=TRUE;
    $html=TRUE;
    $highlight=FALSE;
    eval($page['param']);

    if (!file_exists($filename)) do_error(5,$filename);
    $fh=fopen($filename,'r');
    $content=fread($fh, filesize($filename));
    fclose($fh);
    if ($highlight) {
        ob_start();
        highlight_string ($content);
        $content = ob_get_contents();
        ob_end_clean();
    } else {
        if ($html) $content = htmlspecialchars($content);
        if ($code) $content = '<code>'.$content.'</code>';
        if ($pre) $content = '<pre>'.$content.'</pre>';
    }

    return $content;
}

//Return last change
function get_last_change(){
    global $page;

    $filename='UNKNOWN';
    eval($page['param']);

    return filemtime($filename);
}

?>
