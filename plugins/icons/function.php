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

function powered_mysql(){
    make_powered('mysql','http://www.mysql.com','powered by MySQL');
}

function powered_php(){
    make_powered('php','http://www.php.net','powered by php');
}

function powered_wessie(){
    global $wessie_url;
    make_powered('wessie',$wessie_url,'powered by wessie');
}

function make_powered($what,$url,$msg){
    global $base_path;
    echo '<a href="'.$url.'"><img src="' . $base_path . 'plugins/icons/img/powered_'.$what.'.png" align="middle" alt="'.$msg.'" width="88" height="31" border="0" /></a>';
}
?>
