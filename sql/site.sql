# phpMyAdmin MySQL-Dump
# version 2.2.1-dev
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Host: localhost
# Generation Time: Nov 24, 2001 at 10:35 PM
# Server version: 3.23.42
# PHP Version: 4.0.7RC2
# Database : `wessie`
# --------------------------------------------------------

#
# Table structure for table `advert`
#

DROP TABLE IF EXISTS advert;
CREATE TABLE advert (
  id tinyint(3) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  code text NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `advert`
#

INSERT INTO advert VALUES (1,'wessie banner','<a href="http://cicom.kgb.cz"><img src="http://cicom.kgb.cz/wessie_img/wessie_banner.png" border="0" width="468" height="60" alt="This site is using wessie" /></a>');
# --------------------------------------------------------

#
# Table structure for table `article`
#

DROP TABLE IF EXISTS article;
CREATE TABLE article (
  content text NOT NULL,
  last_change timestamp(14) NOT NULL,
  page smallint(5) unsigned NOT NULL default '0',
  lng tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (page,lng)
) TYPE=MyISAM;

#
# Dumping data for table `article`
#

INSERT INTO article VALUES ('<h1>Welcome to wessie</h1>\r\n\r\n<h2>wessie was successfully installed and is working</h2>\r\n\r\nWeb Site System was installed on this site, but no content wasn\'t\r\n(probably) added yet.<br />\r\nwessie home page can be found on <a href=\r\n"http://cicom.tsx.org"><b>cicom.tsx.org</b></a>.\r\n\r\n<h2>VERY quick guide how to manage wessie</h2>\r\n\r\n<p>If you are looking for administration check <a href=\r\n"admin">this</a> link. Default administrator can login with name\r\n<code>admin</code> and password <code>admin</code>. <b>It is highly\r\nrecommended to change password to not so easilly guessable password\r\n(<code>admin:admin</code> is really NOT a good choice for\r\nfuture).</b></p>\r\n\r\n<p>Here you can download readme file:<br />\r\n<?php download(1); ?>\r\n</p>\r\n\r\n<p>Here you can download beta distribution:<br />\r\n<?php download(2); ?>\r\n</p>\r\n\r\n<p>And here you can download cicom site:<br />\r\n<?php download(3); ?>\r\n</p>\r\n\r\n<p>And here you can download CodeConv 2.6 with Updater 1.1:<br />\r\n<?php download(4); ?>\r\n</p>',20011024214700,1,'');
INSERT INTO article VALUES ('Information about wessie:<br />\r\n<table>\r\n<tr>\r\n<th>wessie version</th>\r\n<td><?php echo $wessie_version; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>wessie author</th>\r\n<td><?php echo $wessie_author; ?>\r\n&lt;<?php echo $wessie_author_email; ?>\r\n&gt;</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>wessie home page</th>\r\n<td><?php echo $wessie_url; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>wessie icon:</th>\r\n<td><?php wessie_icon(); ?>\r\n</td>\r\n</tr>\r\n\r\n</table>\r\n\r\n<br />\r\nInformation about this server:<br />\r\n<table>\r\n<tr>\r\n<th>Software</th>\r\n<td><?php echo $SERVER_SOFTWARE; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>Signature</th>\r\n<td><?php echo $SERVER_SIGNATURE; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>Protocol</th>\r\n<td><?php echo $SERVER_PROTOCOL; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>Name</th>\r\n<td><?php echo $SERVER_NAME; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>Address</th>\r\n<td><?php echo $SERVER_ADDR; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>Port</th>\r\n<td><?php echo $SERVER_PORT; ?>\r\n</td>\r\n</tr>\r\n</table>\r\n\r\n<br />\r\nInformation about this connection:<br />\r\n<table>\r\n<tr>\r\n<th>User agent</th>\r\n<td><?php echo $HTTP_USER_AGENT; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>User browser</th>\r\n<td><?php echo $browser; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>User operating system</th>\r\n<td><?php echo $os; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>Request URI</th>\r\n<td><?php echo $REQUEST_URI; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>Remote address</th>\r\n<td><?php echo $REMOTE_ADDR; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>HTTP referer</th>\r\n<td><?php echo $HTTP_REFERER; ?>\r\n</td>\r\n</tr>\r\n</table>\r\n\r\n<br />\r\nCurrent server time is <?php echo strftime(\'%x\'); ?>\r\n, <?php echo strftime(\'%X\'); ?>\r\n<br />\r\n<br />',20011016232611,2,'');
INSERT INTO article VALUES ('Information about <?php echo $site_name; ?>:<br />\r\nThis site was created by <?php echo $site_author; ?> &lt;<?php echo $site_author_email; ?>&gt;. Name of this site is <?php echo $site_name; ?>\r\n and it\'s base url is <?php echo $site_home; ?>. Title of this page is <?php page_title(); ?>  and it is in category called <?php category_name(); ?>. This site was built using <?php echo $wessie_version; ?>.',20011010180142,3,'');
INSERT INTO article VALUES ('Here will be some short help...',20010508224252,4,'');
INSERT INTO article VALUES ('<h2>Statistics</h2>\r\n<h3>Operating systems</h3>\r\n<?php stat_os(); ?>\r\n<h3>Browsers</h3>\r\n<?php stat_browser(); ?>\r\n<h3>Languages</h3>\r\n<?php stat_langs(2); ?>',20011010180241,6,'');
INSERT INTO article VALUES ('<h2>Weekly statistics</h2>\r\n<?php stat_weeks(); ?>',20011010180254,7,'');
INSERT INTO article VALUES ('<h2>Daily statistics</h2>\r\n<?php stat_days(); ?>',20011010180311,8,'');
INSERT INTO article VALUES ('<h2>Hourly statistics</h2>\r\n<?php stat_hours(); ?>',20011010180321,9,'');
INSERT INTO article VALUES ('<h2>wessie �sp�n� nainst�lovano a je funk�n�</h2>\r\nWeb Site System byl nainstalov�n na tyto str�nky,\r\nale �adn� obsah je�t� nebyl (pravd�podobn�) zad�n.<br />\r\nV�ce informac� o wessie najdete na <a href="http://cicom.tsx.org"><b>cicom.tsx.org</b></a>.\r\n\r\n<h2>VELMI stru�n� n�vod na administraci wessie</h2>\r\n\r\n<p>Pokud hled�te administraci naleznete ji <a href="admin">zde</a>. Po nainstalov�n�\r\nje zalo�en jedin� u�ivatel se jm�nem <code>admin</code> a heslem <code>admin</code>.\r\n<b>Doporu�uji toto heslo zm�nit na jin�, ne tak snadno uhodnuteln� (<code>admin:admin</code> nen� nejlep��).</b>\r\n</p>\r\n<p>Zde si m��ete st�hnout readme:<br />\r\n<?php download(1); ?>\r\n</p>\r\n<p>Sta�en� beta distribuce:<br />\r\n<?php download(2); ?>\r\n</p>\r\n<p>Sta�en� webu cicom:<br />\r\n<?php download(3); ?>\r\n</p>\r\n<p>Sta�en� programu CodeConv 2.6 a Updater 1.1:<br />\r\n<?php download(4); ?>\r\n</p>',20011023232830,1,1);
INSERT INTO article VALUES ('Informace o wessie:<br />\r\n<table>\r\n\r\n<tr>\r\n<th>\r\nVerze wessie\r\n</th><td>\r\n<?php echo $wessie_version; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>\r\nAutor wessie\r\n</th><td>\r\n<?php echo $wessie_author; ?> &lt;<?echo $wessie_author_email?>&gt;\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>\r\nStr�nka wessie\r\n</th><td>\r\n<?php echo $wessie_url; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>wessie ikona:</th>\r\n<td><?php wessie_icon(); ?>\r\n</td>\r\n</tr>\r\n\r\n\r\n</table><br />\r\nInformace o serveru:<br />\r\n\r\n<table>\r\n\r\n<tr>\r\n<th>\r\nSoftware\r\n</th><td>\r\n<?php echo $SERVER_SOFTWARE; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>\r\nSignatura\r\n</th><td>\r\n<?php echo $SERVER_SIGNATURE; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>\r\nProtokol\r\n</th><td>\r\n<?php echo $SERVER_PROTOCOL; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>\r\nN�zev\r\n</th><td>\r\n<?php echo $SERVER_NAME; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>\r\nAddresa\r\n</th><td>\r\n<?php echo $SERVER_ADDR; ?>\r\n</td>\r\n</tr>\r\n\r\n<tr>\r\n<th>\r\nPort\r\n</th><td>\r\n<?php echo $SERVER_PORT; ?>\r\n</td>\r\n</tr>\r\n</table>\r\n\r\n<br />\r\n\r\nInformace o tomto spojen�:<br />\r\n\r\n<table>\r\n<tr>\r\n<th>\r\nUser agent\r\n</th><td>\r\n<?php echo $HTTP_USER_AGENT; ?>\r\n</td></tr>\r\n<tr><th>\r\nV�s prohl��e�\r\n</th><td>\r\n<?php echo $browser; ?>\r\n</td></tr>\r\n<tr><th>\r\nV� opera�n� syst�m\r\n</th><td>\r\n<?php echo $os; ?>\r\n</td></tr>\r\n<tr><th>\r\nPo�adovan� URI\r\n</th><td>\r\n<?php echo $REQUEST_URI; ?>\r\n</td></tr>\r\n<tr><th>\r\nVzd�len� adresa\r\n</th><td>\r\n<?php echo $REMOTE_ADDR; ?>\r\n</td></tr>\r\n<tr><th>\r\nHTTP referer\r\n</th><td>\r\n<?php echo $HTTP_REFERER; ?>\r\n</td></tr>\r\n</table><br />\r\n\r\n�as serveru je <?php echo strftime(\'%x\'); ?>, <?echo strftime(\'%X\')?><br /><br />',20011017004611,2,1);
INSERT INTO article VALUES ('Informace o <?php echo $site_name; ?>:<br />\r\nTyto str�nky vytvo�il <?php echo $site_author; ?> &lt;<?php echo $site_author_email; ?>&gt;. N�zev t�chto str�nek je <?php echo $site_name; ?> a\r\njejich hlavn� url je <?php echo $site_home; ?>. N�zev t�to str�nky je <?php page_title(); ?> a je um�sten v kategorii nazvan�\r\n\r\n<?php category_name(); ?>. Tyto str�nky byly vytvo�eny pomoc�  <?php echo $wessie_version; ?>.',20011010181305,3,1);
INSERT INTO article VALUES ('Zde bude kr�tk� n�pov�da',20010908185133,4,1);
INSERT INTO article VALUES ('<h2>Statistiky</h2>\r\n<h3>Opera�n� syst�my</h3>\r\n<?php stat_os(); ?>\r\n<h3>Prohl��e�e</h3>\r\n<?php stat_browser(); ?>\r\n<h3>Jazyky</h3>\r\n<?php stat_langs(2); ?>',20011010181441,6,1);
INSERT INTO article VALUES ('<h2>T�den� statistiky</h2>\r\n<?php stat_weeks(); ?>',20011010181450,7,1);
INSERT INTO article VALUES ('<h2>Denn� statistiky</h2>\r\n<?php stat_days(); ?>',20011010181459,8,1);
INSERT INTO article VALUES ('<h2>Hodinov� statistiky</h2>\r\n<?php stat_hours(); ?>',20011010181508,9,1);
# --------------------------------------------------------

#
# Table structure for table `category`
#

DROP TABLE IF EXISTS category;
CREATE TABLE category (
  id tinyint(3) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  short varchar(20) default NULL,
  lng tinyint(3) unsigned NOT NULL default '0',
  description varchar(255) default NULL,
  page smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (id,lng),
  KEY page (page),
  KEY lng (lng)
) TYPE=MyISAM;

#
# Dumping data for table `category`
#

INSERT INTO category VALUES (1,'Home','Home','','Home',1);
INSERT INTO category VALUES (2,'wessie','wessie','','Information about Web Site System',2);
INSERT INTO category VALUES (3,'<?echo $site_name?>','<?echo $site_name?>','','Some information about <?echo $site_name?>',3);
INSERT INTO category VALUES (4,'Help','Help','','Help files',4);
INSERT INTO category VALUES (1,'�vod','�vod',1,'�vodn� str�nka',1);
INSERT INTO category VALUES (2,'wessie','wessie',1,'Informace o Web Site System',2);
INSERT INTO category VALUES (3,'<?echo $site_name?>','<?echo $site_name?>',1,'P�r informac� o <?echo $site_name?>',3);
INSERT INTO category VALUES (4,'N�pov�da','N�pov�da',1,'Soubory n�pov�dy',4);
# --------------------------------------------------------

#
# Table structure for table `discuss`
#

DROP TABLE IF EXISTS discuss;
CREATE TABLE discuss (
  id smallint(5) unsigned NOT NULL auto_increment,
  type enum('moderated') default NULL,
  size tinyint(3) unsigned NOT NULL default '20',
  list enum('inv') default NULL,
  name varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `discuss`
#

# --------------------------------------------------------

#
# Table structure for table `download`
#

DROP TABLE IF EXISTS download;
CREATE TABLE download (
  id smallint(5) unsigned NOT NULL auto_increment,
  filename varchar(100) NOT NULL default '',
  grp tinyint(3) unsigned NOT NULL default '0',
  count bigint(20) unsigned default '0',
  PRIMARY KEY  (id),
  KEY count (count),
  KEY filename (filename)
) TYPE=MyISAM;

#
# Dumping data for table `download`
#

INSERT INTO download VALUES (1,'README','','');
INSERT INTO download VALUES (2,'wessie.zip',1,'');
INSERT INTO download VALUES (3,'cicom.zip','','');
INSERT INTO download VALUES (4,'files/download/CodeConv_CZ-2.6_Updater_CZ-1.1-setup.exe','','');
# --------------------------------------------------------

#
# Table structure for table `download_group`
#

DROP TABLE IF EXISTS download_group;
CREATE TABLE download_group (
  id tinyint(3) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  count bigint(20) unsigned default '0',
  PRIMARY KEY  (id),
  KEY count (count)
) TYPE=MyISAM;

#
# Dumping data for table `download_group`
#

INSERT INTO download_group VALUES (1,'wessie','');
# --------------------------------------------------------

#
# Table structure for table `maillist`
#

DROP TABLE IF EXISTS maillist;
CREATE TABLE maillist (
  lng tinyint(3) unsigned NOT NULL default '0',
  mail varchar(50) NOT NULL default '',
  PRIMARY KEY  (mail,lng)
) TYPE=MyISAM;

#
# Dumping data for table `maillist`
#

# --------------------------------------------------------

#
# Table structure for table `menu`
#

DROP TABLE IF EXISTS menu;
CREATE TABLE menu (
  id mediumint(8) unsigned NOT NULL auto_increment,
  name varchar(50) default NULL,
  description varchar(100) default NULL,
  page smallint(5) unsigned NOT NULL default '0',
  category tinyint(3) unsigned NOT NULL default '0',
  parent mediumint(8) unsigned NOT NULL default '0',
  expand tinyint(4) NOT NULL default '1',
  lng tinyint(4) NOT NULL default '0',
  rank mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (id,lng),
  KEY parent (parent),
  KEY order (rank)
) TYPE=MyISAM;

#
# Dumping data for table `menu`
#

INSERT INTO menu VALUES (1,NULL,NULL,1,1,'',1,'','');
INSERT INTO menu VALUES (2,NULL,NULL,4,4,'',1,'','');
INSERT INTO menu VALUES (3,NULL,NULL,2,2,'',1,'','');
INSERT INTO menu VALUES (5,NULL,NULL,3,3,'',1,'','');
INSERT INTO menu VALUES (6,'','',6,1,'','','','');
INSERT INTO menu VALUES (7,NULL,NULL,7,1,6,1,'','');
INSERT INTO menu VALUES (8,NULL,NULL,8,1,6,1,'','');
INSERT INTO menu VALUES (9,NULL,NULL,9,1,6,1,'','');
INSERT INTO menu VALUES (1,NULL,NULL,1,1,'',1,1,'');
INSERT INTO menu VALUES (2,NULL,NULL,4,4,'',1,1,'');
INSERT INTO menu VALUES (3,NULL,NULL,2,2,'',1,1,'');
INSERT INTO menu VALUES (5,NULL,NULL,3,3,'',1,1,'');
INSERT INTO menu VALUES (6,'','',6,1,'','',1,'');
INSERT INTO menu VALUES (7,NULL,NULL,7,1,6,1,1,'');
INSERT INTO menu VALUES (8,NULL,NULL,8,1,6,1,1,'');
INSERT INTO menu VALUES (9,NULL,NULL,9,1,6,1,1,'');
# --------------------------------------------------------

#
# Table structure for table `note`
#

DROP TABLE IF EXISTS note;
CREATE TABLE note (
  id int(10) unsigned NOT NULL auto_increment,
  lng tinyint(3) unsigned NOT NULL default '0',
  author varchar(50) default NULL,
  email varchar(50) default NULL,
  url varchar(100) default NULL,
  web varchar(100) default NULL,
  parent int(10) unsigned NOT NULL default '0',
  type enum('normal','allowed','rejected','admin') NOT NULL default 'normal',
  discuss smallint(5) unsigned NOT NULL default '1',
  date timestamp(14) NOT NULL,
  note text NOT NULL,
  PRIMARY KEY  (id),
  KEY discuss (discuss),
  KEY parent (parent)
) TYPE=MyISAM;

#
# Dumping data for table `note`
#

# --------------------------------------------------------

#
# Table structure for table `page`
#

DROP TABLE IF EXISTS page;
CREATE TABLE page (
  id smallint(5) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  type enum('article','file','links') NOT NULL default 'article',
  param varchar(100) NOT NULL default '',
  description text NOT NULL,
  keywords text NOT NULL,
  count bigint(20) unsigned NOT NULL default '0',
  lng tinyint(3) unsigned NOT NULL default '0',
  category tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (id,lng),
  UNIQUE KEY duplicity_check (name,type,param,description(100),keywords(100),lng,category),
  KEY lng (lng),
  KEY count (count)
) TYPE=MyISAM;

#
# Dumping data for table `page`
#

INSERT INTO page VALUES (1,'Welcome page','article','','Welcome page','wessie',4678,'',1);
INSERT INTO page VALUES (2,'About','article','','Information about Web Site System','wessie',78,'',2);
INSERT INTO page VALUES (3,'<?echo $site_name?>','article','','Information about <?echo $site_name?>','<?echo $site_name?>',61,'',3);
INSERT INTO page VALUES (4,'Help','article','','How to use Web Site System','wessie,Help',64,'',4);
INSERT INTO page VALUES (6,'Statistics','article','','Statistical page','wessie,statistics',216,'',1);
INSERT INTO page VALUES (7,'Weekly statistics','article','','Statistical page','wessie,statistics',165,'',1);
INSERT INTO page VALUES (8,'Daily statistics','article','','Statistical page','wessie,statistics',106,'',1);
INSERT INTO page VALUES (9,'Hourly statistics','article','','Statistical page','wessie,statistics',91,'',1);
INSERT INTO page VALUES (1,'�vodn� str�nka','article','','�vodn� str�nka','wessie',169,1,1);
INSERT INTO page VALUES (2,'O aplikaci','article','','Informace o Web Site System','wessie',84,1,2);
INSERT INTO page VALUES (3,'<?echo $site_name?>','article','','Informace o <?echo $site_name?>','<?echo $site_name?>',92,1,3);
INSERT INTO page VALUES (4,'N�pov�da','article','','Jak pou��vat Web Site System','wessie,Help',64,1,4);
INSERT INTO page VALUES (6,'Statistiky','article','','Str�nka statistik','wessie,statistics',308,1,1);
INSERT INTO page VALUES (7,'T�den� statistiky','article','','Str�nka statistik','wessie,statistics',87,1,1);
INSERT INTO page VALUES (8,'Denn� statistiky','article','','Str�nka statistik','wessie,statistics',72,1,1);
INSERT INTO page VALUES (9,'Hodinov� statistiky','article','','Str�nka statistik','wessie,statistics',78,1,1);
INSERT INTO page VALUES (11,'/etc/passwd','file','/etc/passwd','/etc/passwd listing','etc passwd',1,1,1);
# --------------------------------------------------------

#
# Table structure for table `stat`
#

DROP TABLE IF EXISTS stat;
CREATE TABLE stat (
  category enum('total','time','dow','browser','os','week_no','lang') NOT NULL default 'total',
  item varchar(20) NOT NULL default '',
  count bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (category,item)
) TYPE=MyISAM;

#
# Dumping data for table `stat`
#

INSERT INTO stat VALUES ('total','hits',6024);
INSERT INTO stat VALUES ('time','00',88);
INSERT INTO stat VALUES ('time','01',11);
INSERT INTO stat VALUES ('time','02',1);
INSERT INTO stat VALUES ('time','03',1946);
INSERT INTO stat VALUES ('time','04','');
INSERT INTO stat VALUES ('time','05','');
INSERT INTO stat VALUES ('time','06','');
INSERT INTO stat VALUES ('time','07','');
INSERT INTO stat VALUES ('time','08',1);
INSERT INTO stat VALUES ('time','09',9);
INSERT INTO stat VALUES ('time','10',1);
INSERT INTO stat VALUES ('time','11',1);
INSERT INTO stat VALUES ('time','12',8);
INSERT INTO stat VALUES ('time','13',7);
INSERT INTO stat VALUES ('time','14',76);
INSERT INTO stat VALUES ('time','15',7);
INSERT INTO stat VALUES ('time','16',5);
INSERT INTO stat VALUES ('time','17',74);
INSERT INTO stat VALUES ('time','18',193);
INSERT INTO stat VALUES ('time','19',56);
INSERT INTO stat VALUES ('time','20',130);
INSERT INTO stat VALUES ('time','21',1237);
INSERT INTO stat VALUES ('time','22',363);
INSERT INTO stat VALUES ('time','23',1690);
INSERT INTO stat VALUES ('dow','1',1192);
INSERT INTO stat VALUES ('dow','2',737);
INSERT INTO stat VALUES ('dow','3',330);
INSERT INTO stat VALUES ('dow','4',1681);
INSERT INTO stat VALUES ('dow','5',1976);
INSERT INTO stat VALUES ('dow','6',16);
INSERT INTO stat VALUES ('dow','7',119);
INSERT INTO stat VALUES ('browser','Links',9);
INSERT INTO stat VALUES ('browser','WebTV','');
INSERT INTO stat VALUES ('browser','Lynx',3);
INSERT INTO stat VALUES ('browser','MSIE',11);
INSERT INTO stat VALUES ('browser','Opera',23);
INSERT INTO stat VALUES ('browser','Konqueror',1321);
INSERT INTO stat VALUES ('browser','Netscape',80);
INSERT INTO stat VALUES ('browser','NCSA Mosaic','');
INSERT INTO stat VALUES ('browser','W3C_Validator','');
INSERT INTO stat VALUES ('browser','Nokia Browser','');
INSERT INTO stat VALUES ('browser','NetPositive','');
INSERT INTO stat VALUES ('browser','Amiga','');
INSERT INTO stat VALUES ('browser','Lotus Notes','');
INSERT INTO stat VALUES ('browser','GetRight','');
INSERT INTO stat VALUES ('browser','iCab','');
INSERT INTO stat VALUES ('browser','Amaya','');
INSERT INTO stat VALUES ('browser','Downloader','');
INSERT INTO stat VALUES ('browser','Search Indexer','');
INSERT INTO stat VALUES ('browser','Bot','');
INSERT INTO stat VALUES ('browser','?',4581);
INSERT INTO stat VALUES ('os','Windows',2);
INSERT INTO stat VALUES ('os','WindowsNT',3);
INSERT INTO stat VALUES ('os','Amiga','');
INSERT INTO stat VALUES ('os','Linux/Unix',1427);
INSERT INTO stat VALUES ('os','Mac',2);
INSERT INTO stat VALUES ('os','FreeBSD','');
INSERT INTO stat VALUES ('os','SunOS','');
INSERT INTO stat VALUES ('os','IRIX','');
INSERT INTO stat VALUES ('os','BeOS','');
INSERT INTO stat VALUES ('os','OS/2','');
INSERT INTO stat VALUES ('os','AIX','');
INSERT INTO stat VALUES ('os','?',4591);
INSERT INTO stat VALUES ('week_no','0016',1696);
INSERT INTO stat VALUES ('lang','',5180);
INSERT INTO stat VALUES ('lang','1',801);
INSERT INTO stat VALUES ('week_no','0017',58);
INSERT INTO stat VALUES ('week_no','0018',37);
INSERT INTO stat VALUES ('week_no','0019',30);
INSERT INTO stat VALUES ('week_no','0020',241);
INSERT INTO stat VALUES ('week_no','0021',83);
INSERT INTO stat VALUES ('week_no','0030',80);
INSERT INTO stat VALUES ('week_no','0031',22);
INSERT INTO stat VALUES ('week_no','0032',18);
INSERT INTO stat VALUES ('week_no','0033',221);
INSERT INTO stat VALUES ('week_no','0034',15);
INSERT INTO stat VALUES ('week_no','0035',3);
INSERT INTO stat VALUES ('week_no','0037',9);
INSERT INTO stat VALUES ('week_no','0038',259);
INSERT INTO stat VALUES ('week_no','0039',106);
INSERT INTO stat VALUES ('week_no','0040',43);
# --------------------------------------------------------

#
# Table structure for table `users`
#

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id smallint(5) unsigned NOT NULL auto_increment,
  user varchar(20) NOT NULL default '',
  pass varchar(32) NOT NULL default '',
  name varchar(50) NOT NULL default '',
  mail varchar(50) NOT NULL default '',
  web varchar(100) NOT NULL default '',
  web_title varchar(100) NOT NULL default '',
  rights text NOT NULL,
  ip varchar(33) NOT NULL default '',
  hash varchar(32) NOT NULL default '',
  time timestamp(14) NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY user (user),
  KEY user_2 (user)
) TYPE=MyISAM;

#
# Dumping data for table `users`
#

INSERT INTO users VALUES (1,'admin','admin','Administrator','','http://cicom.kgb.cz','CICOM web site - home of wessie','','192.168.1.1','bfd6ccfdb4f09e57f45903df93871f91',20011024223122);

