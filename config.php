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
error_reporting (E_ALL);
// Config script for wessie
// lines like following are not needed, but they allows to keep a bit of order
// in this file, when it is being modified by php script

//##DATABASE##
// MySQL database settings
// $db_host            - host where to connect
// $db_user            - username
// $db_pass            - password
// $db_name            - name of database
// $db_persistent      - use persistant connections?
$db_host = 'localhost';
$db_user = 'wessie';
$db_pass = 'wessie';
$db_name = 'wessie';
$db_persistent = TRUE;
//##/DATABASE##

//##ERRORS##
// $error_log_file     - error log filename, this path must be absolute and file
//                       must be writable by user under which scripts will run
// $show_error_detail  - show error details on error page, if disabled just
//                       comment is added
$error_log_file = '/vs/wessie/logs/error.log';
$show_error_detail = TRUE;
//##/ERRORS##

//##LANGUAGES##
// $languages array    - shortcuts for languages, they should be official = same as
//                       send browser as Accept-language
// $lang_name array    - names of languages, just for displaying
// $lang_img array     - path (relative to root of wessie) to image for earch language
// $lang_alias array   - used for decoding from Accept-language and PATH_INFO
// $default_lang       - fallback language, when detection from Accept-language fails
// $lang_file          - name of file with language-specific data, you can use inside
//                       any php variables, that will be in time of evaluation
//                       accessible, for example ${lang} = language shortcut,
//                       ${lng} = language id
$languages[0] = 'en';
$lang_name[0] = 'English';
$lang_img[0] = 'img/flags/en.png';
$lang_main_page[0] = 1;
$languages[1] = 'cs';
$lang_name[1] = 'Cesky';
$lang_img[1] = 'img/flags/cs.png';
$lang_main_page[1] = 1;
$default_lang = 0;
$lang_alias['en'] = 0;
$lang_alias['cs'] = 1;
$lang_alias['cz'] = 1;
$lang_file = './lang/${lang}.php';
//##/LANGUAGES##

//##COOKIES##
// $cookie_count       - name of cookie that is used for counting user visits
// $cookie_lang        - name of cookie that is used for storing user prefered language
// $session_time       - how long takes one session - by default when user didn't load
//                       any page from site then he is counted as new
// $lang_time          - how long will stay cookie identifying preffered user's language
$cookie_count = 'wessie_count';
$cookie_lang = 'wessie_lang';
$session_time = 3600;
$lang_time = 31536000;
//##/COOKIES##


//##TABLES##
// all table names are fully customisable
// $table_prepend_name - prepended before each table name, this allows multiple
//                       wessies running on one database
// $table_*            - name for each table
$table_prepend_name = '';

$table_page = 'page';
$table_category = 'category';
$table_advert = 'advert';
$table_menu = 'menu';
$table_article = 'article';
$table_download = 'download';
$table_download_group = 'download_group';
$table_users = 'users';
$table_stat = 'stat';
//##/TABLES##

//##DESIGN##
// $template_name      - name of used template, it must be in templates directory
//                       this name can contain any php variable that is defined in time
//                       of evaulating, for example ${lang}=language shortcut,
//                       ${lng}=language id
// $site_logo          - logo of site
// $site_logo_alt      - alt for logo
// $site_logo_width    - width of that logo
// $site_logo_height   - height of that logo
// $category_order     - which field in database is used for ordering categories
// $use_adverts        - use advertisement?
$template_name = 'default';
$site_logo = 'img/wessie.png';
$site_logo_alt = 'wessie - web site system';
$site_logo_width = 200;
$site_logo_height = 100;
$category_order = 'id';
$use_adverts = TRUE;
//##/DESIGN##

