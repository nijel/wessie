# phpMyAdmin MySQL-Dump
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (unofficial)
#
# Host: localhost
# Generation Time: June 26, 2001, 8:17 pm
# Server version: 3.23.38-log
# Database : wss
# --------------------------------------------------------

#
# Table structure for table 'advert'
#

DROP TABLE IF EXISTS advert;
CREATE TABLE `advert` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `code` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table 'advert'
#

INSERT INTO advert VALUES ( '1', 'WSS banner', '<a href=\"http://cicom.tsx.org\"><img src=\"img/WSS_banner.png\" border=0 width=468 height=60 alt=\"This site is using WSS\"></a>');
# --------------------------------------------------------

#
# Table structure for table 'article'
#

DROP TABLE IF EXISTS article;
CREATE TABLE `article` (
  `content` text NOT NULL,
  `last_change` timestamp(14) NOT NULL,
  `page` smallint(5) unsigned NOT NULL default '0',
  `lng` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`page`,`lng`)
) TYPE=MyISAM;

#
# Dumping data for table 'article'
#

INSERT INTO article VALUES ( '<h1>Welcome to WSS</h1>\r\n<h2>WSS was successfully installed and is working</h2>\r\nWeb Site System was installed on this site, but no content wasn\'t (probably) added yet.<br>\r\nWSS home page can be found on <a href=\"http://cicom.tsx.org\"><b>cicom.tsx.org</b></a>.\r\n\r\n<h2>VERY quick guide how to manage WSS</h2>\r\n\r\n<p>If you are looking for administration check <a href=\"admin\">this</a> link. Default\r\nadministrator can login with name <code>admin</code> and password <code>admin</code>. <b>\r\nIt is highly recommended\r\nto change password to not so easilly guessable password (<code>admin:admin</code> is really NOT a good choice for future).</b>\r\n\r\n<p>Here you can download readme file:<br>\r\n<?phpdownload(1)?>\r\n<p>Here you can download beta distribution:<br>\r\n<?phpdownload(2)?>\r\n<p>And here you can download cicom site:<br>\r\n<?phpdownload(3)?>\r\n<p>And here you can download CodeConv 2.6 with Updater 1.1:<br>\r\n<?phpdownload(4)?>\r\n', '20010612135336', '1', '0');
INSERT INTO article VALUES ( 'Information about Web Site System:<br>\n<table>\n<tr><th>\nWSS version\n</th><td>\n<?php echo $wss_version?>\n</td></tr>\n<tr><th>\nWSS author\n</th><td>\n<?php echo $wss_author?> &lt;<?php echo $wss_author_email?>&gt;\n</td></tr>\n<tr><th>\nWSS home page\n</th><td>\n<?php echo $wss_url?>\n</td></tr>\n</table><br>\nInformation about this server:<br>\n<table>\n<tr><th>\nSoftware\n</th><td>\n<?php echo $SERVER_SOFTWARE?>\n</td></tr>\n<tr><th>\nSignature\n</th><td>\n<?php echo $SERVER_SIGNATURE?>\n</td></tr>\n<tr><th>\nProtocol\n</th><td>\n<?php echo $SERVER_PROTOCOL?>\n</td></tr>\n<tr><th>\nName\n</th><td>\n<?php echo $SERVER_NAME?>\n</td></tr>\n<tr><th>\nAddress\n</th><td>\n<?php echo $SERVER_ADDR?>\n</td></tr>\n<tr><th>\nPort\n</th><td>\n<?php echo $SERVER_PORT?>\n</td></tr>\n</table><br>\nInformation about this connection:<br>\n<table>\n<tr><th>\nUser agent\n</th><td>\n<?php echo $HTTP_USER_AGENT?>\n</td></tr>\n<tr><th>\nUser browser\n</th><td>\n<?php echo $browser?>\n</td></tr>\n<tr><th>\nUser operating system\n</th><td>\n<?php echo $os?>\n</td></tr>\n<tr><th>\nRequest URI\n</th><td>\n<?php echo $REQUEST_URI?>\n</td></tr>\n<tr><th>\nRemote address\n</th><td>\n<?php echo $REMOTE_ADDR?>\n</td></tr>\n<tr><th>\nHTTP referer\n</th><td>\n<?php echo $HTTP_REFERER?>\n</td></tr>\n</table><br>\nCurrent server time is <?php echo strftime(\'%x\')?>, <?php echo strftime(\'%X\')?><br><br>\n', '20010508224252', '2', '0');
INSERT INTO article VALUES ( 'Information about <?php echo $site_name?>:<br>\nThis site was created by <?php echo $site_author?> &lt;<?php echo $site_author_email?>&gt;. Name of this site is <?php echo $site_name?> and\nit\'s base url is <?php echo $site_home?>. Title of this page is <?phppage_title()?> and it is in category called\n<?phpcategory_name()?>. This site was built using <?php echo $wss_version?>.', '20010508224252', '3', '0');
INSERT INTO article VALUES ( 'Here will be some short help...', '20010508224252', '4', '0');
INSERT INTO article VALUES ( '<h2>Statistics</h2><h3>Operating systems</h3><?phpstat_os()?><h3>Browsers</h3><?phpstat_browser()?>\r\n<h3>Languages</h3>\r\n<?phpstat_langs(2)?>', '20010508224252', '6', '0');
INSERT INTO article VALUES ( '<h2>Weekly statistics</h2><?phpstat_weeks()?>', '20010508224252', '7', '0');
INSERT INTO article VALUES ( '<h2>Daily statistics</h2><?phpstat_days()?>', '20010508224252', '8', '0');
INSERT INTO article VALUES ( '<h2>Hourly statistics</h2><?phpstat_hours()?>', '20010508224252', '9', '0');
INSERT INTO article VALUES ( '<h1>Vítejte v WSS</h1>\r\n<h2>WSS úspì¹nì nainstálovano a je funkèní</h2>\r\nWeb Site System byl nainstalován na tyto stránky, \r\nale ¾adný obsah je¹tì nebyl (pravdìpodobnì) zadán.<br>\r\nVíce informací o WSS najdete na <a href=\"http://cicom.tsx.org\"><b>cicom.tsx.org</b></a>.\r\n\r\n<h2>VELMI struèný návod na spravování WSS</h2>\r\n\r\n<p>Pokud hledate administraci naleznete ji <a href=\"admin\">zde</a>. Po nainstalovani\r\nje zalozen jediny uzivatel se jmenem <code>admin</code> a heslem <code>admin</code>.\r\n<b>Doporucuji toto heslo zmenit na jine, ne tak snadno zjistitelne (<code>admin:admin</code> neni nejlepsi).</b>\r\n\r\n<p>Tady si muzete stahnout readme:<br>\r\n<?phpdownload(1)?>\r\n<p>Stazeni beta distribuce:<br>\r\n<?phpdownload(2)?>\r\n<p>Stazeni webu cicom:<br>\r\n<?phpdownload(3)?>\r\n<p>Stazeni programu CodeConv 2.6 a Updater 1.1:<br>\r\n<?phpdownload(4)?>\r\n', '20010626193301', '1', '1');
INSERT INTO article VALUES ( 'Informace o Web Site System:<br>\r\n<table>\r\n<tr><th>\r\nVerze WSS\r\n</th><td>\r\n<?php echo $wss_version?>\r\n</td></tr>\r\n<tr><th>\r\nAutor WSS \r\n</th><td>\r\n<?php echo $wss_author?> &lt;<?php echo $wss_author_email?>&gt;\r\n</td></tr>\r\n<tr><th>\r\nStránka WSS\r\n</th><td>\r\n<?php echo $wss_url?>\r\n</td></tr>\r\n</table><br>\r\nInformace o serveru:<br>\r\n<table>\r\n<tr><th>\r\nSoftware\r\n</th><td>\r\n<?php echo $SERVER_SOFTWARE?>\r\n</td></tr>\r\n<tr><th>\r\nSignatura\r\n</th><td>\r\n<?php echo $SERVER_SIGNATURE?>\r\n</td></tr>\r\n<tr><th>\r\nProtokol\r\n</th><td>\r\n<?php echo $SERVER_PROTOCOL?>\r\n</td></tr>\r\n<tr><th>\r\nNázev\r\n</th><td>\r\n<?php echo $SERVER_NAME?>\r\n</td></tr>\r\n<tr><th>\r\nAddresa\r\n</th><td>\r\n<?php echo $SERVER_ADDR?>\r\n</td></tr>\r\n<tr><th>\r\nPort\r\n</th><td>\r\n<?php echo $SERVER_PORT?>\r\n</td></tr>\r\n</table><br>\r\nInformace o tomto spojení:<br>\r\n<table>\r\n<tr><th>\r\nUser agent\r\n</th><td>\r\n<?php echo $HTTP_USER_AGENT?>\r\n</td></tr>\r\n<tr><th>\r\nVás prohlízec\r\n</th><td>\r\n<?php echo $browser?>\r\n</td></tr>\r\n<tr><th>\r\nVás operacní systém\r\n</th><td>\r\n<?php echo $os?>\r\n</td></tr>\r\n<tr><th>\r\nPozadované URI\r\n</th><td>\r\n<?php echo $REQUEST_URI?>\r\n</td></tr>\r\n<tr><th>\r\nVzdálená adresa\r\n</th><td>\r\n<?php echo $REMOTE_ADDR?>\r\n</td></tr>\r\n<tr><th>\r\nHTTP referer\r\n</th><td>\r\n<?php echo $HTTP_REFERER?>\r\n</td></tr>\r\n</table><br>\r\nCas serveru je <?php echo strftime(\'%x\')?>, <?php echo strftime(\'%X\')?><br><br>\r\n', '20010605225352', '2', '1');
INSERT INTO article VALUES ( 'Informace o <?php echo $site_name?>:<br>\r\nTyto stránky vytvoril <?php echo $site_author?> &lt;<?php echo $site_author_email?>&gt;. Název tchto stránek je <?php echo $site_name?> a\r\njejich hlavní url je <?php echo $site_home?>. Název této stránky je <?phppage_title()?> a je umísten v kategorii nazvané\r\n<?phpcategory_name()?>. Tyto stránky byly vytvoreny pomocí  <?php echo $wss_version?>.', '20010605225042', '3', '1');
INSERT INTO article VALUES ( 'Zde bude krátká nápoveda', '20010605224827', '4', '1');
INSERT INTO article VALUES ( '<h2>Statistiky</h2>\r\n<h3>Operacní systémy</h3>\r\n<?phpstat_os()?>\r\n<h3>Prohlízece</h3>\r\n<?phpstat_browser()?>\r\n<h3>Jazyky</h3>\r\n<?phpstat_langs(2)?>', '20010605224758', '6', '1');
INSERT INTO article VALUES ( '<h2>Týdení statistiky</h2><?phpstat_weeks()?>', '20010605225438', '7', '1');
INSERT INTO article VALUES ( '<h2>Denní statistiky</h2><?phpstat_days()?>', '20010605224700', '8', '1');
INSERT INTO article VALUES ( '<h2>Hodinové statistiky</h2><?phpstat_hours()?>', '20010605224712', '9', '1');
# --------------------------------------------------------

