<?php
/* vim: set expandtab tabstop=4 shiftwidth=4:
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
// $Id$ */
Header('Content-Type: text/css');
//load configuration
require_once('../../config.php');
//initialize variables from $PATH_INFO and set some wessie specific variables
$remove_path='templates/styles/';
require_once('../../init.php');
?>

body {
    color: #000000;
    background-color: #FFDDAA;
    background-image: url("<?php echo $base_path.$site_logo;?>");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: 5px 5px;
    margin-left: <?php echo $site_logo_width+10; ?>px;
    font-family: sans-serif;
}

img {
    border: none;
}

a {
    text-decoration: none;
}
a:link {
    color: #0000FF;
}
a:active {
    color: #CCFF66;
}
a:visited {
    color: #0000CC;
}
a:hover {
    text-decoration: underline;
}

table#upper_menu {
    border: none;
    width: 100%;
    text-align: center;
    padding: 1px 1px 0px 1px;
    margin: 0px 0px 0px 0px;
}
table#upper_menu a:hover {
    text-decoration: none;
}
table#upper_menu th {
    padding: 2px 10px 2px 10px;
    margin: 1px 1px 0px 1px;
    border: 1px solid #000000;
    border-bottom: 0px none;
    cursor: hand;
}
table#upper_menu th.active {
    background-color: #FFCC99;
    font-weight: bold;
    border-left-width: 2px;
    border-right-width: 2px;
    border-top-width: 2px;
}

#advert {
    display: none;
}

#top_pages{
    display: none;
}

#everything {
    border-right: 1px solid #000000;
    border-bottom: 1px solid #000000;
    border-left: 1px solid #000000;
    border-top: 1px solid #000000;
    margin: 0px 0px 0px 0px;
    padding: 2px 5px 5px 5px;
    height: 100%;
}

#left_menu{
    clear:left;
    float:left;
    width: 14em;
    margin-bottom: 3em;
}

span.root{
    font-size: large;
    padding-left: 1en;
}

span.parent a{
    color: #000000;
    font-weight: bolder;
}

span.inactive{
    font-weight: normal;
}

span.active{
    font-weight: bolder;
}

#languages{
    clear:left;
    float:left;
    width: 14em;
    margin-bottom: 10px;
}

#languages img{
    vertical-align: middle;
}

#search{
    clear:left;
    float:left;
    margin-bottom: 10px;
    width: 14em;
}

#content,#special{
    margin-left: 15em;
    position: relative;
    bottom: 0px;
    left: 0px;
    z-index: 1;
}

#content{
    margin-bottom: 20px;
}

#counter,#last_change,#copyright{
    font-size: xx-small;
    margin-bottom: 10px;
    position: relative;
    left: 0px;
    line-height:1em;
    margin-bottom: 0px;
    margin-top: 0px;
}

#copyright{
    text-align: right;
    z-index: 5;
    top: 0em;
}

#counter{
    text-align: left;
    z-index: 6;
    top: +2em;
}

#last_change{
    text-align: center;
    z-index: 7;
    top: +1em;
}