//##INFO##
// some information about site
// $site_home          - home of site, this doesn't have to be directory (or server)
//                       where wessie is installed, it should be really home
//                       page of your site
// $site_started       - time where site was started, used for weekly statisctics
// $site_author_email  - authors email
// $site_author array  - array of authors names for each language
// $site_name array    - array of site names for each language
// $copyright array    - array of copyrights for each language
// $special array      - array of special info that is displayed on top of each page
$site_home = 'http://wessie.cic';
$site_started = mktime(0,0,0,1,13,2001); //Recommended to be time 0:0:0
$site_author_email = 'cihar@email.cz';
$site_author[0] = 'Michal Cihar';
$site_author[1] = 'Michal �iha�';
$site_name[0] = 'wessie Demo';
$site_name[1] = 'uk�zka wessie';
$copyright[0] = 'Copyright &copy; 2001-2002 <a href="mailto:'.$site_author_email.'">'.$site_author[0].'</a>';
$copyright[1] = 'Copyright &copy; 2001-2002 <a href="mailto:'.$site_author_email.'">'.$site_author[1].'</a>';
$special[0] = '';
$special[1] = '';
//##/INFO##


//##ADMIN##
// $admin_charset      - charset in administration
// $admin_timeout      - how long is logged in admin valid, used in SQL query so
//                       check MySQL documentation for details on time specification
// $admin_user_cookie  - how long should be cookie with username valid
// $admin_hash_cookie  - how long should be cookie with hash valid, this doesn't affect
//                       security, security is made by $admin_timeout
// $admin_confirm_delete - confirm deleting in administration?
// $admin_validator    - link to validate page, at the end is appended url
$admin_charset = 'iso-8859-2';
$admin_timeout = '20 MINUTE';
$admin_user_cookie = 2592000;
$admin_hash_cookie = 3600;
$admin_confirm_delete = TRUE;
$admin_validator = 'http://validator.cic/cgi-bin/validate.cgi?input=yes&amp;url=';
//##/ADMIN##

//##ADMIN_FILES##
// file management options
// $admin_fm_restrict   - restrict file management only to webserver tree
//                        (this cannot handle rewrites or simmilar methods)
// $admin_fm_show_*     - which columns to show in file management
// $admin_fm_quickjump  - links to often used folder, if staring with / path
//                        is used as absolute otherwise as relative from
//                        web server root
// $admin_fm_maxsize    - maximal size of upload in admnistration, this doe
//                        cannot be larget than upload_max_filesize in php.ini!
$admin_fm_restrict = TRUE;
$admin_fm_show_size = TRUE;
$admin_fm_show_type = TRUE;
$admin_fm_show_mtime = TRUE;
$admin_fm_show_ctime = FALSE;
$admin_fm_show_atime = FALSE;
$admin_fm_show_allowed = TRUE;
$admin_fm_show_rights = FALSE;
$admin_fm_show_owner = FALSE;
$admin_fm_show_group = FALSE;
$admin_fm_quickjump = array('files');
$admin_fm_maxsize = 10485760;
//##/ADMIN_FILES##


//##ADMIN_SIZES##
//size of edits in administration
$admin_name_size = 80;
$admin_short_size = 80;
$admin_filename_size = 80;
$admin_content_rows = 30;
$admin_content_cols = 80;
$admin_keywords_rows = 2;
$admin_keywords_cols = 80;
$admin_description_rows = 2;
$admin_description_cols = 80;
//##/ADMIN_SIZES##

//##PLUGIN_COMMON##
$allow_content_eval = TRUE;
//##/PLUGIN_COMMON##

//plugin configuration:
//##PLUGIN_ALLOWED##
$allowed_page_plugins = array('article','bullshit','file');
$allowed_function_plugins = array('bullshit','icons');
//##/PLUGIN_ALLOWED##

//allow or deny of evaling of content for each plugin
//##PLUGIN_OPTIONS##
$page_plugins_options['article']['eval'] = TRUE;
$page_plugins_options['file']['eval'] = FALSE;
$page_plugins_options['bullshit']['eval'] = FALSE;
//##/PLUGIN_OPTIONS##
?>
