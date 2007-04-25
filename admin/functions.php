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

$server_root_dir = substr($_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME']));

function show_html_head($title,$special=''){
global $wessie_author,$wessie_version,$wessie_copyright,$site_home,$admin_charset,$base_path,$admin_default_css;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                  "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $admin_charset?>" />
    <title><?php echo $title?></title>
    <meta name="Author" content="<?php echo $wessie_author?>" />
    <meta name="Generator" content="<?php echo $wessie_copyright?>" />
    <link rel="home" href="<?php echo $site_home?>" />
    <link rel="copyright" href="mailto:<?php echo $wessie_author?>" />
    <link rel="StyleSheet" href="./<?php echo $admin_default_css;?>" type="text/css" media="screen" />
    <link rel="Alternate StyleSheet" href="./admin_blue.css" title="Blue" type="text/css" media="screen" />
    <link rel="Alternate StyleSheet" href="./admin_yellow.css" title="Yellow" type="text/css" media="screen" />
    <link rel="icon" href="<?php echo $base_path;?>img/favicon.png" type="image/png" />

    <!-- We LOVE Micro$oft! We don't like their silly features. -->
    <meta name="MSSmartTagsPreventParsing" content="true" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="MSThemeCompatible" content="no" />

    <script language="JavaScript" type="text/javascript" src="./admin.js"></script>
<?php echo $special; ?>
</head>
<?
}

$test = array();
function get_filtered_vars($prefix){
    global $test;
    function do_filter($item,$key,$prefix) {
        global $test;
        if (strncmp($key, $prefix, strlen($prefix)) != 0)
            unset($test[$key]);
    }

    $test = array();
    $test = array_merge($test, $GLOBALS); /* to make copy */

    array_walk($test, 'do_filter',$prefix);
    return $test;
}


function show_error($msg){
    echo '<p class="error">'.$msg.'</p>';
}

function show_error_box($msg='Wrong parameters!',$params=array(),$action=''){
?>
<div align="center">
  <p class="error"><?php echo $msg?></p>

<?php if($action!=''){?>
  <form method="get" action="<?php echo $action?>">
<?php
while (list ($key, $val) = each($params)){
    echo '<input type="hidden" name="'.$key.'" value="'.htmlspecialchars($val).'" />';
}?>
    <input type="submit" value=" OK " class="ok" />
  </form>
<?php } else {
        make_return_button();
    }
?>

</div>
<?php
}

function make_return_button($title=' OK '){
    if (isset($GLOBALS['HTTP_REFERER'])) {
    echo '<form action="'.$GLOBALS['HTTP_REFERER'].'" method="post" class="return">';
    ?>
        <input type="submit" value="<?php echo $title?>"  class="return" />
    </form>
    <?php } else {?>
    <form action="">
    <input type="button" onclick="history.go(-1)" value="<?php echo $title?>"  class="return" />
    </form>
    <?php }
}


function show_info($msg){
    echo '<p class="info">'.$msg."</p>\n";
}

function show_warning($msg){
    echo '<p class="warning">'.$msg."</p>\n";
}

function show_info_box($msg,$params=array(),$action=''){
?>
<div align="center">
  <form method="get"<?php if($action!='') echo ' action="'.$action.'"';?>>
    <b><?php echo $msg?></b><br />
<?php
while (list ($key, $val) = each($params)){
    echo '<input type="hidden" name="'.$key.'" value="'.htmlspecialchars($val).'" />';
}?>
    <input type="submit" value=" OK " class="ok" />
  </form>
</div>
<?php
}

function sized_textarea($name,$content){
    echo '<textarea name="'.$name.'" cols="'.$GLOBALS['admin_'.$name.'_cols'].'" rows="'.$GLOBALS['admin_'.$name.'_rows'].'" class="text">'.htmlspecialchars($content).'</textarea>';
}

function sized_edit($name,$content,$onchange=''){
    global $admin_fallback_size;
    if (isset($GLOBALS['admin_'.$name.'_size'])) $size=$GLOBALS['admin_'.$name.'_size']; else $size=$admin_fallback_size;
    echo '<input '.($onchange==''?'':'onchange="'.$onchange.'"').'type="text" name="'.$name.'" id="'.$name.'" size="'.$size.'" value="'.htmlspecialchars($content).'" class="text" />';
}

$download_group_name_init=FALSE;
$download_group_name_cache=array();
function init_download_group_name(){
    global $db_prepend,$table_download_group,$db_connection,$download_group_name_init,$download_group_name_cache;
    if (!($id_result=mysql_query('SELECT id,name from '.$db_prepend.$table_download_group,$db_connection)))
        show_error(mysql_error());
    while ($item = mysql_fetch_array ($id_result)) {
        $download_group_name_cache[$item['id']]=$item['name'];
    }
    mysql_free_result($id_result);
    $download_group_name_init=TRUE;
}

$category_name_init=FALSE;
$category_name_cache=array();
function init_category_name(){
    global $db_prepend,$table_category,$db_connection,$category_name_init,$category_name_cache;
    if (!($id_result=mysql_query('SELECT lng,id,name from '.$db_prepend.$table_category,$db_connection)))
        show_error(mysql_error());
    while ($item = mysql_fetch_array ($id_result)) {
        $category_name_cache[$item['lng']][$item['id']]=$item['name'];
    }
    mysql_free_result($id_result);
    $category_name_init=TRUE;
}

function download_group_edit($selected,$name='group',$add_any=0,$class='select',$disabled=array()){
    global $download_group_name_init,$download_group_name_cache;
    if (!$download_group_name_init) init_download_group_name();
    echo '<select name="'.$name.'"'.($class!=''?' class="'.$class.'"':'').'>';
    if ($add_any==1){
        echo '<option value="any">Any</option>';
    }elseif ($add_any==2){
        echo '<option value="0">None</option>';
    }

    reset($download_group_name_cache);
    while (list ($key, $val) = each($download_group_name_cache)){
        if (!in_array($key,$disabled)){
            echo '<option'.($key==$selected?' selected="selected"':'').' value="'.$key.'">'.htmlspecialchars($val).'</option>';
        }
    }
    echo '</select>';
}

function category_edit($selected,$lng,$name='category',$add_any=FALSE,$class='select',$disabled=array()){
    global $category_name_init,$category_name_cache;
    if (!$category_name_init) init_category_name();
    echo '<select name="'.$name.'"'.($class!=''?' class="'.$class.'"':'').'>';
    if ($add_any){
        echo '<option value="any">Any</option>';
    }
    reset($category_name_cache[$lng]);
    while (list ($key, $val) = each($category_name_cache[$lng])){
        if (!in_array($key,$disabled)){
            echo '<option'.($key==$selected?' selected="selected"':'').' value="'.$key.'">'.htmlspecialchars($val).'</option>';
        }
    }
    echo '</select>';
}

function page_edit($selected,$lng,$name='page',$show_details=FALSE,$class='select'){
    global $db_prepend,$table_page,$db_connection;
    if (!($id_result=mysql_query('SELECT id,name,category from '.$db_prepend.$table_page.' where lng='.$lng.' order by category',$db_connection)))
        show_error(mysql_error());

    echo '<select name="'.$name.'"'.($class!=''?' class="'.$class.'"':'').'>';
    $category=-1;
    while ($item = mysql_fetch_array ($id_result)) {
        if ($category!=$item['category']){
            if ($category!=-1) echo '</optgroup>';
            echo '<optgroup label="' . get_category_name($item['category'], $lng) . '">';
            $category=$item['category'];
        }

        echo '<option label="'.htmlspecialchars($item['name']).($show_details?' (' . $item['id'] . ')':'').'"'.($item['id']==$selected?' selected="selected"':'').' value="'.$item['id'].'">';
        if ($show_details){
            echo  htmlspecialchars(get_category_name($item['category'], $lng)). ' : ' . htmlspecialchars($item['name']) . ' (' . $item['id'] . ')';
        }else{
            echo htmlspecialchars($item['name']);
        }
        echo '</option>';
    }
    echo '</optgroup>';
    echo '</select>';

    mysql_free_result($id_result);
}

function get_category_name($selected,$lng){
    global $category_name_init,$category_name_cache;
    if (!$category_name_init) init_category_name();
    return isset($category_name_cache[$lng][$selected])?$category_name_cache[$lng][$selected]:'';
}

function get_download_group_name($selected){
    global $download_group_name_init,$download_group_name_cache;
    if (!$download_group_name_init) init_download_group_name();
    return isset($download_group_name_cache[$selected])?$download_group_name_cache[$selected]:'';
}

function language_edit($selected=-1,$add_any=FALSE,$name='lng',$disabled=array(),$class='select'){
    global $languages;

    reset($languages);

    echo '<select name="'.$name.'"'.($class!=''?' class="'.$class.'"':'').'>';
    if ($add_any){
        echo '<option value="any">Any</option>';
    }


    while (list ($key, $val) = each($languages)){
        if (!in_array($key,$disabled)){
            echo '<option'.((($selected!='any')&&($key==$selected))?' selected="selected"':'').' value="'.$key.'">'.$val['name'].'</option>';
        }
    }

    echo '</select>';
}

function type_edit($selected=-1,$add_any=FALSE,$name='type',$disabled=array(),$class='select'){
    global $allowed_page_plugins;

    reset($allowed_page_plugins);

    echo '<select name="'.$name.'"'.($class!=''?' class="'.$class.'"':'').'>';
    if ($add_any){
        echo '<option value="any">Any</option>';
    }


    while (list ($key, $val) = each($allowed_page_plugins)){
        if (!in_array($val,$disabled)){
            echo '<option'.((($selected!='any')&&($val==$selected))?' selected="selected"':'').' value="'.$val.'">'.$val.'</option>';
        }
    }

    echo '</select>';
}

function new_page($name,$type,$file,$description,$keywords,$lng,$category,$page){
    global $db_prepend,$table_page;
    if (!mysql_query('INSERT '.$db_prepend.$table_page.' set name="'.opt_addslashes($name).'", type="'.$type.'", param="'.opt_addslashes($file).'",description="'.opt_addslashes($description).'",keywords="'.opt_addslashes($keywords).'",category='.$category.',lng='.$lng.($page!=-1?', id='.$page:''))){
        show_error("Can't create page! (".mysql_error().')');
        exit;
    }
    if (!$id_result=mysql_query('SELECT id from '.$db_prepend.$table_page.' where  name="'.opt_addslashes($name).'" and type="'.$type.'" and param="'.opt_addslashes($file).'" and description="'.opt_addslashes($description).'" and keywords="'.opt_addslashes($keywords).'" and category='.$category.' and lng='.$lng.($page!=-1?' and id='.$page:''))){
        show_error("Can't get back page info! (".mysql_error().')');
        exit;
    }
    if (mysql_num_rows($id_result)!=1){
        show_error("Can't get back page info! (".mysql_error().')');
        exit;
    }
    $item = mysql_fetch_array ($id_result);
    mysql_free_result($id_result);
    return $item['id'];
}

function is_page_free($id,$lng){
    global $db_prepend,$table_page;
    if (!$id_result=mysql_query('SELECT id from '.$db_prepend.$table_page.' where  id='.$id.' and lng='.$lng)){
        show_error("Can't get page info! (".mysql_error().')');
        exit;
    }
    return (mysql_num_rows($id_result)==0);
}

function is_category_free($id,$lng){
    global $db_prepend,$table_category;
    if (!$id_result=mysql_query('SELECT id from '.$db_prepend.$table_category.' where  id='.$id.' and lng='.$lng)){
        show_error("Can't get page info! (".mysql_error().')');
        exit;
    }
    return (mysql_num_rows($id_result)==0);
}

function is_download_free($id){
    global $db_prepend,$table_download;
    if (!$id_result=mysql_query('SELECT id from '.$db_prepend.$table_download.' where  id='.$id)){
        show_error("Can't get download info! (".mysql_error().')');
        exit;
    }
    return (mysql_num_rows($id_result)==0);
}

function is_download_group_free($id){
    global $db_prepend,$table_download_group;
    if (!$id_result=mysql_query('SELECT id from '.$db_prepend.$table_download_group.' where  id='.$id)){
        show_error("Can't get download group info! (".mysql_error().')');
        exit;
    }
    return (mysql_num_rows($id_result)==0);
}

function get_page_translations($id){
    global $db_prepend,$table_page;
    if (!$id_result=mysql_query('SELECT lng from '.$db_prepend.$table_page.' where id='.$id)){
        show_error("Can't get page info! (".mysql_error().')');
        exit;
    }
    $result=array();
    while ($item = mysql_fetch_array ($id_result)) {
        $result[$item['lng']]=$item['lng'];
    }
    mysql_free_result($id_result);
    return $result;
}

function get_category_translations($id){
    global $db_prepend,$table_category;
    if (!$id_result=mysql_query('SELECT lng from '.$db_prepend.$table_category.' where id='.$id)){
        show_error("Can't get category info! (".mysql_error().')');
        exit;
    }
    $result=array();
    while ($item = mysql_fetch_array ($id_result)) {
        $result[$item['lng']]=$item['lng'];
    }
    mysql_free_result($id_result);
    return $result;
}

function make_url($id,$lng){
    return make_absolute_url($id,$lng);
}

function make_absolute_url($id,$lng){
    global $base_path, $languages, $admin_force_ssl;
    return ($admin_force_ssl || isset($HTTPS) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].$base_path.'main.php/page'.$id.'.'.$languages[$lng]['short'].'.html';
}

function get_page_count($type){
    global $db_prepend,$table_page;
    if (!$id_result=mysql_query('SELECT count(*) as count from '.$db_prepend.$table_page." where type='".$type."'"))
        show_error("Can't select page count! (".mysql_error().')');
    $item = mysql_fetch_array ($id_result);
    mysql_free_result($id_result);
    return $item['count'];
}

function change_everywhere_category($from,$to,$lng){
    global $db_prepend,$table_menu,$table_page;
    if (!$id_result=mysql_query('UPDATE '.$db_prepend.$table_page.' set category='.$to.' where category='.$from.' AND lng='.$lng)){
        show_error("Can't update category info! (".mysql_error().')');
        exit;
    }
    if (!$id_result=mysql_query('UPDATE '.$db_prepend.$table_menu.' set category='.$to.' where category='.$from.' AND lng='.$lng)){
        show_error("Can't update category info! (".mysql_error().')');
        exit;
    }
}

function delete_everywhere_category($id,$lng){
    global $db_prepend,$table_menu,$table_page;
    delete_pages('category='.$id.' AND lng='.$lng);
    if (!$id_result=mysql_query('DELETE FROM '.$db_prepend.$table_menu.' where category='.$id.' AND lng='.$lng)){
        show_error("Can't update category info! (".mysql_error().')');
        exit;
    }
}

function change_downloads_download_group($from,$to){
    global $db_prepend,$table_download;
    if (!$id_result=mysql_query('UPDATE '.$db_prepend.$table_download.' set grp='.$to.' where grp='.$from)){
        show_error("Can't update download info! (".mysql_error().')');
        exit;
    }
}

function delete_donwloads_download_group($id,$delete_files){
    global $db_prepend,$table_download;
    if ($delete_files){
        if (!$id_result=mysql_query(
        'SELECT id, filename, remote, grp, count '.
        ' from '.$db_prepend.$table_download.
        ' where grp='.$id))
            show_error("Can't select download! (".mysql_error().')');

        if (!mysql_query('DELETE FROM '.$db_prepend.$table_download.' where grp='.$id)){
            show_error("Can't delete downloads! (".mysql_error().')');
            exit;
        }

        while ($download = mysql_fetch_array ($id_result)) {
            echo '<p class="info">Attempting to delete file: '.$download['filename'].'</p>';
            if (!file_exists('../'.$download['filename'])){
                echo '<p class="info">File does NOT exist, so it was NOT deleted</p>';
            }elseif (!unlink('../'.$download['filename'])){
                echo '<p class="info">File could NOT be deleted</p>';
            }else{
                echo '<p class="info">File deleted</p>';
            }
        }
        mysql_free_result($id_result);
    }else{
        if (!$id_result=mysql_query('DELETE FROM '.$db_prepend.$table_download.' where grp='.$id)){
            show_error("Can't update download info! (".mysql_error().')');
            exit;
        }
    }
}

function delete_pages($condition){
    global $db_prepend,$table_menu,$table_page;
    if (!$id_result=mysql_query('SELECT id,type,lng,category FROM '.$db_prepend.$table_page.' where '.$condition)){
        show_error("Can't get pages info! (".mysql_error().')');
        exit;
    }

    while ($item = mysql_fetch_array ($id_result)) {
        if (!mysql_query('DELETE FROM '.$db_prepend.$table_menu.' where page='.$item['id'].' AND lng='.$item['lng'])){
            show_error("Can't delete menu items! (".mysql_error().')');
            exit;
        }
        @mysql_query('DELETE FROM '.$db_prepend.$GLOBALS['table_'.$item['type']].' where page='.$item['id'].' AND lng='.$item['lng']);
    }
    mysql_free_result($id_result);

    if (!mysql_query('DELETE FROM '.$db_prepend.$table_page.' where '.$condition)){
        show_error("Can't delete pages! (".mysql_error().')');
        exit;
    }

}

$configuration=array();
$configuration_loaded=FALSE;

function config_read(){
    global $configuration,$configuration_loaded;
    if (!($file = fopen($root_dir=dirname(dirname($_SERVER['SCRIPT_FILENAME'])).'/config.php', 'r')))
        return FALSE;
    for ($i=0; !feof($file); $i++) {
        $configuration[$i] = fgets($file, 1024);
    }
    return $configuration_loaded=fclose($file);
}

function config_write(){
    global $configuration,$configuration_loaded;
    if (!($file = fopen($root_dir=dirname(dirname($_SERVER['SCRIPT_FILENAME'])).'/config.php', 'w')))
        return FALSE;
    for ($i=0; $i < count($configuration); $i++) {
        if (isset($configuration[$i])) fwrite($file, $configuration[$i], 1024);
    }
    return fclose($file);
}

//$newline must contain ;\n !
function config_set_option($pattern,$newline,$add_before="\\?>",$fallback_add_before="\\?>"){
    global $configuration,$configuration_loaded;

    if (!$configuration_loaded) return FALSE;

    $where_add=-1;

    for ($i=0; $i < count($configuration); $i++) {
        if (isset($configuration[$i])){
            if (ereg('^[[:space:]]*'.$pattern, $configuration[$i])){
                $configuration[$i]=$newline;
                return TRUE;
            } elseif (ereg($add_before, $configuration[$i])){
                $where_add=$i;
            } elseif (($where_add==-1) && ereg($fallback_add_before, $configuration[$i])){
                $where_add=$i;
            }
        }
    }
    if ($where_add!=-1){
        for ($i=count($configuration); $i >$where_add; $i--) {
            if (isset($configuration[$i-1]))
                $configuration[$i]=$configuration[$i-1];
        }
        $configuration[$where_add]=$newline;
        return TRUE;
    }
    return FALSE;
}

function config_del_options($pattern){
    global $configuration,$configuration_loaded;

    if (!$configuration_loaded) return FALSE;

    $result=FALSE;

    for ($i=0; $i < count($configuration); $i++) {
        if (ereg($pattern, $configuration[$i])){
            for ($j=$i+1; $j < count($configuration); $j++) {
                $configuration[$j-1]=$configuration[$j];
            }
            unset($configuration[$j]);
            $result=TRUE;
            $i--;
        }
    }
    return $result;
}

function make_row($even){
    $class=(($even == 1)?'even':'odd');
    echo '<tr class="'.$class.'" ';
    highlighter($class.'_light',$class);
    echo '>';
}

function make_cell($data,$url='',$class=''){
    echo '<td'.($class!=''&&$url==''?' class="'.$class.'"':'').($url!=''?' class="clickable'.$class.'" onclick="window.location.replace('."'".$url."'".')"':'').'>'.$data.'</td>';
}

function make_row_js($even,$js,$class_even='even',$class_odd='odd'){
    $class=(($even == 1)?$class_even:$class_odd);
    echo '<tr onclick="'.$js.'" class="'.$class.'" ';
    highlighter($class.'_light',$class);
    echo '>';
}

function make_tab_item($href,$text,$url,$url2=''){
    $class=(($url!='' && strpos($_SERVER['SCRIPT_NAME'],$url))||($url2!='' && strpos($_SERVER['SCRIPT_NAME'],$url2))?'selected':'normal');
    echo '<td class="'.$class.'" ';
    highlighter($class.'_light',$class);
    echo ' onclick="window.location.replace(\''.$href.'\')"><a href="'.$href.'">'.$text."</a></td>\n";
}

function make_tab_item_window($href,$text,$url){
    global $admin_help_height,$admin_help_width;
    $class=(strpos($_SERVER['SCRIPT_NAME'],$url)?'selected':'normal');
    echo '<td class="'.$class.'" ';
    highlighter($class.'_light',$class);
    echo ' onclick="window.open(\''.$href.'\',\'\',\'menubar=no,location=no,status=no,toolbar=no,width='.$admin_help_width.',height='.$admin_help_height.'\');return false"><a href="'.$href.'" target="_blank">'.$text.'</a></td>'."\n";
}

function make_tab_start(){
    echo '<table class="tabs"><tr>';
}

function make_tab_end(){
    echo '</tr></table>';
}

function human_readable_size($size){
    if ($size<1024) {
        return $size.' B';
    }elseif ($size<1048576) {
        return (round($size*10/1024)/10).' kB';
    }elseif ($size<1073741824) {
        return (round($size*10/1048576)/10).' MB';
    }else{
        return (round($size*10/1073741824)/10).' GB';
    }
}

function opt_addslashes($str) {
    if (get_magic_quotes_gpc()) {
        return $str;
    } else {
        return addslashes($str);
    }
}

function opt_stripslashes($str) {
    if (get_magic_quotes_gpc()) {
        return stripslashes($str);
    } else {
        return $str;
    }
}

function highlighter($class1,$class2){
    if ($class1!=''&&$class2!=''){
        echo ' onmouseover="this.className = \''.$class1.'\';" onmouseout="this.className = \''.$class2.'\';"';
    }
}
?>
