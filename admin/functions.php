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

function show_error($msg){
    echo '<font color="#ff0000"><b>'.$msg.'</b></font><br />';
}

function show_error_box($msg='Wrong parameters!',$params=array(),$action=''){
?>
<div align="center">
  <font color="#ff0000"><b><?php echo $msg?></b></font><br />

<?php if($action!=''){?>
  <form method="get" action="<?php echo $action?>">
<?php
while (list ($key, $val) = each($params)){
    echo '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
}?>
    <input type="submit" value=" OK " />
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
    echo '<form action="'.$GLOBALS['HTTP_REFERER'].'" method="post">';
    ?>
        <input type="submit" value="<?php echo $title?>" />
    </form>
    <?php } else {?>
    <form action="">
    <input type="button" onclick="history.go(-1)" value="<?php echo $title?>" />
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
    <input type="submit" value=" OK " />
  </form>
</div>
<?php
}

function sized_textarea($name,$content){
    echo '<textarea name="'.$name.'" cols="'.$GLOBALS['admin_'.$name.'_cols'].'" rows="'.$GLOBALS['admin_'.$name.'_rows'].'">'.htmlspecialchars($content).'</textarea>';
}

function sized_edit($name,$content){
    echo '<input type="text" name="'.$name.'" size="'.$GLOBALS['admin_'.$name.'_size'].'" value="'.htmlspecialchars($content).'" />';
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

function category_edit($selected,$lng,$name='category',$add_any=FALSE){
    global $category_name_init,$category_name_cache;
    if (!$category_name_init) init_category_name();
    echo '<select name="'.$name.'">';
    if ($add_any){
        echo '<option value="any">Any</option>';
    }
    while (list ($key, $val) = each($category_name_cache[$lng])){
        echo '<option'.($key==$selected?' selected="selected"':'').' value="'.$key.'">'.htmlspecialchars($val).'</option>';
    }
    echo '</select>';
}

function page_edit($selected,$lng,$name='page',$show_details=FALSE){
    global $table_prepend_name,$table_page,$db_connection;
    if (!($id_result=mysql_query('SELECT id,name,category from '.$table_prepend_name.$table_page.' where lng='.$lng.' order by category',$db_connection)))
        show_error(mysql_error());

    echo '<select name="'.$name.'">';
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

function language_edit($selected=-1,$add_any=FALSE,$name='lng',$disabled=array()){
    global $lang_name;

    reset($lang_name);

    echo '<select name="'.$name.'">';
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
    if (!mysql_query('INSERT '.$table_prepend_name.$table_page.' set name="'.$name.'", type="'.$type.'", file="'.$file.'",description="'.$description.'",keywords="'.$keywords.'",category='.$category.',lng='.$lng.($page!=-1?', id='.$page:''))){
        show_error("Can't create page! (".mysql_error().')');
        exit;
    }
    if (!$id_result=mysql_query('SELECT id from '.$table_prepend_name.$table_page.' where  name="'.$name.'" and type="'.$type.'" and file="'.$file.'" and description="'.$description.'" and keywords="'.$keywords.'" and category='.$category.' and lng='.$lng.($page!=-1?' and id='.$page:''))){
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

function make_url($id,$lng){
    global $base_path;
    return $base_path.'../main.php/id='.$id.'/lng='.$lng;
}

?>