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
    <title><?php title(); ?></title>
    <link rel="icon" href="<?php echo $base_path;?>img/favicon.png" type="image/png" />
    <link rel="home" href="<?php echo $site_home; ?>" />
    <link rel="up" href="<?php echo link_up(); ?>" />
    <link rel="contents" href="<?php echo link_start(); ?>" />
    <link rel="Copyright" href="mailto:<?php echo $site_author_email; ?>" title="<?php echo $site_name[$lng];?> Feedback" />
    <link rev="Made" href="mailto:<?php echo $site_author_email; ?>" title="<?php echo $site_name[$lng];?> Feedback" />

    <meta name="author" content="<?php echo $site_author[$lng]; ?>" />
    <meta name="keywords" content="<?php keywords(); ?>" />
    <meta name="description" content="<?php description(); ?>" />
    <meta name="generator" content="<?php echo $wessie_copyright; ?>" />

    <!-- We LOVE Micro$oft! We don't like their silly features. -->
    <meta name="MSSmartTagsPreventParsing" content="true" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="MSThemeCompatible" content="no" />

    <script language="JavaScript" type="text/javascript">
    <!--
    if(top != self) { window.top.location.href=location; }
    //-->
    </script>
</head>

<body bgcolor="#000000" text="#FFFFFF" link="#EEEE00" alink="#FFFF00" vlink="#DDDD00">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="middle" width="200">
<center><img src="<?php echo $base_path . $site_logo; ?>" align="middle" alt="<?php echo $site_logo_alt; ?>" width="<?php echo $site_logo_width; ?>" height="<?php echo $site_logo_height; ?>" border="0" /></center>
</td>
<td align="center" valign="middle"><?php top_pages(); ?></td>
<td align="right" valign="middle" width="470">
  <?php advert(); ?>&nbsp;&nbsp;
</td>
</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
  <tr bgcolor="#000050">
    <?php upper_menu(); ?>
  </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="200" align="left" valign="top"><?php left_menu(); ?></td>
<td align="left" valign="top" rowspan="2">
<table cellpadding="5" cellspacing="0" border="0">
<tr>
<td>
<?php
special();
content();
?>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td valign="bottom">
<br />
<form action="<?php echo $search_url; ?>" method="get" target="_self">
  <?php search_hidden_options(); ?>
  <input type="text" name="<?php echo $search_param; ?>" size="15" />
  <input type="submit" value="<?php echo $msg_find; ?>" />
</form>
<br />
<font size="-2"><?php languages(); ?></font>
</td>
</tr>

<tr bgcolor="#000050">
<td height="20" width="200">&nbsp;</td>
<td height="20" align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td align="left"><font size="-3">
<?php counter(); ?>
</font>&nbsp;</td>
<td align="right">
<font size="-3">
<?php echo $msg_last_change; ?>:&nbsp;<?php echo strftime('%c',$last_change); ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php copyright(); ?>
</font>&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
<center><br />
<?php
powered_wessie();
echo '&nbsp;';
powered_php();
echo '&nbsp;';
powered_mysql();
?>
</center>
</body>
</html>
