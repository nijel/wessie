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
// CSS based template definition file for wessie
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
    <link rel="Copyright" href="mailto:<?php echo $site_author_email; ?>" title="<?php echo $site_name;?> Feedback" />
    <link rev="Made" href="mailto:<?php echo $site_author_email; ?>" title="<?php echo $site_name;?> Feedback" />
    <link rel="StyleSheet" type="text/css" media="screen" href="<?php echo $base_path;?>templates/supermarket/styles.php" />
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

    function highlight(what,color){
        if (typeof(what.style) != 'undefined'){
            oldBackground=what.style.backgroundColor;
            what.style.backgroundColor = color;
        }
        return true;
    }

    function unhighlight(what){
        if (typeof(what.style) != 'undefined') what.style.backgroundColor = oldBackground;
        return true;
    }

    //-->
    </script>
</head>
<body>
 <div class="topbox">
  <div class="top">
    <span class="title"><?php echo $site_name_long[$lng]; ?></span>
  </div>
 </div>
 <div class="leftbox"><div class="left"><?php left_menu(); ?></div></div>
 <div class="bodybox">
  <div class="body">
   <?php content(); ?>
  </div>
  <div class="docinfo">
   <?php echo $msg_last_change.'&nbsp;'.strftime('%c',$last_change); ?><br />
   <?php copyright(); ?>
  </div>
 </div>
</body>
</html>