#
# Table structure for table 'category'
#

DROP TABLE IF EXISTS category;
CREATE TABLE `category` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `short` varchar(20) default NULL,
  `lng` tinyint(3) unsigned NOT NULL default '0',
  `description` varchar(255) default NULL,
  `page` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`,`lng`),
  KEY `page` (`page`)
) TYPE=MyISAM;

#
# Dumping data for table 'category'
#

INSERT INTO category VALUES ( '1', 'Home', 'Home', '0', 'Home', '1');
INSERT INTO category VALUES ( '2', 'WSS', 'WSS', '0', 'Information about Web Site System', '2');
INSERT INTO category VALUES ( '3', '<?php echo $site_name?>', '<?php echo $site_name?>', '0', 'Some information about <?php echo $site_name?>', '3');
INSERT INTO category VALUES ( '4', 'Help', 'Help', '0', 'Help files', '4');
INSERT INTO category VALUES ( '1', 'Úvod', 'Úvod', '1', 'Úvodní stránka', '1');
INSERT INTO category VALUES ( '2', 'WSS', 'WSS', '1', 'Informace o Web Site System', '2');
INSERT INTO category VALUES ( '3', '<?php echo $site_name?>', '<?php echo $site_name?>', '1', 'Pár informací o <?php echo $site_name?>', '3');
INSERT INTO category VALUES ( '4', 'Nápovìda', 'Nápovìda', '1', 'Soubory nápovìdy', '4');
# --------------------------------------------------------

#
# Table structure for table 'discuss'
#

DROP TABLE IF EXISTS discuss;
CREATE TABLE `discuss` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` enum('moderated') default NULL,
  `size` tinyint(3) unsigned NOT NULL default '20',
  `list` enum('inv') default NULL,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table 'discuss'
