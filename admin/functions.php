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
    echo '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
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
    echo '<b>'.$msg.'</b><br />';
}

function show_info_box($msg,$params=array(),$action=''){
?>
<div align="center">
  <form method="get"<?php if($action!='') echo ' action="'.$action.'"';?>>
    <b><?php echo $msg?></b><br />
<?php
while (list ($key, $val) = each($params)){
    echo '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
}?>
    <input type="submit" value=" OK " class="ok" />
  </form>
</div>
<?php
}

function sized_textarea($name,$content){
    echo '<textarea name="'.$name.'" cols="'.$GLOBALS['admin_'.$name.'_cols'].'" rows="'.$GLOBALS['admin_'.$name.'_rows'].'" class="text">'.htmlspecialchars($content).'</textarea>';
}

function sized_edit($name,$content){
    echo '<input type="text" name="'.$name.'" size="'.$GLOBALS['admin_'.$name.'_size'].'" value="'.htmlspecialchars($content).'" class="text" />';
}



$download_group_name_init=FALSE;
$download_group_name_cache=array();
function init_download_group_name(){
    global $table_prepend_name,$table_download_group,$db_connection,$download_group_name_init,$download_group_name_cache;
    if (!($id_result=mysql_query('SELECT id,name from '.$table_prepend_name.$table_download_group,$db_connection)))
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
    global $table_prepend_name,$table_category,$db_connection,$category_name_init,$category_name_cache;
    if (!($id_result=mysql_query('SELECT lng,id,name from '.$table_prepend_name.$table_category,$db_connection)))
        show_error(mysql_error());
    while ($item = mysql_fetch_array ($id_result)) {
        $category_name_cache[$item['lng']][$item['id']]=$item['name'];
    }
    mysql_free_result($id_result);
    $category_name_init=TRUE;
}

