<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// / wessie - web site system                                             |
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
//acquire client browser
if(!(strpos($HTTP_USER_AGENT,'MSIE')===false)) $browser = 'MSIE';
elseif(!(strpos($HTTP_USER_AGENT,'Lynx')===false)) $browser = 'Lynx';
elseif(!(strpos($HTTP_USER_AGENT,'Links')===false)) $browser = 'Links';
elseif(!(strpos($HTTP_USER_AGENT,'Konqueror')===false)) $browser = 'Konqueror';
elseif(!(strpos($HTTP_USER_AGENT,'Opera')===false)) $browser = 'Opera';
elseif(!(strpos($HTTP_USER_AGENT,'WebTrends')===false)) $browser = 'WebTrends';
elseif(!(strpos($HTTP_USER_AGENT,'NCSA Mosaic')===false)) $browser = 'NSCA Mosaic';
elseif(!(strpos($HTTP_USER_AGENT,'W3C_Validator')===false)) $browser = 'W3C_Validator';
elseif(!(strpos($HTTP_USER_AGENT,'Nokia')===false)) $browser = 'Nokia Browser'; // in communicator (eg. 9110)
elseif(!(strpos($HTTP_USER_AGENT,'NetPositive')===false)) $browser = 'NetPositive'; // BeOS browser
elseif(!(strpos($HTTP_USER_AGENT,'Amiga')===false)) $browser = 'Amiga';
elseif(!(strpos($HTTP_USER_AGENT,'Lotus-Notes')===false)) $browser = 'Lotus Notes';
elseif(!(strpos($HTTP_USER_AGENT,'GetRight')===false)) $browser = 'GetRight';
elseif(!(strpos($HTTP_USER_AGENT,'iCab')===false)) $browser = 'iCab';
elseif(!(strpos($HTTP_USER_AGENT,'amaya')===false)) $browser = 'Amaya';
elseif(!(strpos($HTTP_USER_AGENT,'WebTV')===false)) $browser = 'WebTV';
elseif (
    (ereg('Teleport|WebZIP|WebCopier|Robozilla|Web Dowloader|Offline Explorer|Go!Zilla', $HTTP_USER_AGENT)) ||
    (eregi('get', $HTTP_USER_AGENT))
        ) $browser = 'Downloader';
elseif(
    (ereg('Google|Slurp|LinkAlarm|AltaVista|Lycos', $HTTP_USER_AGENT)) ||
    (eregi('infoseek|search|spider', $HTTP_USER_AGENT))
        ) $browser = 'Search Indexer';
elseif(eregi('bot|scanner|ApacheBench', $HTTP_USER_AGENT)) $browser = 'Bot';
elseif(ereg('Nav|Gold|Mozilla|Netscape|Gecko', $HTTP_USER_AGENT)) $browser = 'Netscape';
else $browser = '?';


//acquire client os
if(ereg('Win[^,]*NT', $HTTP_USER_AGENT)) $os = "WindowsNT";
elseif(!(strpos($HTTP_USER_AGENT,'Win')===false)) $os = 'Windows';
elseif((ereg('Mac|PPC|68K', $HTTP_USER_AGENT))) $os = 'Mac';
elseif(!(strpos($HTTP_USER_AGENT,'FreeBSD')===false)) $os = 'FreeBSD';
elseif(!(strpos($HTTP_USER_AGENT,'SunOS')===false)) $os = 'SunOS';
elseif(!(strpos($HTTP_USER_AGENT,'IRIX')===false)) $os = 'IRIX';
elseif(!(strpos($HTTP_USER_AGENT,'BeOS')===false)) $os = 'BeOS';
elseif(!(strpos($HTTP_USER_AGENT,'OS/2')===false)) $os = 'OS/2';
elseif(!(strpos($HTTP_USER_AGENT,'AIX')===false)) $os = 'AIX';
elseif(!(strpos($HTTP_USER_AGENT,'Amiga')===false)) $os = 'Amiga';
elseif(ereg('Unix|Linux|X11|deb|ApacheBench', $HTTP_USER_AGENT)) $os = 'Linux/Unix';
else $os = '?';
?>