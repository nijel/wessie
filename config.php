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
error_reporting (E_ALL);
// Config script for wessie
// Lines with //## are not needed, but they allow to keep a bit of order
// in this file, when it is being modified by php script.
// While editing by hand, please keep each option on separate line and
// use single quotes (') for strings, otherwise editing via web may be broken.

// MySQL database settings
//##DATABASE##
// $db_host            - host where to connect
// $db_user            - username
// $db_pass            - password
// $db_name            - name of database
// $db_persistent      - use persistant connections?
// $db_prepend         - prepended before each table name, this allows multiple
//                       wessies running on one database
$db_host = 'localhost';
$db_user = 'wessie';
$db_pass = 'wessie';
$db_name = 'wessie';
$db_persistent = TRUE;
$db_prepend = '';
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
// $default_lang       - fallback language, when detection from Accept-language fails
// $lang_file          - name of file with language-specific data, you can use inside
//                       any php variables, that will be in time of evaluation
//                       accessible, for example ${lang} = language shortcut,
//                       ${lng} = language id
// $languages array    - data about languages:
//              short  - shortcut - this should be the official one = same as
//                       send browser as Accept-language
//              name   - names of languages, just for displaying
//              page   - default page for language
//              image  - path (relative to root of wessie) to image for earch language
// $lang_alias array   - used for decoding from Accept-language and PATH_INFO
$default_lang = 0;
$lang_file = './lang/${lang}.php';
$languages[0]['short'] = 'en';
$languages[0]['name'] = 'English';
$languages[0]['image'] = 'img/flags/en.png';
$languages[0]['page'] = '1';
$lang_alias['en'] = 0;
$languages[1]['short'] = 'cs';
$languages[1]['name'] = 'Cesky';
$languages[1]['image'] = 'img/flags/cs.png';
$languages[1]['page'] = '1';
$lang_alias['cs'] = 1;
$lang_alias['cz'] = 1;
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


// all table names are fully customisable
//##TABLES##
// $table_*            - name for each table
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
// $top_pages_count    - number of top pages to display
$template_name = 'default';
$site_logo = 'img/wessie.png';
$site_logo_alt = 'wessie - web site system';
$site_logo_width = 200;
$site_logo_height = 100;
$category_order = 'id';
$use_adverts = TRUE;
$top_pages_count = 4;
//##/DESIGN##

// some information about site
//##INFO##
// $site_home          - home of site, this doesn't have to be directory (or server)
//                       where wessie is installed, it should be really home
//                       page of your site
// $site_started       - time where site was started, used for weekly statisctics
// $site_author_email  - authors email
// $site_author array  - array of authors names for each language
// $site_name array    - array of site names for each language
// $site_name_long array - array of long site names for each language
// $copyright array    - array of copyrights for each language
// $special array      - array of special info that is displayed on top of each page
$site_home = 'http://wessie.cic';
$site_started = mktime(0,0,0,1,13,2001); //Recommended to be time 0:0:0
$site_author_email = 'cihar@email.cz';
$site_author[0] = 'Michal Cihar';
$site_author[1] = 'Michal Èihaø';
$site_name[0] = 'wessie Demo';
$site_name[1] = 'ukázka wessie';
$site_name_long[0] = 'demonstration how wessie can work';
$site_name_long[1] = 'ukázka jak mù¾e wessie pracovat';
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
// $admin_confirm_uninstall - confirm uninstalling in administration?
// $admin_validator    - link to validate page, at the end is appended url
// $admin_file_restrict - restrict including of files only to webserver tree
//                        (this cannot handle rewrites or simmilar methods,
//                        this takes affect only when selecting file using
//                        browse dialog and SHOULD affect plugins that read
//                        files from disk)
// $admin_two_step_login - ensures login to work even if there is something broken
//                        and clients accepts only one cookie per request
// $admin_force_ssl    - force using https for administration
$admin_charset = 'iso-8859-2';
$admin_default_css = 'admin_blue.css';
$admin_timeout = '20 MINUTE';
$admin_user_cookie = 2592000;
$admin_hash_cookie = 3600;
$admin_confirm_delete = TRUE;
$admin_confirm_uninstall = TRUE;
$admin_validator = 'http://validator.cic/cgi-bin/validate.cgi?input=yes&amp;url=';
$admin_file_restrict = TRUE;
$admin_two_step_login = TRUE;
$admin_force_ssl = FALSE;
//##/ADMIN##

// file management options
//##ADMIN_FILES##
// $admin_fm_restrict   - restrict file management only to webserver tree
//                        (this cannot handle rewrites or simmilar methods)
// $admin_fm_show_*     - which columns to show in file management
// $admin_fm_quickjump  - links to often used folder, if staring with / path
//                        is used as absolute otherwise as relative from
//                        web server root
// $admin_fm_maxsize    - maximal size of upload in admnistration, this doe
//                        cannot be larget than upload_max_filesize in php.ini!
$admin_fm_restrict = FALSE;
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
$admin_fm_confirm_delete = TRUE;
$admin_fm_mkdir_mode = 0777;
//##/ADMIN_FILES##


//size of edits in administration
//##ADMIN_SIZES##
// $admin_fallback_size - fallback is used when no other fit
$admin_fallback_size = 5;
$admin_name_size = 80;
$admin_short_size = 80;
$admin_filename_size = 80;
$admin_content_rows = 30;
$admin_content_cols = 80;
$admin_keywords_rows = 2;
$admin_keywords_cols = 80;
$admin_description_rows = 2;
$admin_description_cols = 80;
$admin_help_width=600;
$admin_help_height=400;
//##/ADMIN_SIZES##

//##PLUGIN_COMMON##
$allow_content_eval = TRUE;
$installed_plugins = array('bullshit', 'article', 'file');
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

//try to set colors for php syntax highlighting
//##HIGHLIGHT_OPTIONS##
// default values (probably, just taken from my php.ini):
// highlight.string        =       #DD0000
// highlight.comment       =       #FF8000
// highlight.keyword       =       #007700
// highlight.bg            =       #FFFFFF
// highlight.default       =       #0000BB
// highlight.html          =       #000000
ini_set('highlight.string', '#DD00DD');
ini_set('highlight.comment', '#FF8000');
ini_set('highlight.keyword', '#00DD00');
ini_set('highlight.bg', '#FFFFFF');
ini_set('highlight.default', '#0000EE');
ini_set('highlight.html', '#DDDDDD');
//##/HIGHLIGHT_OPTIONS##
?>
