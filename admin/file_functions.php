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
        $result[$val]['atime']=fileatime($dir.'/'.$val);
        $result[$val]['ctime']=filectime($dir.'/'.$val);
        $result[$val]['mtime']=filemtime($dir.'/'.$val);
        $result[$val]['perms']=fileperms($dir.'/'.$val);
        $arr = posix_getpwuid(fileowner($dir.'/'.$val));
        $result[$val]['owner']=$arr['name'];
        $arr = posix_getgrgid(filegroup($dir.'/'.$val));
        $result[$val]['group']=$arr['name'];
        $result[$val]['r']=is_readable($dir.'/'.$val);
        $result[$val]['w']=is_writeable($dir.'/'.$val);
        $result[$val]['x']=is_executable($dir.'/'.$val);
        $result[$val]['l']=is_link($dir.'/'.$val);
        $result[$val]['type']=filetype($dir.'/'.$val);
    }
    return $result;
}

function join_array(&$list,$new){
    while (list ($key, $val) = each($new)){
        $list[$key]=$val;
    }
}

function perms2str($perms){
    $result = '';
    if ($perms & 0400) $result.='r';
    else $result.='-';
    if ($perms & 0200) $result.='w';
    else $result.='-';
    if ($perms & 0100)
        if ($perms & 04000) $result.='s';
        else $result.='x';
    else
        if ($perms & 04000) $result.='S';
        else $result.='-';

    if ($perms & 040) $result.='r';
    else $result.='-';
    if ($perms & 020) $result.='w';
    else $result.='-';
    if ($perms & 010)
        if ($perms & 02000) $result.='s';
        else $result.='x';
    else
        if ($perms & 02000) $result.='S';
        else $result.='-';

    if ($perms & 04) $result.='r';
    else $result.='-';
    if ($perms & 02) $result.='w';
    else $result.='-';
    if ($perms & 01)
        if ($perms & 01000) $result.='t';
        else $result.='x';
    else
        if ($perms & 01000) $result.='T';
        else $result.='-';
    return $result;
}

function find_file($pattern,$path,$regexp,$case){
    $wd = getcwd();
    $list=array();
    $scanned=array();
    $dirs=array(array('path'=>$path,'rel'=>''));
    while(count($dirs)>0){
        reset ($dirs);
        list ($key, $val) = each ($dirs);
        chdir ($val['path']);
        if (!in_array(getcwd(),$scanned)){
            $scanned[]=getcwd();
            if ($dir = @opendir($val['path'])) {
                rewinddir($dir);
                while ($file = readdir($dir)) {
                    if ($file != '.' && $file != '..') {
                        if ($regexp) {
                            if ($case) {
                                if (ereg($pattern,$file)) $list[] = $val['rel'].'/'.$file;
                            } else {
                                if (eregi($pattern,$file)) $list[] = $val['rel'].'/'.$file;
                            }
                        } else {
                            if ($case) {
                                if ( !(strstr($file,$pattern) === false)) $list[] = $val['rel'].'/'.$file;
                            } else {
                                if ( !(stristr($file,$pattern) === false)) $list[] = $val['rel'].'/'.$file;
                            }
                        }
                        if (is_dir($val['path'].'/'.$file))
                            $dirs[]=array('path'=>$val['path'].'/'.$file,'rel'=>$val['rel'].'/'.$file);
                    }
                }
                closedir($dir);
            }
        }
        unset ($dirs[$key]);
    }
    chdir($wd);
    return $list;
}
?>
