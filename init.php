<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// / wessie - web site system                                             |
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
$wessie_version_only='0.2 beta';
$wessie_version='wessie '.$wessie_version_only;
$wessie_author='Michal Cihar';
$wessie_author_email='cihar@email.cz';
$wessie_url='http://cicom.kgb.cz';
$search_url='search.php';
$search_param='q';

//nasty hack to be XHTML compliant
$SERVER_SIGNATURE = strtr($SERVER_SIGNATURE, array('ADDRESS'=>'address'));

// extract parameter value, when specified "seacrh engine friendly"
// (index.php/param1=value1/param2=value2

if (isset($PATH_INFO) && (!empty($PATH_INFO))){
    $info_vars = split('/',$PATH_INFO);
    while ($item = each ($info_vars)) {
        $current_var = split('=',$item['value']);
        if (isset($current_var[0]) && isset($current_var[1])){
            $current_var[1] = urldecode($current_var[1]);
            if (ereg('^[0-9]*$',$current_var[1])){
                eval('$'.$current_var[0]."=".$current_var[1].';');
            } else {
                eval('$'.$current_var[0]."='".$current_var[1]."';");
            }
        }
    }
    unset($info_vars);
}


// obtain base path for current file

if (isset($SCRIPT_NAME)){
    $base_path = strrev(strstr(strrev($SCRIPT_NAME),'/'));
} else {
    $base_path = '/';
}
?>