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
// Main executed script

error_reporting (E_ALL);
//BEFORE publishing check all TEMPORARY words!

//load configuration
require_once('./config.php');
//initialize variables from $PATH_INFO and set some wessie specific variables
require_once('./init.php');
//error handling
require_once('./errors.php');
//connect to database
require_once('./db_connect.php');
//client browser and os detection
require_once('./browser.php');


//if no language was explicitly defined, try to detect it
if (!isset($lng)){
    if (isset($HTTP_COOKIE_VARS[$cookie_lang])){
            $lng=$HTTP_COOKIE_VARS[$cookie_lang];
        $lang=$languages[$lng];
        eval('$lang_file_name="'.$lang_file.'";');
    }
    if ((!isset($lng)) || (!file_exists($lang_file_name))){
        if (isset($HTTP_ACCEPT_LANGUAGE)){
            $lng=-1;
            $wanted_languages=array();
            $wanted_languages=Explode(",",$HTTP_ACCEPT_LANGUAGE);
            for($i=0;$i<count($wanted_languages);$i++){
                $curr_lang=Explode(";",$wanted_languages[$i]);
                $curr_lang=$curr_lang[0]; //this ignores q=0.5
                if (isset($lang_alias[$curr_lang])){
                    $lng=$lang_alias[$curr_lang];
                    $lang=$languages[$lng];
                    eval('$lang_file_name="'.$lang_file.'";');
                    if (($lng!=-1)&&(file_exists($lang_file_name))) break;
                }
            }
            if (($lng==-1)||(!file_exists($lang_file_name))) $lng=$default_lang;
        }else{
            $lng=$default_lang;
            $lang=$languages[$lng];
            eval('$lang_file_name="'.$lang_file.'";');
        }
    }
}else{
    if (((int)$lng == 0) && ($lng != '0') && isset($lang_alias[$lng])){
        $lng=$lang_alias[$lng];
    }
    @$lang=$languages[$lng];
    eval('$lang_file_name="'.$lang_file.'";');
}

//language file
if (!file_exists($lang_file_name)) do_error(2,'file="'.$lang_file_name.'"; lng="'.$lng.'"');
require_once($lang_file_name);

//send headers - content type and refuse caching
Header('Pragma: no-cache');
Header("Expires: " . GMDate("D, d M Y H:i:s") . " GMT");
Header('Content-Type: text/html; charset='.$charset);


//if no id specified, go to default page
if (!isset($id)){
    $id=$lang_main_page[$lng];
}

//read cookie and determine whether it is new user
$increase_count=false;
if (isset($HTTP_COOKIE_VARS[$cookie_count])){
    $visited_pages=explode('|',$HTTP_COOKIE_VARS[$cookie_count]);
    if (!in_array($id,$visited_pages)) {
        $visited_pages[]=$id;
        $increase_count=true;
    }
    $cookie_to_set=implode('|',$visited_pages);
}else{
    $cookie_to_set=$id;
    $increase_count=true;
}

//set cookies (with visited pages and selected language)
setcookie($cookie_count,$cookie_to_set,time()+$session_time);
setcookie($cookie_lang,$lng,time()+$lang_time);

//read page
if (!($id_result=mysql_query('SELECT * from '.$table_prepend_name.$table_page.' where id='.$id.' and lng='.$lng.' limit 1',$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_page.': '.mysql_error());
$page=mysql_fetch_array($id_result);
if (!isset($page['id'])){
    log_error('Unknown page: '.$id);
    do_error(3,'id="'.$id.'"; lng="'.$lng.'"');
    bye();
}
mysql_free_result($id_result);

//generate statistics
// true in following line is TEMPORARY (TODO - just for searching)
if (true||$increase_count){
    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_page.' set count=count+1 where id='.$id.' and lng='.$lng.' limit 1',$db_connection)))
        do_error(1,'UPDATE '.$table_prepend_name.$table_page.': '.mysql_error());

    $dow=date('w');
    if ($dow==0) $dow=7;

    $wno=floor((time()-$site_started)/604800); // 604800 is number of seconds per week
    if($wno<10) $wno='000'.(string)$wno;
    elseif($wno<100) $wno='00'.(string)$wno;
    elseif($wno<1000) $wno='0'.(string)$wno;
    else $wno=(string)$wno;

    /* TODO: This needs some optimalisations!!! - shouldn't be executed every time, just once a week....*/
    if (!(mysql_query('INSERT ignore '.$table_prepend_name.$table_stat." set count=1, category='week_no', item='$wno'",$db_connection)))
        do_error(1,'INSERT ignore '.$table_prepend_name.$table_stat.': '.mysql_error());

    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_stat." set count=count+1 where (category='time' and item='".strftime('%H')."') or (category='dow' and item='$dow') or (category='week_no' and item='$wno') or (category='os' and item='$os') or (category='browser' and item='$browser') or(category='lang' and item='$lng') or (category='total' and item='hits')",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_stat.': '.mysql_error());
}

