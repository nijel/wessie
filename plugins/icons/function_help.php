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
?>
<h3>Powered by icon functions</h3>

<h4>powered_wessie</h4>
<p>Adds html code for displaying icon &quot;Powered by wessie&quot;.</p>
<p><pre><code>
function powered_wessie()
</code></pre></p>

<h4>powered_php</h4>
<p>Adds html code for displaying icon &quot;Powered by PHP&quot;.</p>
<p><pre><code>
function powered_php()
</code></pre></p>

<h4>powered_mysql</h4>
<p>Adds html code for displaying icon &quot;Powered by MySQL&quot;.</p>
<p><pre><code>
function powered_mysql()
</code></pre></p>

<h4>make_powered</h4>
<p>Adds html code for displaying custom powered by icon.</p>
<p><pre><code>
function make_powered($what,$url,$msg)

$what       - name of icon to display (it must be in plugins/icons/img
              directory and must have name powered_$what.png
$url        - url of link
$msg        - name of product, used in alt text after &quot;Powered by&quot;
</code></pre></p>