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

$pageTypesInit=FALSE;
$pageTypes=array();

function readPageTypes(){
    global $table_prepend_name,$table_page,$db_connection,$error,$pageTypesInit,$pageTypes;
    echo 'Reading page types...';
    if (!($id_result=mysql_query('DESCRIBE '.$table_prepend_name.$table_page,$db_connection))){
        echo "\n".'<div class="error">Failed MySQL query: '.mysql_error().'</div>';
        $error .= 'Failed MySQL query!<br/>';
        return FALSE;
    }
    while($item=mysql_fetch_array($id_result))
        if ($item['Field'] == 'type') {
            $enum = $item['Type'];
            break;
        }
    mysql_free_result($id_result);
    if (!isset($enum)) {
        echo "\n".'<div class="error">Failed reading current article types!</div>';
        $error .= 'Failed reading current article types!<br/>';
        return FALSE;
    }
    echo 'parsing...';
    $enum      = str_replace('enum(', '', $enum);
    $enum        = ereg_replace('\)$', '', $enum);
    $enum        = explode("','", substr($enum, 1, -1));
    $enum_cnt    = count($enum);

    echo 'current page types: ';
    $del = '';
    while (list($key,$val) = each($enum)) {
        echo $del.$val;
        $del = ', ';
    }

    $pageTypesInit = TRUE;
    $pageTypes = $enum;
    echo "...Done\n";
    return TRUE;
}

function savePageTypes(){
    global $table_prepend_name,$table_page,$db_connection,$error,$pageTypesInit,$pageTypes;
    echo 'Saving page types...';
    $text='';
    $del='';
    reset($pageTypes);
    while (list($key,$val) = each($pageTypes)) {
        $text .= $del."'".$val."'";
        $del = ', ';
    }
    echo $text;

    if (!mysql_query('ALTER TABLE '.$table_prepend_name.$table_page.' CHANGE type type ENUM('.$text.')',$db_connection)){
        echo "\n".'<div class="error">Failed MySQL query: '.mysql_error().'</div>';
        $error .= 'Failed MySQL query!<br/>';
        return FALSE;
    }
    echo "...Done\n";
    return TRUE;
}

function addPageType($name){
    global $pageTypesInit,$pageTypes,$error;
    if (!$pageTypesInit)
        if (!readPageTypes())
            return FALSE;
    echo 'Trying to install new page type...';

    if (in_array($name,$pageTypes)){
        echo "\n".'<div class="error">This type is already installed!</div>';
        $error .= 'This type is already installed!<br/>';
        return FALSE;
    }

    $pageTypes[] = $name;

    echo "added\n";
    if (!savePageTypes())
        return FALSE;
}

function delPageType($name){
    global $pageTypesInit,$pageTypes,$error;
    if (!$pageTypesInit)
        if (!readPageTypes())
            return FALSE;

    echo 'Trying to uninstall page type...';

    $key = array_search($name,$pageTypes);
    if ($key=== FALSE||$key==''){
        echo "\n".'<div class="error">This type is not installed!</div>';
        $error .= 'This type is not installed!<br/>';
        return FALSE;
    }

    unset($pageTypes[$key]);

    echo 'removed...current page types: ';
    $del = '';
    reset($pageTypes);
    while (list($key,$val) = each($pageTypes)) {
        echo $del.$val;
        $del = ', ';
    }
    echo "\n";
    if (!savePageTypes())
        return FALSE;
}
?>
