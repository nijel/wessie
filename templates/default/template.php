<?
////////////////////////////////////////////////////////
// Template definition file for WSS - Web Site System //
//        Version 0.1   Released 6.1.2001             //
//        Copyright (c) 2001 Michal Cihar             //
////////////////////////////////////////////////////////

//File containing default template:
$template_data='./templates/default/template.html';

//Number of top pages to display
$top_pages_count=4;

//Format of title:
function title(){
        global $site_name,$category,$page;
        echo $site_name.' - ';
        eval('?'.'>'.$category['name'].'<?');
        echo ' - ';
        eval('?'.'>'.$page['name'].'<?');
}


//Format of upper menu items
function make_upper_menu_item($percent,$url,$name,$short,$description,$active){
        $result='<th align="center" valign="middle" width="'.$percent.'%"><a href="'.$url.'" title="'.$description.'"onMouseOut="window.status='."''".';return true" onMouseOver="window.status='."'".$description."'".';return true">';
        if ($active){$result.='<font color="white">'.$name.'</font></a></th>';}
        else {$result.=$name.'</a></th>';};
        return $result;
}
$upper_menu_divisor="\n";


//Format of top pages items:
function make_top_pages_item($url,$name,$category,$category_short,$description){
        $result='<a href="'.$url.'" title="'.$description.'"onMouseOut="window.status='."''".';return true" onMouseOver="window.status='."'".$description."'".';return true">';
        $result.=$name.' <font size=-3>('.$category_short.')</font></a>';
        return $result;
}
$top_pages_divisor="<br>\n";

//File dowload format:
function make_download($file,$group=array('count'=>-1)){
    global $msg_downloaded, $msg_times, $msg_downloads;
        $fn=$file['filename'];
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

                $grp=$group['count']==-1?'':'; '.$group['name'].' '.$msg_downloaded.' '.$group['count'].' '.$msg_times;
                return '<a href="'.'get.php?id='.$file['id'].'">'.basename($fn).'</a> ('.$size.'; '.$file['count'].' '.$msg_downloads.$grp.')';
}
}


//Left menu format
function make_menu_item($url,$name,$category,$category_short,$description,$active,$depth){
        if ($depth==0) {
                if ($active) $result='&nbsp;<span style="font-weight:bold;font-size:110%;">'.$name.'</span>';
                else $result='&nbsp;<a href="'.$url.'" style="font-weight:bold;font-size:110%;" title="'.$description.'" onMouseOut="window.status='."''".';return true" onMouseOver="window.status='."'$description'".';return true">'.$name.'</a>';
        } else{
                if ($active) $result='&nbsp;&nbsp;&nbsp;'.$name;
                else $result='&nbsp;&nbsp;&nbsp;<a href="'.$url.'" title="'.$description.'" onMouseOut="window.status='."''".';return true" onMouseOver="window.status='."'$description'".';return true">'.$name.'</a>';
        }
        while ($depth > 1){
                $result='&nbsp;&nbsp;'.$result;
                $depth--;
        }
        return $result;
}
$left_menu_divisor="<br>\n";


//Language choice format:
function make_language($url,$name){
        return '<a href="'.$url.'" target="_self" title="'.$name.'" onMouseOut="window.status='."''".';return true" onMouseOver="window.status='."'$name'".';return true">'.$name.'</a>';
}
$languages_divisor=' | ';


//Statistics format:
function make_stat_item($name,$width,$percent,$count){
        $bar_name='templates/default/img/bar';
        $bar_ext='png';
        $bar_height='16';
        $bar_width='7';
        return '<tr><td width=100><b>'.$name.'</b></td><td><img src="'.$bar_name.'_left.'.$bar_ext.'" height='.$bar_height.' width='.$bar_width.'><img src="'.$bar_name.'_middle.'.$bar_ext.'" height='.$bar_height.' width='.round($width).'><img src="'.$bar_name.'_right.'.$bar_ext.'" height='.$bar_height.' width='.$bar_width.'>&nbsp;&nbsp;</td><td>'.round($percent,2).'% ('.$count.')</td></tr>';
}
$stat_start='<table>';
$stat_end='</table>';
?>
