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
<h3>Bullshit functions</h3>

<h4>genBullshit</h4>
<p>Generates bullshit text.</p>
<p><pre><code>
function genBullshit($pars=5,$sentences=15,$words=20,$letters=15,$addHtml=3)

$pars       - number of paragraphs to generate
$sentences  - maximal sentences in paragraph
$words      - maximal words in sentece
$letters    - maximal letters in word
$addHtml    - add some html into text
               1 = add &lt;p&gt; and &lt;/p&gt; around each paragraph
               2 = add &lt;p&gt; and &lt;/p&gt; randomly into text
</code></pre></p>

<h4>genParagraph</h4>
<p>Generates one paragraph of bullshit text.</p>
<p><pre><code>
function genParagraph($sentences=15,$words=20,$letters=15,$addHtml=3)

$sentences  - maximal sentences in paragraph
$words      - maximal words in sentece
$letters    - maximal letters in word
$addHtml    - add some html into text
               1 = add &lt;p&gt; and &lt;/p&gt; around each paragraph
               2 = add &lt;p&gt; and &lt;/p&gt; randomly into text
</code></pre></p>

<h4>genSentence</h4>
<p>Generates one sentence of bullshit text.</p>
<p><pre><code>
function genSentence($words=20,$letters=15,$addHtml=3)

$words      - maximal words in sentece
$letters    - maximal letters in word
$addHtml    - add some html into text
               1 = add &lt;p&gt; and &lt;/p&gt; around each paragraph (no effect here)
               2 = add &lt;p&gt; and &lt;/p&gt; randomly into text
</code></pre></p>

<h4>genWord</h4>
<p>Generates one word of bullshit text.</p>
<p><pre><code>
function genWord($letters=15,$addHtml=3)

$letters    - maximal letters in word
$addHtml    - add some html into text
               1 = add &lt;p&gt; and &lt;/p&gt; around each paragraph (no effect here)
               2 = add &lt;p&gt; and &lt;/p&gt; randomly into text
</code></pre></p>
