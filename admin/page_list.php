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

$page_name='Pages';
require_once('./page_header.php');

if (!isset($type)) {
    show_error_box('Error: Bad parameters!');
    include_once('./admin_footer.php');
} else {
    $edit_url='page_edit.php?type='.$type;
    $delete_url='page_delete.php?type='.$type;
    $edit_action='page_edit.php';
    $filter_action='page_list.php';
    $form_magic='<input type="hidden" name="type" value="'.$type.'"/>'."\n";

    if (file_exists('../plugins/'.$type.'/admin_list.php')){
        require_once('../plugins/'.$type.'/admin_list.php');
    } else {
        show_error_box('Error: Selected plugin ("'.$type.'") not accessible!');
        include_once('./admin_footer.php');
        exit;
    }
}

require_once('./admin_footer.php');
?>