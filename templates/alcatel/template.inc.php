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
// Default template definition file for wessie
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
    <meta http-equiv="Content-Language" content="<?php echo $lang; ?>" />
    <meta name="ICBM" content="50.0687, 14.4563" />
    <meta name="DC.title" content="Michal Cihar" />
    <title><?php title(); ?></title>
    <link rel="icon" href="<?php echo $base_path;?>img/favicon.png" type="image/png" />
    <link rel="home" href="<?php echo $site_home; ?>" />
    <link rel="up" href="<?php echo link_up(); ?>" />
    <link rel="contents" href="<?php echo link_start(); ?>" />
    <link rel="Copyright" href="mailto:<?php echo $site_author_email; ?>" title="<?php echo $site_name[$lng];?> Feedback" />
    <link rev="Made" href="mailto:<?php echo $site_author_email; ?>" title="<?php echo $site_name[$lng];?> Feedback" />
    <link rel="StyleSheet" type="text/css" media="screen" href="<?php echo $base_path;?>templates/alcatel/styles.php/style.css" />

    <meta name="author" content="<?php echo $site_author[$lng]; ?>" />
    <meta name="keywords" content="<?php keywords(); ?>" />
    <meta name="description" content="<?php description(); ?>" />
    <meta name="generator" content="<?php echo $wessie_copyright; ?>" />

    <!-- We LOVE Micro$oft! We don't like their silly features. -->
    <meta name="MSSmartTagsPreventParsing" content="true" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="MSThemeCompatible" content="no" />

    <script language="javascript" type="text/javascript" src="/js/awstats_misc_tracker.js"></script>
    <script language="JavaScript" type="text/javascript">
    <!--
    if(top != self) { window.top.location.href=location; }
    //-->
    </script>
</head>

<body>
<div class="phones"><img src="<?php echo $base_path;?>templates/alcatel/img/phones.png" width="188" height="137" border="0" alt="501" /></div>
<div class="title"><img src="<?php echo $base_path;?>templates/alcatel/img/logo.png" width="357" height="22" border="0" alt="ALCATEL ONE TOUCH 501" /></div>
<div class="left">
<div class="leftbox">
<?php left_menu(); ?>
</div>
<!--
<div class="leftbox" id="searchbox">
<form class="search" action="<?php echo $search_url; ?>" method="get" target="_self">
  <?php search_hidden_options(); ?>
  <input class="search_text" type="text" name="<?php echo $search_param; ?>" />
  <input class="search_button" type="submit" value="<?php echo $msg_find; ?>" />
</form>
</div>
-->
<!--
<div class="leftbox">
<?php top_pages(); ?>
</div>
-->
<div class="leftbox">
<?php languages(); ?>
</div>
<?php
/*
<div class="powered">
//powered_wessie();
//echo '<br /><br />';
//powered_php();
//echo '<br /><br />';
//powered_mysql();
<br />
<br />
<a href="http://ukcdr.org/issues/cd/quick/"><img border="0" width="88" height="31" src="/images/badcd006.png" alt="Say NO to corrupt audio discs" /></a>
<br />
<br />
<a href="http://www.debian.org"><img border="0" width="88" height="31" src="/images/debian.jpg" alt="Debian powered" /></a>
<br />
<br />
<a href="http://validator.w3.org/check/referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0!" height="31" width="88" border="0" /></a>
<br />
<br />
<a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" height="31" width="88" border="0" /></a>
</div>
*/
?>
</div>
<div class="text">
<?php
special();
content();
?>
<div class="docinfo">
<?php counter(); ?><br />
<?php echo $msg_last_change; ?>:&nbsp;<?php echo strftime('%c',$last_change); ?><br />
<?php copyright(); ?>
</div>
</div>
</body>
</html>
