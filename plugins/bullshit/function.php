<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | wessie - web site system                                             |
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

$vowels = array('a','e','i','o','u','y');
$consonants = array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','u','v','w','x','y','z');

// seed with microseconds
function make_seed() {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}
srand(make_seed());

/*
$pars       - number of paragraphs to generate
$senteces   - maximal senteces in paragraph
$words      - maximal words in sentece
$letters    - maximal letters in word
$addHtml    - add some html into text
                1 - <p>
                2 - <a>
*/
function genBullshit($pars=5,$senteces=15,$words=20,$letters=15,$addHtml=3) {
    $text = "";

    for ($i = 0; $i <= $pars; $i++) {
        $text .= genParagraph($senteces,$words,$letters,$addHtml);
        if ($i != $pars) {
            $text .= "\n";
        }
    }

    return $text;
}

function genParagraph($senteces,$words,$letters,$addHtml) {
    $par = "";
    if (($addHtml & 1) == 1) {
        $par .= "<p>";
    }

    $count = rand(1,$senteces);
    for ($x = 0; $x <= $count; $x++) {
        $par .= genSentence($words,$letters,$addHtml);
        if ($x != $count) {
            $par .= " ";
        }
    }

    if (($addHtml & 1) == 1) {
        $par .= "</p>";
    } else {
        $par .= "\n";
    }

    return $par;
}

function genSentence($words,$letters,$addHtml) {
    $sentence = "";
    $was_a = FALSE;
    $first = TRUE;
    $count = rand(2,$words);
    for ($n = 0; $n <= $count; $n++) {
        if (!$was_a && (($addHtml & 2) == 2) && rand(0,20) < 1) {
            $was_a = TRUE;
            $sentence .= '<a href="/">';
        }
        if ($first || rand(0,50)<2){
            $sentence .= ucfirst(genWord($letters,$addHtml));
            $first = FALSE;
        } else {
            $sentence .= genWord($letters,$addHtml);
        }
        if ($was_a && rand(0,10) < 5) {
            $was_a = FALSE;
            $sentence .= '</a>';
        }
        if ($n != $count) {
            $sentence .= " ";
        }
    }
    if ($was_a) {
        $sentence .= '</a>';
    }
    return $sentence.'.';
}

function genWord($letters,$addHtml) {
    $vowel = 0;
    $consonant = 0;
    $word = "";
    $special = rand(0,100);
    $prev = ' ';
    if ($special<2) {
        $word = genWord($letters,$addHtml) . "-" . genWord($letters,$addHtml);
    } else {
        $count = rand(2,$letters);
        for ($m = 0; $m < $count; $m++) {
            $word .= genLetter($vowel,$consonant,$prev);
        }
    }
    return $word;
}

function genLetter(&$vowel,&$consonant,&$prev) {
    global $vowels,$consonants;
    $letter = chr(rand(97,122));
    if ($prev == $letter) {
        $letter = chr(rand(97,122));
    }

    //echo "'${vowel},${consonant}->${letter}->";

    if (in_array($letter,$vowels)) $vowel++;

    if (($vowel*rand(1,2)) > 2 && $consonant<2) {
        $letter = $consonants[rand(0,count($consonants)-1)];
        $vowel = 0;
    }

    if (in_array($letter,$consonants)) $consonant++;

    if (($consonant*rand(1,2)) > 2 && $vowel<2) {
        $letter = $vowels[rand(0,count($vowels)-1)];
        $consonant = 0;
    }

    //echo "${letter}->$vowel,$consonant'\n<br>";

    $prev = $letter;
    return $letter;
}
?>
