<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
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
// $Id$
// CSS based template definition file for wessie

//File containing CSS template:
$template_data='./templates/styles/template.inc.php';

//Format of title:
function title(){
    global $site_name,$category,$page,$lng;
    echo $site_name[$lng].' - ';
    eval('?'.'>'.$category['name'].'<?php ');
    echo ' - ';
    eval('?'.'>'.$page['name'].'<?php ');
}


//Format of upper menu items
function make_upper_menu_item($percent,$url,$name,$short,$description,$active){
    $result='<th onclick="window.location.replace(\''.$url.'\')" onmouseover="highlight(this,\'#FFEEBB\');" onmouseout="unhighlight(this);" width="'.$percent.'"'.($active?' class="active"':'').'><a href="'.$url.'" title="'.$description.'">';
    $result.=$name.'</a></th>';
    return $result;
}

$upper_menu_divisor="\n";


//Format of top pages items:
function make_top_pages_item($url,$name,$category,$category_short,$description){
    $result='<a href="'.$url.'" title="'.$description.'">';
    $result.=$name.' <font size="-3">('.$category_short.')</font></a>';
    return $result;
}

$top_pages_divisor="<br />\n";

//File dowload format:
function make_download($file,$group=array('count'=>-1)){
    global $msg_downloaded, $msg_times, $msg_downloads,$DOCUMENT_ROOT,$msg_unknown_size,$base_path;
    $grp=$group['count']==-1?'':'; '.$group['name'].' '.$msg_downloaded.' '.$group['count'].' '.$msg_times;
    if ($file['remote']==1){
        return '<a href="'.$base_path.'get.php/'.$file['id'].'/'.basename($file['filename']).'">'.basename($file['filename']).'</a> ('.$msg_unknown_size.$file['count'].' '.$msg_downloads.$grp.')';
    }else{
        $fn=$DOCUMENT_ROOT.'/'.$file['filename'];
        if (!file_exists($fn)){
            log_error("ERROR: File $fn (id:".$file['id'].') not found!');
            return $fn;
        }else{
            $size_b=filesize($fn);
            $size_kb=round($size_b*10/1024)/10;
            $size_mb=round($size_kb*10/1024)/10;
            $size_gb=round($size_mb*10/1024)/10;

            if ($size_b<1024) {$size=$size_b.' B';}
            elseif ($size_b<1048576) {$size=$size_kb.' kB';}
            elseif ($size_b<1073741824) {$size=$size_mb.' MB';}
            else {$size=$size_gb.' GB';}

            return '<a href="'.$base_path.'get.php/'.$file['id'].'/'.basename($file['filename']).'">'.basename($fn).'</a> ('.$size.'; '.$file['count'].' '.$msg_downloads.$grp.')';
        }
    }
}


//Left menu format
function make_menu_item($url,$name,$category,$category_short,$description,$active,$depth,$is_parent){
    if ($depth == 0){
        $result = '<span class="root">';
    } else {
        $result = '';
    }
    if ($is_parent){
        $result .= '<span class="parent">';
    }
    if ($active) {
        $result .= '<span class="active">';
        $text = $name;
    } else {
        $result .= '<span class="inactive">';
        $text = '<a href="'.$url.'" title="'.$description.'">'.$name.'</a>';
    }
    if ($depth == 0){
        $text .= '</span></span>';
    } else {
        $text .= '</span>';
    }
    if ($is_parent){
        $text .= '</span>';
    }
    $result .= '&nbsp;';
    while ($depth > 0){
        $result .= '&nbsp;&nbsp;';
        $depth--;
    }
    return $result . $text;
}

$left_menu_divisor="<br />\n";


//Language choice format:
function make_language($url,$id){
    global $languages, $base_path;
    return '<a href="'.$url.'" target="_self" title="'.$languages[$id]['name'].'"><img src="'.$base_path.$languages[$id]['image'].'" alt="'.$languages[$id]['short'].'" align="middle" border="0" />'.$languages[$id]['name'].'</a>';
}

$languages_divisor=' | ';
//$languages_divisor="<br />\n";


//Statistics format:
function make_stat_item($name,$width,$percent,$count){
    global $base_path;
    $bar_name=$base_path.'templates/default/img/bar';
    $bar_ext='png';
    $bar_height='16';
    $bar_width='7';
    return '<tr><td width="100"><b>'.$name.'</b></td><td><img alt="" src="'.$bar_name.'_left.'.$bar_ext.'" height="'.$bar_height.'" width="'.$bar_width.'" border="0" /><img alt="" src="'.$bar_name.'_middle.'.$bar_ext.'" height="'.$bar_height.'" width="'.round($width).'" border="0" /><img alt="" src="'.$bar_name.'_right.'.$bar_ext.'" height="'.$bar_height.'" width="'.$bar_width.'" border="0" />&nbsp;&nbsp;</td><td>'.round($percent,2).'% ('.$count.')</td></tr>';
}

$stat_start='<table>';
$stat_end='</table>';

?>
