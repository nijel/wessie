<?php
/* vim: set expandtab tabstop=4 shiftwidth=4:
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
// $Id$ */
Header('Content-Type: text/css');
// allow to becached for one week
Header("Expires: " . GMDate("D, d M Y H:i:s",time()+604800) . " GMT");
//load configuration
require_once('../../config.php');
//initialize variables from $PATH_INFO and set some wessie specific variables
$remove_path='templates/alcatel/';
require_once('../../init.php');
?>

body {
    background-color: #e7ebf4;
    background-image: url(<?php echo $base_path;?>templates/alcatel/img/back.png);
    background-repeat: repeat-y;
    margin: 0px;
    padding: 0px;
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

div.phones {
    position: absolute;
    left: 0px;
    top: 10px;
    z-index: 0;
}

div.title {
    left: 150px;
    position: absolute;
    top: 20px;
    z-index: 10;
}

div.text {
    position:absolute;
    top: 60px;
    left: 170px;
    right: 10px;
    z-index: 20;
}

div.left {
    position:absolute;
    top: 160px;
    left: 10px;
    width: 140px;
}

div.leftbox {
    width: 100%;
    border: 1px dotted black;
    background-color: #f0f4ff;
    margin-top: 10px;
    margin-bottom: 10px;
    padding: 3px;
}

div#searchbox {
    text-align: center;
}

form.search {
    margin: 0px;
    padding: 0px;
}

div.powered {
    width: 100%;
    text-align: center;
    margin-top: 10px;
    margin-bottom: 10px;
}

div.docinfo {
    margin-top: 20px;
    text-align: center;
    font-size: x-small;
}

span.root{
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

input.search_text {
    width: 140px;
}

input.search_button {
    width: 70px;
}