#

# --------------------------------------------------------

#
# Table structure for table 'download'
#

DROP TABLE IF EXISTS download;
CREATE TABLE `download` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `filename` varchar(100) NOT NULL default '',
  `grp` tinyint(3) unsigned NOT NULL default '0',
  `count` bigint(20) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `count` (`count`),
  KEY `filename` (`filename`)
) TYPE=MyISAM;

#
# Dumping data for table 'download'
#

INSERT INTO download VALUES ( '1', 'README', '0', '0');
INSERT INTO download VALUES ( '2', 'wss.zip', '1', '0');
INSERT INTO download VALUES ( '3', 'cicom.zip', '0', '0');
INSERT INTO download VALUES ( '4', 'files/download/CodeConv_CZ-2.6_Updater_CZ-1.1-setup.exe', '0', '0');
# --------------------------------------------------------

#
# Table structure for table 'download_group'
#

DROP TABLE IF EXISTS download_group;
CREATE TABLE `download_group` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `count` bigint(20) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `count` (`count`)
) TYPE=MyISAM;

#
# Dumping data for table 'download_group'
#

INSERT INTO download_group VALUES ( '1', 'WSS', '0');
# --------------------------------------------------------

#
# Table structure for table 'maillist'
#

DROP TABLE IF EXISTS maillist;
CREATE TABLE `maillist` (
  `lng` tinyint(3) unsigned NOT NULL default '0',
  `mail` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`mail`,`lng`)
) TYPE=MyISAM;

