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
$page_name='Menu:Synchronize';
require_once('./admin_header.php');
?>
<?php

function remove_lng_from($var) {
    global $lng_from;
    return ($var != $lng_from);
}

if (isset($category)&&isset($lng_from)&&isset($lng_to)){
    $target_lng=array();
    if($lng_to=='any'){
        $target_lng = array_keys($languages);
    }else{
        $target_lng[] = $lng_to;
    }
    $target_lng = array_filter($target_lng,'remove_lng_from');

    if (sizeof($target_lng)==0){
        show_error_box('No target languages!');
        include_once('./admin_footer.php');
        exit();
    }

    $insert = isset($overwrite)?'REPLACE ':'INSERT IGNORE ';

    if (!($id_result=(mysql_query('SELECT id,name,description,lng,page,category,parent,expand,rank from '.$db_prepend.$table_menu
            .' where lng='.$lng_from.' and '.($category=='any'?1:('category='.$category)).' order by lng,rank',$db_connection)))&&($child_id=0))
        do_error(1,'SELECT '.$db_prepend.$table_menu.': '.mysql_error());

    echo 'Synchronization progress:<pre>';
    while ($item = mysql_fetch_array ($id_result)){
        echo 'Synchonising menu item id=' . $item['id'] .': ';

        reset ($target_lng);
        while (list ($key, $lng) = each ($target_lng)) {
            if (!($id2_result=(mysql_query($insert . $db_prepend.$table_menu.' values ('.$item['id'].','.(isset($item['name'])?'"'.$item['name'].'"':'NULL').','.(isset($item['description'])?'"'.$item['description'].'"':'NULL').','.$item['page'].','.$item['category'].','.$item['parent'].','.$item['expand'].','.$lng.','.$item['rank'].')',$db_connection)))&&($child_id=0))
                do_error(1,'SELECT '.$db_prepend.$table_menu.': '.mysql_error());
            echo '...to language ' . $lang_name[$lng] . '-' . (isset($overwrite)?'synchronized':(mysql_affected_rows()==1?'added':'already exists'));
        }
        echo "\n";
    }
    echo '</pre>';
    mysql_free_result($id_result);
    show_info_box('Menu items synchronized',array(),isset($HTTP_REFERER)?$HTTP_REFERER:'menu.php');
    include_once('./admin_footer.php');
    exit;
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}
require_once('./admin_footer.php');
?>
