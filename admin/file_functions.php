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
// $Id $

require_once('./functions.php');

function read_folder($path,&$dirs,&$files){
    $list=array();
    if ($dir = @opendir($path)) {
        rewinddir($dir);
        while ($file = readdir($dir)) {
            if ($file!='.')
                $list[]=$file;
        }
        closedir($dir);
        while (list ($key, $val) = each($list)){
            if (@is_dir($path.'/'.$val)){
                $dirs[]=$val;
            }else{
                $files[]=$val;
            }
        }
        return TRUE;
    }else{
        return FALSE;
    }
}

function add_file_info($dir,$list){
    $result=array();
    while (list ($key, $val) = each($list)){
        $result[$val]['filename']=$val;
        $result[$val]['size']=filesize($dir.'/'.$val);
        $result[$val]['hsize']=human_readable_size(filesize($dir.'/'.$val));
        $result[$val]['is_dir']=is_dir($dir.'/'.$val);
    }
    return $result;
}

function join_array(&$list,$new){
    while (list ($key, $val) = each($new)){
        $list[$key]=$val;
    }
}
?>
