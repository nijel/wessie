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

$page_name='User:Own info';
require_once('./admin_header.php');
require_once('./user_common.php');

if (isset($action) && ($action=='save')){
    if ($user_pass_1 != $user_pass_2) {
        show_error('Both passwords must be same!');
        exit;
    }
    if ($user_pass_1 != ''){
        $pwd = ',pass="'.md5($user_pass_1).'"';
    } else {
        $pwd = '';
    }
    if (!mysql_query('UPDATE '.$db_prepend.$table_users.' set name="'.$name.'",mail="'.$user_mail.'",web="'.$user_web.'"'.$pwd.' WHERE user="'.$user.'"')){
        show_error("Can't save user info! (".mysql_error().')');
        exit;
    }
    show_info_box('User saved',array());
    include_once('./admin_footer.php');
    exit;
}else{
    $id=$user;
    $action='save';
    if (!$id_result=mysql_query(
    'SELECT * '.
    ' from '.$db_prepend.$table_users.
    ' where user="'.$id.'"'))
        show_error("Can't select user! (".mysql_error().')');
    $userdata=mysql_fetch_array($id_result);
    mysql_free_result($id_result);
    if (!isset($userdata['user'])){
        show_error_box("This user doesn't  exist!");
        exit();
    }
}

$userdata['perms_arr'] = explode(':',$userdata['perms']);;
?>

<form action="user_self.php" method="post" name="edit">
<input type="hidden" name="action" value="<?php echo $action?>" />
<table class="item">
<tr><th>
User name:
</th><td>
<input type="text" name="user_name" class="text_disabled" disabled="disabled" value="<?php echo htmlspecialchars($userdata['user']);?>" />
</td></tr>
<tr><th>
Name:
</th><td>
<input type="text" name="name" class="text" value="<?php echo htmlspecialchars($userdata['name']);?>" />
</td></tr>
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

if ($userdata['user']=='admin'){
    echo 'Administrator has automatically permission to do anything';
} else {
    while (list($key,$val) = each($allperms)){
        echo '<label class="checks"><input class="check_disabled" disabled="disabled" type="checkbox" '.(in_array($val,$userdata['perms_arr'])?'checked="checked"':'').' name="user_perms[]" value="'.$val.'" />'.$val."</label><br />\n";
    }
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