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

$page_name='User:Edit';
require_once('./admin_header.php');

if (isset($action) && ($action=='save')){
    if ($user_pass_1 != $user_pass_2) {
        show_error('Both passowrds must be same!');
        exit;
    }
    if ($user_pass_1 != ''){
        $pwd = ',pass="'.md5($user_pass_1).'"';
    } else {
        $pwd = '';
    }
    if ($id == 'admin') $user_name='admin';
    if (!mysql_query('UPDATE '.$table_prepend_name.$table_users.' set user="'.$user_name.'",name="'.$name.'",mail="'.$user_mail.'",web="'.$user_web.'",perms="'.implode(':',$user_perms).'"'.$pwd.' WHERE user="'.$id.'"')){
        show_error("Can't save user info! (".mysql_error().')');
        exit;
    }
    show_info_box('User saved',array('id'=>$id));
    include_once('./admin_footer.php');
    exit;
}elseif(isset($action) && ($action=='create_new')){
    if ($user_pass_1 != $user_pass_2) {
        show_error('Both passowrds must be same!');
        exit;
    }
    if ($user_pass_1 == ''){
        show_error('You must set password for new user!');
        exit;
    } else {
        $pwd = ',pass="'.md5($user_pass_1).'"';
    }
    if (!mysql_query('INSERT '.$table_prepend_name.$table_users.' set user="'.$user_name.'",name="'.$name.'",mail="'.$user_mail.'",web="'.$user_web.'",perms="'.implode(':',$user_perms).'"'.$pwd)){
        show_error("Can't save user info! (".mysql_error().')');
        exit;
    }
    show_info_box('User created',array('id'=>$user_name));
    include_once('./admin_footer.php');
    exit;
}elseif (isset($action) && ($action=='new')){
    $action='create_new';
    $userdata=array('name'=>'','user'=>'','mail'=>'','web'=>'','perms'=>'index.php:help.php:user_self.php');
}elseif (isset($id)){
    $action='save';
    if (!$id_result=mysql_query(
    'SELECT * '.
    ' from '.$table_prepend_name.$table_users.
    ' where user="'.$id.'"'))
        show_error("Can't select user! (".mysql_error().')');
    $userdata=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($userdata['user'])){
        show_error_box("This user doesn't  exist!");
        exit();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

$userdata['perms_arr'] = explode(':',$userdata['perms']);;
?>

<form action="user_edit.php" method="post" name="edit">
<input type="hidden" name="action" value="<?php echo $action?>" />
<table class="item">
<tr><th>
User name:
</th><td>
<input type="text" name="user_name" <?php echo ($userdata['user']=='admin')?'class="text_disabled" disabled="disabled"':'class="text"';?> value="<?php echo htmlspecialchars($userdata['user']);?>" />
<input type="hidden" name="id" value="<?php echo htmlspecialchars($userdata['user']);?>" />
</td></tr>
<tr><th>
Name:
</th><td>
<input type="text" name="name" class="text" value="<?php echo htmlspecialchars($userdata['name']);?>" />
</td></tr>
<tr><th>
<tr><th>
Password:
</th><td>
<input type="password" name="user_pass_1" class="password" />
</td></tr>
<tr><th>
Re-type:
</th><td>
<input type="password" name="user_pass_2" class="password" />
</td></tr>
<tr><th>
Mail:
</th><td>
<input type="text" name="user_mail" class="text" value="<?php echo htmlspecialchars($userdata['mail']);?>" />
</td></tr>
<tr><th>
Web:
</th><td>
<input type="text" name="user_web" class="text" value="<?php echo htmlspecialchars($userdata['web']);?>" />
</td></tr>
<tr><th>
Permissions:
</th><td>
<?php
$allperms=array(
    'category.php',
    'category_delete.php',
    'category_edit.php',
    'download_group.php',
    'download_group_delete.php',
    'download_group_edit.php',
    'download_item.php',
    'download_item_delete.php',
    'download_item_edit.php',
    'file_list.php',
    'files.php',
    'files_action.php',
    'files_upload.php',
    'help.php',
    'index.php',
    'menu.php',
    'menu_delete.php',
    'menu_edit.php',
    'menu_sync.php',
    'options.php',
    'options_admin.php',
    'options_databae.php',
    'options_design.php',
    'options_errors.php',
    'options_info.php',
    'options_languages.php',
    'page.php',
    'page_delete.php',
    'page_edit.php',
    'page_list.php',
    'plugin.php',
    'plugin_help.php',
    'plugin_status.php',
    'user.php',
    'user_delete.php',
    'user_edit.php',
    'user_self.php');

if ($userdata['user']=='admin'){
    echo 'Administrator has automatically permission to do anything';
} else {
    while (list($key,$val) = each($allperms)){
        echo '<label clas="checks"><input class="check" type="checkbox" '.(in_array($val,$userdata['perms_arr'])?'checked="checked"':'').' name="user_perms[]" value="'.$val.'" />'.$val.'</label><br />';
    }
    echo "<a href=\"javascript:set_checkboxes('edit','user_perms[]',1);\">Check all</a>&nbsp;|&nbsp;<a href=\"javascript:set_checkboxes('edit','user_perms[]',0);\">Uncheck all</a>";
}
?>
</td></tr>
<tr><th>
</th><td>
<table class="savereset">
  <tr>
    <td><input type="submit" value=" Save " class="save" /></td>
    <td><input type="reset" value=" Reset " class="reset" /></td>
  </tr>
</table>
</td></tr>
</table>

</form>
<?php
require_once('./admin_footer.php');
?>