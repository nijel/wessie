<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Web Site System version 0.1                                          |
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

error_reporting (E_ALL);
//BEFORE publishing check all TEMPORARY words!

require_once('./init.php');
require_once('./errors.php');
require_once('./config.php');

//we don't want to cache our documents....
Header('Pragma: no-cache');
Header("Expires: " . GMDate("D, d M Y H:i:s") . " GMT");

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
                if (in_array($curr_lang,$languages)){
                    for ($j=0;$j<count($languages);$j++){
                        if (strcasecmp($languages[$j],$curr_lang)==0){
                            $lng=$j;
                            break;
                        }
                    }
                    $lang=$languages[$lng];
                    eval('$lang_file_name="'.$lang_file.'";');
                    if (($lng!=-1)&&(file_exists($lang_file_name))) break;
                }
            }
            if (($lng==-1)||(!file_exists($lang_file_name))) $lng=$default_lang;
        }else{
            $lng=$default_lang;
        }
    }
}else{
    $lang=$languages[$lng];
    eval('$lang_file_name="'.$lang_file.'";');
}

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

//connect to database
require_once('./db_connect.php');

//client browser and os detection
require_once('./browser.php');

//generate statistics
// true in following line is TEMPORARY
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

    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_stat." set count=count+1 where category='time' and item='".strftime('%H')."' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_stat.': '.mysql_error());
    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_stat." set count=count+1 where category='dow' and item='$dow' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_stat.': '.mysql_error());

    if (!($id_result=mysql_query('SELECT count(category) from '.$table_prepend_name.$table_stat." where category='week_no' and item='$wno' limit 1",$db_connection)))
            do_error(1,'SELECT '.$table_prepend_name.$table_stat.': '.mysql_error());
    if (mysql_num_rows($id_result)==0){
        if (!(mysql_query('INSERT into '.$table_prepend_name.$table_stat." set count=1, category='week_no', item='$wno'",$db_connection)))
            do_error(1,'INSERT '.$table_prepend_name.$table_stat.': '.mysql_error());
    }else{
        if (!(mysql_query('UPDATE '.$table_prepend_name.$table_stat." set count=count+1 where category='week_no' and item='$wno' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_stat.': '.mysql_error());
    }
    mysql_free_result($id_result);

    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_stat." set count=count+1 where category='os' and item='$os' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_stat.': '.mysql_error());
    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_stat." set count=count+1 where category='browser' and item='$browser' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_stat.': '.mysql_error());

    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_stat." set count=count+1 where category='lang' and item='$lng' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_stat.': '.mysql_error());

    if (!(mysql_query('UPDATE '.$table_prepend_name.$table_stat." set count=count+1 where category='total' and item='hits' limit 1",$db_connection)))
            do_error(1,'UPDATE '.$table_prepend_name.$table_stat.': '.mysql_error());
}


//read page
if (!($id_result=mysql_query('SELECT * from '.$table_prepend_name.$table_page.' where id='.$id.' and lng='.$lng.' limit 1',$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_page.': '.mysql_error());
$page=mysql_fetch_array($id_result);
if (!isset($page['id'])){
    log_error('Unknown page: '.$id);
    header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI)=='/'?'':dirname($REQUEST_URI).'/main.php');
    bye();
}
mysql_free_result($id_result);


//read category
if (!($id_result=mysql_query('SELECT * from '.$table_prepend_name.$table_category.' where id='.$page['category'].' and lng='.$lng.' limit 1',$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_category.': '.mysql_error());
$category=mysql_fetch_array($id_result);
if (!isset($category['id'])){
    log_error('Unknown category: '.$page['category']);
    header('Location: http://'.$SERVER_NAME.dirname($REQUEST_URI).'/main.php');
    bye();
}
mysql_free_result($id_result);

//language file
if (!isset($lng)){
        $lng=$category['lng'];
    $lang=$languages[$lng];
    eval('$lang_file_name="'.$lang_file.'";');
}
if (!file_exists($lang_file_name)) do_error(2,$lang_file_name);
require_once($lang_file_name);

//add header about content and encoding
Header('Content-Type: text/html; charset='.$charset);

//template file
eval('$template_file_name="'.$template_file.'";');
require_once($template_file_name);

eval('$template_file_name="'.$template_data.'";');
if (!file_exists($template_file_name)) do_error(3,$template_file_name);
$fh=fopen($template_file_name,'r');
$template=fread($fh, filesize($template_file_name));
fclose($fh);

//read content
switch ($page['type']){
    case 'file': /* file */
        if (!file_exists($page['file'])) do_error(3,$page['file']);
        $fh=fopen($page['file'],'r');
        $content=fread($fh, filesize($page['file']));
        fclose($fh);
        break;
    case 'article': /* article */
        if (!($id_result=mysql_query('SELECT * from '.$table_prepend_name.$table_article.' where page='.$id.' and lng='.$lng.' limit 1',$db_connection)))
            do_error(1,'SELECT '.$table_prepend_name.$table_article.': '.mysql_error());
        $article=mysql_fetch_array($id_result);
        mysql_free_result($id_result);
        $content=$article['content'];
        break;
    default:
        $content='&nbsp;';
}

//functions:

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
        global $site_name,$site_author,$site_author_email,$site_name,$site_home,$page_title,$category_name,$wss_version,$wss_author,$browser,$os,
                $wss_author_email,$wss_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
                $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;

        global $table_prepend_name,$table_category,$lng,$db_connection,$upper_menu_divisor,$page;

        if (!($id_result=mysql_query('SELECT * from '.$table_prepend_name.$table_category.' where lng='.$lng,$db_connection)))
            do_error(1,'SELECT '.$table_prepend_name.$table_category.': '.mysql_error());
        $percent=(string)(int)100/mysql_num_rows($id_result).'%';

        $was_item=false;
        while ($item = mysql_fetch_array ($id_result)) {
            if ($was_item) {echo $upper_menu_divisor;}
                $was_item=true;

                eval('?'.'>'.make_upper_menu_item($percent,'main.php?id='.$item['page'].'&lng='.$lng,$item['name'],$item['short'],$item['description'],$page['category']==$item['id']).'<?php ');
        }

        mysql_free_result($id_result);
}

function top_pages(){
        global $site_name,$site_author,$site_author_email,$site_name,$site_home,$page_title,$category_name,$wss_version,$wss_author,$browser,$os,
                $wss_author_email,$wss_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
                $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;

        global $table_prepend_name,$table_category,$table_page,$lng,$db_connection,$top_pages_divisor,$top_pages_count;

        $id_result=mysql_query('SELECT id,name,description,category from '.$table_prepend_name.$table_page.' where lng='.$lng.' order by count desc limit '.$top_pages_count) or
            do_error(1,'SELECT '.$table_prepend_name.$table_page.': '.mysql_error());

        $was_item=false;
        while ($item = mysql_fetch_array ($id_result)) {
            if ($was_item) {echo $top_pages_divisor;}
                $was_item=true;

                $id2_result=mysql_query('SELECT name,short from '.$table_prepend_name.$table_category.' where id='.$item['category'].' and lng='.$lng.' limit 1',$db_connection) or
                        do_error(1,'SELECT '.$table_prepend_name.$table_category.': '.mysql_error());
            $item_cat=mysql_fetch_array($id2_result);
            mysql_free_result($id2_result);

                eval('?'.'>'.make_top_pages_item('main.php?id='.$item['id'].'&lng='.$lng,$item['name'],$item_cat['name'],$item_cat['short'],$item['description']).'<?php ');
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
}

function left_menu(){
global $lng,$id,$table_prepend_name,$table_menu,$db_connection;

function add_childs($child_id,$depth,$parents){
global $site_name,$site_author,$site_author_email,$site_name,$site_home,$page_title,$category_name,$wss_version,$wss_author,$browser,$os,
        $wss_author_email,$wss_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
        $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;
global $first_item,$left_menu_divisor,$id,$category,$db_connection,$table_menu,$table_page,$table_prepend_name,$lng;

if (!($id_result=(mysql_query('SELECT id,name,description,page,category,parent,expand from '.$table_prepend_name.$table_menu.' where lng='.$lng.' and parent='.$child_id.' and category='.$category['id'],$db_connection)))&&($child_id=0))
        do_error(1,'SELECT '.$table_prepend_name.$table_menu.': '.mysql_error());
while ($item = mysql_fetch_array ($id_result)){
        if (!$first_item) echo $left_menu_divisor;
        $first_item=false;

        if (!($id2_result=mysql_query('SELECT name,description from '.$table_prepend_name.$table_page.' where lng='.$lng.' and id='.$item['page'].' limit 1',$db_connection)))
                do_error(1,'SELECT '.$table_prepend_name.$table_page.': '.mysql_error());
        $page=mysql_fetch_array($id2_result);
        mysql_free_result($id2_result);

        if ((!isset($item['name']))||($item['name']=='')) $name=$page['name'];
        else $name=$item['name'];

        if ((!isset($item['description']))||($item['description']=='')) $desc=$page['description'];
        else $desc=$item['description'];

        eval('?'.'>'.make_menu_item('main.php?id='.$item['page'].'&lng='.$lng,$name,$category['name'],$category['short'],$desc,$item['page']==$id,$depth).'<?php ');
        if (($item['expand']==1) || ($item['page']==$id) || in_array ($item['id'],$parents)){
            add_childs($item['id'],$depth+1,$parents);
        }
}
mysql_free_result($id_result);
}

$first_item=true;
// Read parents of active page to know which path of menu structure should we enable
$parents=array();
$parent=-1;
if (!($id_result=mysql_query('SELECT parent from '.$table_prepend_name.$table_menu.' where lng='.$lng.' and page='.$id,$db_connection)))
    do_error(1,'SELECT '.$table_prepend_name.$table_menu.': '.mysql_error());
$item=mysql_fetch_array ($id_result);
mysql_free_result($id_result);
$parent=$item['parent'];
while ($parent!=0){
    $parents[]=$parent;
    if (!($id_result=mysql_query('SELECT parent from '.$table_prepend_name.$table_menu.' where lng='.$lng.' and id='.$parent,$db_connection)))
        do_error(1,'SELECT '.$table_prepend_name.$table_menu.': '.mysql_error());
    $item=mysql_fetch_array ($id_result);
    mysql_free_result($id_result);
    $parent=$item['parent'];
}

//Add childs to root
add_childs(0,0,$parents);
}

function content(){
global $content,
        $site_name,$site_author,$site_author_email,$site_name,$site_home,
        $page_title,$category_name,
        $browser,$os,
        $wss_version,$wss_author,$wss_author_email,$wss_url,
        $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;
eval('?'.'>'.$content.'<?php ');
}

function counter(){
global $msg_counter,$page;
$count=$page['count'];
eval('?'.'>'.$msg_counter.'<?php ');
}

function copyright(){global $copyright;echo $copyright;}

function page_title(){
global $page,
        $site_name,$site_author,$site_author_email,$site_name,$site_home,
        $page_title,$category_name,
        $browser,$os,
        $wss_version,$wss_author,$wss_author_email,$wss_url,
        $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;

eval('?'.'>'.$page['name'].'<?php ');
}

function category_name(){
global $category,
        $site_name,$site_author,$site_author_email,$site_name,$site_home,
        $page_title,$category_name,
        $browser,$os,
        $wss_version,$wss_author,$wss_author_email,$wss_url,
        $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;

eval('?'.'>'.$category['name'].'<?php ');
}

function keywords(){
global $page,
        $site_name,$site_author,$site_author_email,$site_name,$site_home,
        $page_title,$category_name,
        $wss_version,$wss_author,$wss_author_email,$wss_url,
        $browser,$os,
        $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;

eval('?'.'>'.$page['keywords'].'<?php ');
}

function description(){
global $page,
    $site_name,$site_author,$site_author_email,$site_name,$site_home,
    $page_title,$category_name,
    $browser,$os,
    $wss_version,$wss_author,$wss_author_email,$wss_url,
    $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;

eval('?'.'>'.$page['description'].'<?php ');
}

function search_hidden_options(){
        echo '';
}

function languages(){
global $languages,$lang_name,$lang_main_page,$languages_divisor,$id,
        $site_name,$site_author,$site_author_email,$site_name,$site_home,
        $page_title,$category_name,
        $browser,$os,
        $wss_version,$wss_author,$wss_author_email,$wss_url,
        $SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,$REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;
if (count($languages)==1){
    $result='&nbsp;'; // if there is only one language it's useles to offer it
}else{
    $result='';
    for($i=0;$i<count($languages);$i++){
        if ($result!='') $result.=$languages_divisor;
        $result.=make_language('main.php?id='.$id.'&lng='.$i,$lang_name[$i]);
    }
}
eval('?'.'>'.$result.'<?php ');
}

function make_stat($which,$cond,$mul,$cvt="<?php echo \$item['item'] ?>"){
global $site_name,$site_author,$site_author_email,$site_name,$site_home,$page_title,$category_name,$wss_version,$wss_author,$browser,$os,
        $wss_author_email,$wss_url,$SERVER_SOFTWARE,$SERVER_SIGNATURE,$SERVER_PROTOCOL,$SERVER_NAME,$SERVER_ADDR,$SERVER_PORT,$HTTP_USER_AGENT,
        $REQUEST_URI,$REMOTE_ADDR,$HTTP_REFERER;
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

function special(){global $special;echo $special;}

eval ('?'.'>'.$template.'<?php ');
?>