function download_group_edit($selected,$name='group',$add_any=FALSE,$class='select',$disabled=array()){
    global $download_group_name_init,$download_group_name_cache;
    if (!$download_group_name_init) init_download_group_name();
    echo '<select name="'.$name.'"'.($class!=''?' class="'.$class.'"':'').'>';
    if ($add_any){
        echo '<option value="any">Any</option>';
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
    global $table_prepend_name,$table_page,$db_connection;
    if (!($id_result=mysql_query('SELECT id,name,category from '.$table_prepend_name.$table_page.' where lng='.$lng.' order by category',$db_connection)))
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
    global $lang_name;

    reset($lang_name);

    echo '<select name="'.$name.'"'.($class!=''?' class="'.$class.'"':'').'>';
    if ($add_any){
        echo '<option value="any">Any</option>';
    }


    while (list ($key, $val) = each($lang_name)){
        if (!in_array($key,$disabled)){
            echo '<option'.((($selected!='any')&&($key==$selected))?' selected="selected"':'').' value="'.$key.'">'.$val.'</option>';
        }
    }

    echo '</select>';
}

function new_page($name,$type,$file,$description,$keywords,$lng,$category,$page){
    global $table_prepend_name,$table_page;
    if (!mysql_query('INSERT '.$table_prepend_name.$table_page.' set name="'.$name.'", type="'.$type.'", param="'.$file.'",description="'.$description.'",keywords="'.$keywords.'",category='.$category.',lng='.$lng.($page!=-1?', id='.$page:''))){
        show_error("Can't create page! (".mysql_error().')');
        exit;
    }
    if (!$id_result=mysql_query('SELECT id from '.$table_prepend_name.$table_page.' where  name="'.$name.'" and type="'.$type.'" and param="'.$file.'" and description="'.$description.'" and keywords="'.$keywords.'" and category='.$category.' and lng='.$lng.($page!=-1?' and id='.$page:''))){
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
    global $table_prepend_name,$table_page;
    if (!$id_result=mysql_query('SELECT id from '.$table_prepend_name.$table_page.' where  id='.$id.' and lng='.$lng)){
        show_error("Can't get page info! (".mysql_error().')');
        exit;
    }
    if (mysql_num_rows($id_result)!=0){
        return FALSE;
    } else {
        return TRUE;
    }
}

function is_category_free($id,$lng){
    global $table_prepend_name,$table_category;
    if (!$id_result=mysql_query('SELECT id from '.$table_prepend_name.$table_category.' where  id='.$id.' and lng='.$lng)){
        show_error("Can't get page info! (".mysql_error().')');
        exit;
    }
    if (mysql_num_rows($id_result)!=0){
        return FALSE;
    } else {
        return TRUE;
    }
}

function get_page_translations($id){
    global $table_prepend_name,$table_page;
    if (!$id_result=mysql_query('SELECT lng from '.$table_prepend_name.$table_page.' where id='.$id)){
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
    global $table_prepend_name,$table_category;
    if (!$id_result=mysql_query('SELECT lng from '.$table_prepend_name.$table_category.' where id='.$id)){
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
    global $base_path;
    return $base_path.'../main.php/id='.$id.'/lng='.$lng;
}

function change_everywhere_category($from,$to,$lng){
    global $table_prepend_name,$table_menu,$table_page;
    if (!$id_result=mysql_query('UPDATE '.$table_prepend_name.$table_page.' set category='.$to.' where category='.$from.' AND lng='.$lng)){
        show_error("Can't update category info! (".mysql_error().')');
        exit;
    }
    if (!$id_result=mysql_query('UPDATE '.$table_prepend_name.$table_menu.' set category='.$to.' where category='.$from.' AND lng='.$lng)){
        show_error("Can't update category info! (".mysql_error().')');
        exit;
    }
}

function delete_everywhere_category($id,$lng){
    global $table_prepend_name,$table_menu,$table_page;
/*    if (!$id_result=mysql_query('DELETE FROM '.$table_prepend_name.$table_page.' where category='.$id.' AND lng='.$lng)){
        show_error("Can't update category info! (".mysql_error().')');
        exit;
    }*/
    delete_pages('category='.$id.' AND lng='.$lng);
    if (!$id_result=mysql_query('DELETE FROM '.$table_prepend_name.$table_menu.' where category='.$id.' AND lng='.$lng)){
        show_error("Can't update category info! (".mysql_error().')');
        exit;
    }
}

function delete_pages($condition){
    global $table_prepend_name,$table_menu,$table_page;
    if (!$id_result=mysql_query('SELECT id,type,lng,category FROM '.$table_prepend_name.$table_page.' where '.$condition)){
        show_error("Can't get pages info! (".mysql_error().')');
        exit;
    }

    while ($item = mysql_fetch_array ($id_result)) {
        if (!mysql_query('DELETE FROM '.$table_prepend_name.$table_menu.' where page='.$item['id'].' AND lng='.$item['lng'])){
            show_error("Can't delete menu items! (".mysql_error().')');
            exit;
        }

        if ($item['type']!='file'){
            if (!mysql_query('DELETE FROM '.$table_prepend_name.$GLOBALS['table_'.$item['type']].' where page='.$item['id'].' AND lng='.$item['lng'])){
                show_error("Can't delete page details! (".mysql_error().')');
                exit;
            }
        }
    }
    mysql_free_result($id_result);

    if (!mysql_query('DELETE FROM '.$table_prepend_name.$table_page.' where '.$condition)){
        show_error("Can't delete pages! (".mysql_error().')');
        exit;
    }

}

function make_row($even,$url){
    global $admin_highlight_list;
    echo '<tr '.(($even == 1)?'class="even"':'class="odd"');
//    echo '<tr onclick="window.location.replace(\''.$url.'\')" '.(($even == 1)?'class="even"':'class="odd"');
    highlighter($admin_highlight_list);
    echo'><td>';
}

function make_tab_item($href,$text,$url){
    global $SCRIPT_NAME,$admin_highlight_tabs;
    echo '<td'.(strpos($SCRIPT_NAME,$url)?' class="selected"':'');
    highlighter($admin_highlight_tabs);
    echo ' onclick="window.location.replace(\''.$href.'\')"><a href="'.$href.'">'.$text.'</a></td>'."\n";
}

function make_tab_start(){
    echo '<table class="tabs"><tr>';
}

function make_tab_end(){
    echo '</tr></table>';
}

function highlighter($color='#00ff00'){
    if ($color!=''){
        echo ' onmouseover="highlight(this,\''.$color.'\');" onmouseout="unhighlight(this);"';
//        echo ' onmouseover="oldbg=this.style.backgroundColor;if (typeof(this.style) != \'undefined\') this.style.backgroundColor = \''.$color.'\'" onmouseout="if (typeof(this.style) != \'undefined\') this.style.backgroundColor = oldbg"';
    }
}
?>