//read all categories (TODO: this should be cached)
if (!($id_result=mysql_query('SELECT * from '.$table_prepend_name.$table_category.' where lng='.$lng.' order by '.$category_order,$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_category.': '.mysql_error());

$categories=array();
while ($item = mysql_fetch_array ($id_result)) {
    $categories[$item['id']]=$item;
}

mysql_free_result($id_result);


//read category
if (!isset ( $categories[$page['category']] ) ) {
    log_error('Unknown category: '.$page['category']);
    header('Location: http://'.$SERVER_NAME.$base_path.'main.php');
    bye();
} else {
    $category=$categories[$page['category']];
}

//template file
eval('$template_file_name="'.$template_file.'";');
require_once($template_file_name);

eval('$template_file_name="'.$template_data.'";');
if (!file_exists($template_file_name)) do_error(4,$template_file_name);
$fh=fopen($template_file_name,'r');
$template=fread($fh, filesize($template_file_name));
fclose($fh);

//read content
if (file_exists('./plugins/'.$page['type'].'/page.php')){
    require_once('./plugins/'.$page['type'].'/page.php');
}else{
    do_error(7,$page['type']);
}

$content = get_content();
$last_change = get_last_change();

//functions:

function make_url($id,$lng){
    global $base_path,$languages;
    return $base_path.'main.php/page'.$id.'.'.$languages[$lng].'.html';
}

function download($which){
global $table_prepend_name,$table_download,$table_download_group,$db_connection;
    if (!($id_result=mysql_query("SELECT * from $table_prepend_name$table_download where id=$which limit 1",$db_connection)))
        do_error(1,'SELECT '.$table_prepend_name.$table_download.'---'."SELECT * from $table_prepend_name$table_download where id=$which limit 1");
    $file=mysql_fetch_array($id_result);
    mysql_free_result($id_result);

    if ($file['grp']!=0){
        if (!($id_result=mysql_query("SELECT * from $table_prepend_name$table_download_group where id=".$file['grp']." limit 1",$db_connection)))
            do_error(1,'SELECT '.$table_prepend_name.$table_download_group.'---'."SELECT * from $table_prepend_name$table_download_group where id=".$file['grp']." limit 1");
        $group=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
        echo make_download($file,$group);
    }else{
        echo make_download($file);
    }
}

function upper_menu(){
        global $site_name,$lng,$site_author,$site_author_email,$site_home,$page_title,$category_name,$wessie_version,$wessie_author,$browser,$os,
                $wessie_author_email,$wessie_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
                $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;

        global $table_prepend_name,$table_category,$lng,$db_connection,$upper_menu_divisor,$page,$categories;

        $percent=(string)(int)100/count($categories).'%';
        $was_item=false;
        while ($item = each ($categories)) {
            if ($was_item) {echo $upper_menu_divisor;}
            $was_item=true;
            eval('?'.'>'.make_upper_menu_item($percent,make_url($item['value']['page'],$lng),$item['value']['name'],$item['value']['short'],$item['value']['description'],$page['category']==$item['value']['id']).'<?php ');
        }
}

function top_pages(){
        global $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,$page_title,$category_name,$wessie_version,$wessie_author,$browser,$os,
                $wessie_author_email,$wessie_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
                $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;

        global $table_prepend_name,$table_category,$table_page,$lng,$db_connection,$top_pages_divisor,$top_pages_count,$categories;;

        $id_result=mysql_query('SELECT id,name,description,category from '.$table_prepend_name.$table_page.' where lng='.$lng.' order by count desc limit '.$top_pages_count) or
            do_error(1,'SELECT '.$table_prepend_name.$table_page.': '.mysql_error());

        $was_item=false;
        while ($item = mysql_fetch_array ($id_result)) {
            if ($was_item) {echo $top_pages_divisor;}
            $was_item=true;
            $item_cat=$categories[$item['category']];
            eval('?'.'>'.make_top_pages_item(make_url($item['id'],$lng),$item['name'],$item_cat['name'],$item_cat['short'],$item['description']).'<?php ');
        }
        mysql_free_result($id_result);
}

function advert(){
    global $use_adverts,$table_prepend_name,$table_advert,$db_connection;
    if ($use_adverts){
        $id_result=mysql_query('SELECT id from '.$table_prepend_name.$table_advert.'',$db_connection) or
            do_error(1,'SELECT id from '.$table_prepend_name.$table_advert);
        $adverts=mysql_num_rows($id_result);
        mysql_free_result($id_result);

        if($adverts>0){
            srand ((double) microtime() * 1000000);
            $advert_id=($adverts==1)?0:rand(0,$adverts-1);

            $id_result=mysql_query("SELECT code from $table_prepend_name$table_advert limit $advert_id,1",$db_connection) or
                do_error(1,'SELECT '.$table_prepend_name.$table_advert);
            $advert=mysql_fetch_array($id_result);
            mysql_free_result($id_result);
            echo $advert['code'];
        }else{
            echo '&nbsp;';
        }
    }else{
        echo '&nbsp;';
    }
}

function left_menu(){

    function add_childs($child_id,$depth,$parents){
        global $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,$page_title,$category_name,$wessie_version,$wessie_author,$browser,$os,
            $wessie_author_email,$wessie_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
            $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;
        global $first_item,$left_menu_divisor,$id,$category,$lng,$menu_item_cache,$menu_parent_cache,$menu_page_cache;

        while (list ($key, $val) = each($menu_parent_cache[$child_id])){
            if (!$first_item) echo $left_menu_divisor;
            else $first_item=false;

            eval('?'.'>'.make_menu_item(make_url($menu_item_cache[$val]['page'],$lng),$menu_item_cache[$val]['name'],$category['name'],$category['short'],$menu_item_cache[$val]['description'],$menu_item_cache[$val]['page']==$id,$depth).'<?php ');

            //do we have any childs and should we list them?
            if (isset($menu_parent_cache[$menu_item_cache[$val]['id']]) && (($menu_item_cache[$val]['expand']==1) || ($menu_item_cache[$val]['page']==$id) || in_array ($menu_item_cache[$val]['id'],$parents))){
                add_childs($menu_item_cache[$val]['id'],$depth+1,$parents);
            }
        }
    }

    global $lng,$id,$table_prepend_name,$table_menu,$table_page,$db_connection,$category;
    //cache must bu global, otherwise it would not be accessible by add_childs
    global $menu_item_cache,$menu_parent_cache,$menu_page_cache;

    // cache alle menu items for current category and then print from array

    //cache for whole menu items
    $menu_item_cache=array();
    //cache for listing by parent
    $menu_parent_cache=array();
    //cache for searching by page
    $menu_page_cache=array();

    if (!($id_result=mysql_query("SELECT
    $table_prepend_name$table_menu.id as id,
    $table_prepend_name$table_menu.page as page,
    if(strcmp($table_prepend_name$table_menu.name,''),$table_prepend_name$table_menu.name,$table_prepend_name$table_page.name) as name,
    if(strcmp($table_prepend_name$table_menu.description,''),$table_prepend_name$table_menu.description,$table_prepend_name$table_page.description) as description,
    $table_prepend_name$table_menu.category as category,
    $table_prepend_name$table_menu.parent as parent,
    $table_prepend_name$table_menu.expand as expand,
    $table_prepend_name$table_menu.rank as rank
    from $table_prepend_name$table_menu,$table_prepend_name$table_page
    where menu.category=${category['id']} and menu.lng=$lng and menu.page=page.id and page.lng=$lng order by rank",$db_connection)))
        do_error(1,'SELECT '.$table_prepend_name.$table_menu.': '.mysql_error());

    //fill cache items
    while ($item = mysql_fetch_array ($id_result)){
        $menu_page_cache[$item['page']]=$item['id'];
        $menu_parent_cache[$item['parent']][]=$item['id'];
        $menu_item_cache[$item['id']]=$item;
    }
    mysql_free_result($id_result);

    $first_item=true;
    // Read parents of active page to know which path of menu structure should we enable
    $parents=array();
    $parent=-1;
    if (isset($menu_page_cache[$id])){
        $parent=$menu_item_cache[$menu_page_cache[$id]]['parent'];
        while ($parent!=0){
            $parents[]=$parent;
            $parent=$menu_item_cache[$parent]['parent'];
        }
    }

    //Add childs to root
    add_childs(0,0,$parents);
}

function content(){
global $content,
    $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,
    $page_title,$category_name,
    $browser,$os,
    $wessie_version,$wessie_author,$wessie_author_email,$wessie_url,
    $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path,
    $allow_content_eval,$page_plugins_options,$page,$lng;

    if ($allow_content_eval && $page_plugins_options[$page['type']]['eval']){
        eval('?'.'>'.$content.'<?php ');
    }else{
        echo $content;
    }
}

function counter(){
global $msg_counter,$page;
$count=$page['count'];
eval('?'.'>'.$msg_counter.'<?php ');
}

function copyright(){global $copyright,$lng;echo $copyright[$lng];}

function page_title(){
global $page,
    $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,
    $page_title,$category_name,
    $browser,$os,
    $wessie_version,$wessie_author,$wessie_author_email,$wessie_url,
    $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;

eval('?'.'>'.$page['name'].'<?php ');
}

function category_name(){
global $category,
    $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,
    $page_title,$category_name,
    $browser,$os,
    $wessie_version,$wessie_author,$wessie_author_email,$wessie_url,
    $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;

eval('?'.'>'.$category['name'].'<?php ');
}

function keywords(){
global $page,
    $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,
    $page_title,$category_name,
    $wessie_version,$wessie_author,$wessie_author_email,$wessie_url,
    $browser,$os,
    $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;

eval('?'.'>'.$page['keywords'].'<?php ');
}

function description(){
global $page,
    $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,
    $page_title,$category_name,
    $browser,$os,
    $wessie_version,$wessie_author,$wessie_author_email,$wessie_url,
    $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;

eval('?'.'>'.$page['description'].'<?php ');
}

function search_hidden_options(){
    echo '';
}

function languages(){
global $languages,$lang_name,$lang_main_page,$languages_divisor,$id,
    $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,
    $page_title,$category_name,
    $browser,$os,
    $wessie_version,$wessie_author,$wessie_author_email,$wessie_url,
    $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;

if (count($languages)==1){
    $result='&nbsp;'; // if there is only one language it's useles to offer it
}else{
    $result='';
    for($i=0;$i<count($languages);$i++){
        if ($result!='') $result.=$languages_divisor;
        $result.=make_language(make_url($id,$i),$i);
    }
}
eval('?'.'>'.$result.'<?php ');
}

function make_stat($which,$cond,$mul,$cvt="<?php echo \$item['item'] ?>"){
global $site_name,$lng,$site_author,$site_author_email,$site_name,$lng,$site_home,$page_title,$category_name,$wessie_version,$wessie_author,$browser,$os,
        $wessie_author_email,$wessie_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
        $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER, $base_path;
global $db_connection,$table_stat,$table_prepend_name,$lng,$stat_start,$stat_end,$msg_unknown,$lang_name;

eval('?'.'>'.$stat_start.'<?php ');

if (!($id_result=mysql_query('SELECT count from '.$table_prepend_name.$table_stat." where category='total'",$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_stat.': '.mysql_error());
$item = mysql_fetch_array ($id_result);
mysql_free_result($id_result);
$total = $item['count'];
if (!($id_result=mysql_query('SELECT item,count from '.$table_prepend_name.$table_stat." where category='$which' $cond",$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_stat.': '.mysql_error());
while ($item = mysql_fetch_array ($id_result)){
    $percent=$item['count']*100/$total;
    eval('?'.'>'.make_stat_item($cvt/*$item['item']*/,$percent*$mul,$percent,$item['count']).'<?php ');
}
mysql_free_result($id_result);

eval('?'.'>'.$stat_end.'<?php ');
}

function stat_os($mul=1){
    make_stat('os','and count>0 order by count desc',$mul,"<?php echo \$item['item']!='?'?\$item['item']:\$msg_unknown ?>");
}

function stat_browser($mul=1){
    make_stat('browser','and count>0 order by count desc',$mul,"<?php echo \$item['item']!='?'?\$item['item']:\$msg_unknown ?>");
}

function stat_weeks($mul=1){
    make_stat('week_no','order by item',$mul);
}

function stat_days($mul=1){
    make_stat('dow','order by item',$mul,"<?php echo strftime('%A',mktime (0,0,0,5,6+\$item['item'],2001)) ?>");
}

function stat_hours($mul=1){
    make_stat('time','order by item',$mul);
}

function stat_langs($mul=1){
    make_stat('lang','order by item',$mul,"<?php echo \$lang_name[\$item['item']] ?>");
}

function wessie_icon(){
    global $base_path,$wessie_url;
    echo '<a href="'.$wessie_url.'"><img src="' . $base_path . 'img/wessie_icon.png" align="middle" alt="powered by wessie" width="88" height="31" border="0" /></a>';
}

function special(){global $special;echo $special;}

eval ('?'.'>'.$template.'<?php ');
?>