#
# Dumping data for table 'maillist'
#

# --------------------------------------------------------

#
# Table structure for table 'menu'
#

DROP TABLE IF EXISTS menu;
CREATE TABLE `menu` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `description` varchar(100) default NULL,
  `page` smallint(5) unsigned NOT NULL default '0',
  `category` tinyint(3) unsigned NOT NULL default '0',
  `parent` smallint(5) unsigned NOT NULL default '0',
  `expand` tinyint(4) NOT NULL default '1',
  `lng` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`,`lng`),
  KEY `parent` (`parent`)
) TYPE=MyISAM;

#
# Dumping data for table 'menu'
#

INSERT INTO menu VALUES ( '1', NULL, NULL, '1', '1', '0', '1', '0');
INSERT INTO menu VALUES ( '2', NULL, NULL, '4', '4', '0', '1', '0');
INSERT INTO menu VALUES ( '3', NULL, NULL, '2', '2', '0', '1', '0');
INSERT INTO menu VALUES ( '4', NULL, NULL, '5', '2', '3', '1', '0');
INSERT INTO menu VALUES ( '5', NULL, NULL, '3', '3', '0', '1', '0');
INSERT INTO menu VALUES ( '6', '', '', '6', '1', '0', '0', '0');
INSERT INTO menu VALUES ( '7', NULL, NULL, '7', '1', '6', '1', '0');
INSERT INTO menu VALUES ( '8', NULL, NULL, '8', '1', '6', '1', '0');
INSERT INTO menu VALUES ( '9', NULL, NULL, '9', '1', '6', '1', '0');
INSERT INTO menu VALUES ( '1', NULL, NULL, '1', '1', '0', '1', '1');
INSERT INTO menu VALUES ( '2', NULL, NULL, '4', '4', '0', '1', '1');
INSERT INTO menu VALUES ( '3', NULL, NULL, '2', '2', '0', '1', '1');
INSERT INTO menu VALUES ( '4', NULL, NULL, '5', '2', '3', '1', '1');
INSERT INTO menu VALUES ( '5', NULL, NULL, '3', '3', '0', '1', '1');
INSERT INTO menu VALUES ( '6', '', '', '6', '1', '0', '0', '1');
INSERT INTO menu VALUES ( '7', NULL, NULL, '7', '1', '6', '1', '1');
INSERT INTO menu VALUES ( '8', NULL, NULL, '8', '1', '6', '1', '1');
INSERT INTO menu VALUES ( '9', NULL, NULL, '9', '1', '6', '1', '1');
# --------------------------------------------------------

#
# Table structure for table 'note'
#

DROP TABLE IF EXISTS note;
CREATE TABLE `note` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lng` tinyint(3) unsigned NOT NULL default '0',
  `author` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `url` varchar(100) default NULL,
  `web` varchar(100) default NULL,
  `parent` int(10) unsigned NOT NULL default '0',
  `type` enum('normal','allowed','rejected','admin') NOT NULL default 'normal',
  `discuss` smallint(5) unsigned NOT NULL default '1',
  `date` timestamp(14) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `discuss` (`discuss`),
  KEY `parent` (`parent`)
) TYPE=MyISAM;

#
# Dumping data for table 'note'
#

# --------------------------------------------------------

#
# Table structure for table 'page'
#

