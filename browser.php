<?
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
elseif(eregi('bot|scanner', $HTTP_USER_AGENT)) $browser = 'Bot';
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
elseif(ereg('Unix|Linux|X11', $HTTP_USER_AGENT)) $os = 'Linux/Unix';
else $os = '?';
?>