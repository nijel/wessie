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
// Config script for WSS
if (!isset($WSS_config_php_loaded)){
$WSS_config_php_loaded=1;

$error_log_file='./logs/error.log';

$site_started=mktime(0,0,0,1,13,2001); //Recommended to be time 0:0:0

$languages[0]='en';
$lang_name[0]='English';
$lang_main_page[0]=1;
$languages[1]='cs';
$lang_name[1]='Cesky';
$lang_main_page[1]=1;
$default_lang=0;
//language file, use ${lang} for specifying language name
$lang_file='./lang/${lang}.php';

//Site main design template (defaultly language independant or use ${lang} for specifying language name):
$template_file='./templates/default/template.php';

$cookie_count='wss_count';
$cookie_lang='wss_lang';

$session_time=3600;  // how long $cookie_count should be held (1 hour)
$lang_time=31536000;  // how long $cookie_lang should be held (1 year)

$db_host='localhost'; // Host where MySQL is running
$db_user='root'; // User name
$db_pass=''; // User password
$db_name='wss'; // Database name that is used by WSS
$db_persistent=false; //true = use persistent connections, otherwise don't use

$table_prepend_name=''; //prepended before each table name this allows multiple WSS running on one database

// if you change following variables, you have to chage table names in MySQL!
$table_page='page';
$table_category='category';
$table_advert='advert';
$table_menu='menu';
$table_article='article';
$table_product='product';
$table_download='download';
$table_download_group='download_group';
$table_prog_lng='prog_lng';
$table_prod_cat='prod_cat';
$table_link='link';
$table_link_cat='link_cat';
$table_discuss='discuss';
$table_note='note';
$table_users='users';
$table_maillist='maillist';
$table_stat='stat';

$site_author='Michal Cihar';
$site_author_email='cihar@email.cz';

$site_home='http://wss.cic';
$site_name='WSS Demo';

$copyright='Copyright &copy; 2001 <a href="mailto:'.$site_author_email.'">'.$site_author.'</a>';

// Content of this variable is inserted on EACH page before content
// You can ye this for some special actions
$special='';

//whether site wants adverts
$use_adverts=true;

//charset in administration
$admin_charset='iso-8859-2';

//how long is logged in admin valid, check MySQL documentation for details on time specification
$admin_timeout='20 MINUTE';

//size of edits in administration
$admin_name_size=40;  //page name
$admin_content_rows=10;
$admin_content_cols=40;
$admin_keywords_rows=2;
$admin_keywords_cols=40;
$admin_description_rows=2;
$admin_description_cols=40;

$admin_confirm_delete=TRUE;
}
?>