DROP TABLE IF EXISTS page;
CREATE TABLE `page` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `type` enum('article','file','links') NOT NULL default 'article',
  `file` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `count` bigint(20) unsigned NOT NULL default '0',
  `lng` tinyint(3) unsigned NOT NULL default '0',
  `category` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`,`lng`),
  KEY `count` (`count`)
) TYPE=MyISAM;

#
# Dumping data for table 'page'
#

INSERT INTO page VALUES ( '1', 'Welcome page', 'article', '', 'Welcome page', 'WSS', '1600', '0', '1');
INSERT INTO page VALUES ( '2', 'About', 'article', '', 'Information about Web Site System', 'WSS', '22', '0', '2');
INSERT INTO page VALUES ( '3', '<?php echo $site_name?>', 'article', '', 'Information about <?php echo $site_name?>', '<?php echo $site_name?>', '37', '0', '3');
INSERT INTO page VALUES ( '4', 'Help', 'article', '', 'How to use Web Site System', 'WSS,Help', '47', '0', '4');
INSERT INTO page VALUES ( '6', 'Statistics', 'article', '', 'Statistical page', 'WSS,statistics', '134', '0', '1');
INSERT INTO page VALUES ( '7', 'Weekly statistics', 'article', '', 'Statistical page', 'WSS,statistics', '63', '0', '1');
INSERT INTO page VALUES ( '8', 'Daily statistics', 'article', '', 'Statistical page', 'WSS,statistics', '67', '0', '1');
INSERT INTO page VALUES ( '9', 'Hourly statistics', 'article', '', 'Statistical page', 'WSS,statistics', '56', '0', '1');
INSERT INTO page VALUES ( '1', 'Úvodní stránka', 'article', '', 'Úvodní stránka', 'WSS', '69', '1', '1');
INSERT INTO page VALUES ( '2', 'O aplikaci', 'article', '', 'Informace o Web Site System', 'WSS', '33', '1', '2');
INSERT INTO page VALUES ( '3', '<?php echo $site_name?>', 'article', '', 'Informace o <?php echo $site_name?>', '<?php echo $site_name?>', '41', '1', '3');
INSERT INTO page VALUES ( '4', 'Nápovda', 'article', '', 'Jak pouzívat Web Site System', 'WSS,Help', '48', '1', '4');
INSERT INTO page VALUES ( '6', 'Statistiky', 'article', '', 'Stránka statistik', 'WSS,statistics', '175', '1', '1');
INSERT INTO page VALUES ( '7', 'Týdení statistiky', 'article', '', 'Stránka statistik', 'WSS,statistics', '69', '1', '1');
INSERT INTO page VALUES ( '8', 'Denní statistiky', 'article', '', 'Stránka statistik', 'WSS,statistics', '49', '1', '1');
INSERT INTO page VALUES ( '9', 'Hodinové statistiky', 'article', '', 'Stránka statistik', 'WSS,statistics', '48', '1', '1');
# --------------------------------------------------------

#
# Table structure for table 'stat'
#

DROP TABLE IF EXISTS stat;
CREATE TABLE `stat` (
  `category` enum('total','time','dow','browser','os','week_no','lang') NOT NULL default 'total',
  `item` varchar(20) NOT NULL default '',
  `count` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`category`,`item`)
) TYPE=MyISAM;

#
# Dumping data for table 'stat'
#

INSERT INTO stat VALUES ( 'total', 'hits', '2150');
INSERT INTO stat VALUES ( 'time', '00', '34');
INSERT INTO stat VALUES ( 'time', '01', '0');
INSERT INTO stat VALUES ( 'time', '02', '0');
INSERT INTO stat VALUES ( 'time', '03', '0');
INSERT INTO stat VALUES ( 'time', '04', '0');
INSERT INTO stat VALUES ( 'time', '05', '0');
INSERT INTO stat VALUES ( 'time', '06', '0');
INSERT INTO stat VALUES ( 'time', '07', '0');
INSERT INTO stat VALUES ( 'time', '08', '0');
INSERT INTO stat VALUES ( 'time', '09', '7');
INSERT INTO stat VALUES ( 'time', '10', '0');
INSERT INTO stat VALUES ( 'time', '11', '1');
INSERT INTO stat VALUES ( 'time', '12', '8');
INSERT INTO stat VALUES ( 'time', '13', '7');
INSERT INTO stat VALUES ( 'time', '14', '76');
INSERT INTO stat VALUES ( 'time', '15', '0');
INSERT INTO stat VALUES ( 'time', '16', '3');
INSERT INTO stat VALUES ( 'time', '17', '1');
INSERT INTO stat VALUES ( 'time', '18', '1');
INSERT INTO stat VALUES ( 'time', '19', '19');
INSERT INTO stat VALUES ( 'time', '20', '72');
INSERT INTO stat VALUES ( 'time', '21', '94');
INSERT INTO stat VALUES ( 'time', '22', '300');
INSERT INTO stat VALUES ( 'time', '23', '1556');
INSERT INTO stat VALUES ( 'dow', '1', '70');
INSERT INTO stat VALUES ( 'dow', '2', '386');
INSERT INTO stat VALUES ( 'dow', '3', '21');
INSERT INTO stat VALUES ( 'dow', '4', '1668');
INSERT INTO stat VALUES ( 'dow', '5', '1');
INSERT INTO stat VALUES ( 'dow', '6', '0');
INSERT INTO stat VALUES ( 'dow', '7', '31');
INSERT INTO stat VALUES ( 'browser', 'Links', '2');
INSERT INTO stat VALUES ( 'browser', 'WebTV', '0');
INSERT INTO stat VALUES ( 'browser', 'Lynx', '1');
INSERT INTO stat VALUES ( 'browser', 'MSIE', '2');
INSERT INTO stat VALUES ( 'browser', 'Opera', '22');
INSERT INTO stat VALUES ( 'browser', 'Konqueror', '678');
INSERT INTO stat VALUES ( 'browser', 'Netscape', '0');
INSERT INTO stat VALUES ( 'browser', 'NCSA Mosaic', '0');
INSERT INTO stat VALUES ( 'browser', 'W3C_Validator', '0');
INSERT INTO stat VALUES ( 'browser', 'Nokia Browser', '0');
INSERT INTO stat VALUES ( 'browser', 'NetPositive', '0');
INSERT INTO stat VALUES ( 'browser', 'Amiga', '0');
INSERT INTO stat VALUES ( 'browser', 'Lotus Notes', '0');
INSERT INTO stat VALUES ( 'browser', 'GetRight', '0');
INSERT INTO stat VALUES ( 'browser', 'iCab', '0');
INSERT INTO stat VALUES ( 'browser', 'Amaya', '0');
INSERT INTO stat VALUES ( 'browser', 'Downloader', '0');
INSERT INTO stat VALUES ( 'browser', 'Search Indexer', '0');
INSERT INTO stat VALUES ( 'browser', 'Bot', '0');
INSERT INTO stat VALUES ( 'browser', '?', '1449');
INSERT INTO stat VALUES ( 'os', 'Windows', '0');
INSERT INTO stat VALUES ( 'os', 'WindowsNT', '0');
INSERT INTO stat VALUES ( 'os', 'Amiga', '0');
INSERT INTO stat VALUES ( 'os', 'Linux/Unix', '694');
INSERT INTO stat VALUES ( 'os', 'Mac', '0');
INSERT INTO stat VALUES ( 'os', 'FreeBSD', '0');
INSERT INTO stat VALUES ( 'os', 'SunOS', '0');
INSERT INTO stat VALUES ( 'os', 'IRIX', '0');
INSERT INTO stat VALUES ( 'os', 'BeOS', '0');
INSERT INTO stat VALUES ( 'os', 'OS/2', '0');
INSERT INTO stat VALUES ( 'os', 'AIX', '0');
INSERT INTO stat VALUES ( 'os', '?', '1457');
INSERT INTO stat VALUES ( 'week_no', '0016', '1696');
INSERT INTO stat VALUES ( 'lang', '0', '1776');
INSERT INTO stat VALUES ( 'lang', '1', '368');
INSERT INTO stat VALUES ( 'week_no', '0017', '58');
INSERT INTO stat VALUES ( 'week_no', '0018', '37');
INSERT INTO stat VALUES ( 'week_no', '0019', '30');
INSERT INTO stat VALUES ( 'week_no', '0020', '241');
INSERT INTO stat VALUES ( 'week_no', '0021', '83');
# --------------------------------------------------------

#
# Table structure for table 'users'
#

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user` varchar(20) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `mail` varchar(50) NOT NULL default '',
  `web` varchar(100) NOT NULL default '',
  `web_title` varchar(100) NOT NULL default '',
  `rights` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user` (`user`),
  KEY `user_2` (`user`)
) TYPE=MyISAM;

#
# Dumping data for table 'users'
#

INSERT INTO users VALUES ( '1', 'admin', 'admin', 'Administrator', '', 'http://cicom.kgb.cz', 'CICOM web site - home of WSS', '');

