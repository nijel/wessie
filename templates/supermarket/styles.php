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
$remove_path='templates/styles/';
require_once('../../init.php');
?>

body {
	background-color: #DDDDDD;
	padding: 0px;
	margin: 0px;
}

div.topbox {
	position: absolute;
	left: 0px;
	top: 0px;
	right: 0px;
	width: 100%;
	z-index: 10;
}

div.top {
	border: 3px solid #000000;
	background-color: #0000a0;
	color: #FFFFFF;
	padding: 2px;
	margin: 20px;
	font-size: x-large;
	font-weight: bolder;
}

div.leftbox {
	position: absolute;
	z-index: 8; /* this MUST be above bodybox and undet topbox */
	left: 0px;
	top: 0px;
	width: 220px;
}

div.left {
	margin: 20px 0px 0px 20px;
	border: 3px solid #000000;
	background-color: #FFD14A;
	color: #000000;
	font-size: larger:
	font-weight: bolder;
	padding: 3.5em 2px 1em 2px
}

div.bodybox {
	position: absolute;
	left: 0px;
	top: 0px;
	right: 0px;
	width: 100%;
	z-index: 5;
}

div.body {
	margin: 20px 20px 20px 217px;
	border: 3px solid #000000;
	background-color: #AFB3B6;
	font-size: larger:
	font-weight: bolder;
	color: #000000;
	padding: 2.5em 5px 5px 5px
}

div.docinfo {
	margin: 5px 20px 5px 217px;
	font-size: smaller;
	color: #000000;
	text-align: center;
}

div.body p {
	margin-top: 0px;
}

div.body p:first-line {
	padding-left: 15px;
}

/* left menu */
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


/* links */
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

img {
    border: none;
}
