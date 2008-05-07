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
//acquire client browser
if(isset($_SERVER["HTTP_USER_AGENT"])){
    if(!(strpos($_SERVER["HTTP_USER_AGENT"],'MSIE')===false)) $browser = 'MSIE';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Firefox')===false)) $browser = 'Firefox';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Iceweasel')===false)) $browser = 'Iceweasel';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Lynx')===false)) $browser = 'Lynx';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Links')===false)) $browser = 'Links';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Konqueror')===false)) $browser = 'Konqueror';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Opera')===false)) $browser = 'Opera';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'WebTrends')===false)) $browser = 'WebTrends';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'NCSA Mosaic')===false)) $browser = 'NSCA Mosaic';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'W3C_Validator')===false)) $browser = 'W3C_Validator';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Nokia')===false)) $browser = 'Nokia Browser'; // in communicator (eg. 9110)
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'NetPositive')===false)) $browser = 'NetPositive'; // BeOS browser
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Amiga')===false)) $browser = 'Amiga';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Lotus-Notes')===false)) $browser = 'Lotus Notes';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'GetRight')===false)) $browser = 'GetRight';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'iCab')===false)) $browser = 'iCab';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'amaya')===false)) $browser = 'Amaya';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'WebTV')===false)) $browser = 'WebTV';
    elseif (
        (ereg('Teleport|WebZIP|WebCopier|Robozilla|Web Dowloader|Offline Explorer|Go!Zilla|ia_archiver', $_SERVER["HTTP_USER_AGENT"])) ||
        (eregi('get', $_SERVER["HTTP_USER_AGENT"]))
            ) $browser = 'Downloader';
    elseif(
        (ereg('Google|Slurp|LinkAlarm|AltaVista|Lycos|holmes|Ocelli|CloakDetect|YahooSeeker|Ask Jeeves|Nutch', $_SERVER["HTTP_USER_AGENT"])) ||
        (eregi('infoseek|search|spider|crawler', $_SERVER["HTTP_USER_AGENT"]))
            ) $browser = 'Search Indexer';
    elseif(eregi('bot|scanner|ApacheBench', $_SERVER["HTTP_USER_AGENT"])) $browser = 'Bot';
    elseif(ereg('Gecko|Galeon', $_SERVER["HTTP_USER_AGENT"])) $browser = 'Mozilla';
    elseif(ereg('Nav|Gold|Mozilla|Netscape', $_SERVER["HTTP_USER_AGENT"])) $browser = 'Netscape';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Java')===false)) $browser = 'Java';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'libwww-perl')===false)) $browser = 'libwww-perl';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'libcurl')===false)) $browser = 'libcurl';
    else {
        $browser = '?';
        log_error('Unknown browser: ' . $_SERVER["HTTP_USER_AGENT"]);
    }


    //acquire client os
    if(ereg('Win[^,]*NT', $_SERVER["HTTP_USER_AGENT"])) $os = "WindowsNT";
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Win')===false)) $os = 'Windows';
    elseif((ereg('Mac|PPC|68K', $_SERVER["HTTP_USER_AGENT"]))) $os = 'Mac';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'FreeBSD')===false)) $os = 'FreeBSD';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'SunOS')===false)) $os = 'SunOS';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'IRIX')===false)) $os = 'IRIX';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'BeOS')===false)) $os = 'BeOS';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'OS/2')===false)) $os = 'OS/2';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'AIX')===false)) $os = 'AIX';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'Amiga')===false)) $os = 'Amiga';
    elseif(ereg('Unix|Linux|X11|deb|ApacheBench', $_SERVER["HTTP_USER_AGENT"])) $os = 'Linux/Unix';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'linux')===false)) $os = 'Linux/Unix';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'MSIE')===false)) $os = 'Windows';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'ia_archiver')===false)) $os = 'Windows';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'SymbianOS')===false)) $os = 'Symbian';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'J2ME/MIDP')===false)) $os = 'Mobile';
    elseif(!(strpos($_SERVER["HTTP_USER_AGENT"],'DoCoMo')===false)) $os = 'Mobile';
    else {
        $os = '?';
        if ($browser != '?' && $browser != 'Bot' && $browser != 'Search Indexer' &&
            $browser != 'libwww-perl' && $browser != 'Java') {
            log_error('Unknown OS: ' . $_SERVER["HTTP_USER_AGENT"]);
        }
    }
}else{
    $browser = '?';
    $os = '?';
}
?>
