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

$page_name='User:Delete';
require_once('./admin_header.php');
require_once('./user_common.php');

function delete_user(){
    global $id,$lng,$db_prepend,$table_users;

    if ($id == 'admin'){
        show_error('User admin can NOT be deleted!');
        exit;
    }

    if (!mysql_query('DELETE FROM '.$db_prepend.$table_users.' where id="'.$id.'" limit 1')){
        show_error("Can't delete user! (".mysql_error().')');
        exit;
    }
    show_info_box('User deleted',array(),'user.php');
    include_once('./admin_footer.php');
    exit;
}

if (isset($action) && ($action=='delete') && isset($id)){
    delete_user();
}elseif (isset($id)){
    if ($admin_confirm_delete){
    } else {
        delete_user();
    }
}else{
    show_error_box();
    include_once('./admin_footer.php');
    exit();
}

if ($id == 'admin'){
    show_error('User admin can NOT be deleted!');
    exit;
}

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


$userdata['perms_arr'] = explode(':',$userdata['perms']);;
?>

Do you want to delete user <?php echo $id;?>?<br />
<table class="yesno">
  <tr>
    <td>
<form action="user_delete.php" method="post" class="delete">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="action" value="delete" />
<input type="submit" value=" Yes " class="delete" />
</form>
    </td>
    <td><?php make_return_button(' No ');?> </td>
  </tr>
</table>

<table class="item">
<tr><th>
User name:
</th><td>
<?php echo htmlspecialchars($userdata['user']);?>
</td></tr>
<tr><th>
Name:
</th><td>
<?php echo htmlspecialchars($userdata['name']);?>
</td></tr>
<tr><th>
Mail:
</th><td>
<?php echo htmlspecialchars($userdata['mail']);?>
</td></tr>
<tr><th>
Web:
</th><td>
<?php echo htmlspecialchars($userdata['web']);?>
</td></tr>
<tr><th>
Permissions:
</th><td>
<form action="user_delete.php" method="get">
<?php
while (list($key,$val) = each($allperms)){
    echo '<label class="checks"><input class="check_disabled" disabled="disabled" type="checkbox" '.(in_array($val,$userdata['perms_arr'])?'checked="checked"':'').' name="user_perms[]" value="'.$val.'" />'.$val."</label><br />\n";
}
?>
</form>
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

<?php
require_once('./admin_footer.php');
?>