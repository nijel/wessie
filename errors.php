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
// Error handling code

/**
 * Load configuration
 */
$confing_file='./config.php';
if (file_exists($confing_file)) {
    include_once($confing_file);
} else {
    for ($i=0; $i<3; $i++){
        $confing_file = '../' . $confing_file;
        if (file_exists($confing_file)) {
            include_once($confing_file);
            break;
        }
    }
}
/**
 * Set configuration to default values if config.php wasn't included
 */
if (!isset($site_name)){
    $error_log_file='./logs/error.log';
    $site_name='wessie';
    $show_error_detail=FALSE;
}


/**
 * Logs error
 *
 * @param   string   message to be logged
 */
function log_error($what){
    global $error_log_file;
    $fh=fopen($error_log_file,'a');
    fwrite($fh,date("Ymd").'-'.date("H:i:s").':'.$what."\n");
    fclose($fh);
}

/**
 * Performs error - send to client error message and logs it
 *
 * @param   int      error type
 * @param   string   error description
 */
function do_error($err_type=0,$err_nfo=''){
    global $SERVER_PROTOCOL, $site_name, $show_error_detail, $base_path, $SERVER_NAME;

    $err_names[0] = 'fallback and default';
    $err_names[1] = 'bad SQL';
    $err_names[2] = 'missing language file';
    $err_names[3] = 'page not found';
    $err_names[4] = 'missing template file';
    $err_names[5] = 'missing content file';
    $err_names[6] = 'cannot connect to MySQL';
    $err_name = isset($err_names[$err_type])?$err_names[$err_type]:$err_names[0];

    $headers[0] = '503 Service temporarily unavailable';
    $headers[1] = '503 Service temporarily unavailable';
    $headers[2] = '404 Not found';
    $headers[3] = '404 Not found';
    $headers[4] = '503 Service temporarily unavailable';
    $headers[5] = '503 Service temporarily unavailable';
    $headers[6] = '503 Service temporarily unavailable';

    $header = $SERVER_PROTOCOL . ' ' . (isset($headers[$err_type])?$headers[$err_type]:$headers[0]);
    $http_err_type = substr((isset($headers[$err_type])?$headers[$err_type]:$headers[0]),0,1);

    $messages[0] = 'Internal server error';
    $messages[1] = 'Internal server error';
    $messages[2] = 'Requested language version is not available.';
    $messages[3] = 'Requested page was not found';
    $messages[4] = 'Internal server error';
    $messages[5] = 'Internal server error';
    $messages[6] = 'Internal server error';
    $message = isset($messages[$err_type])?$messages[$err_type]:$messages[0];




    //header ($header);
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">'."\n".
        '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">'.
        "\n<head><title>$site_name</title></head><body>\n".
        "<h2>$site_name</h2>\n<h3>$header</h3>\n".
        "<p>$message</p>\n";

    if ($http_err_type == 5){
        echo "<br />\nThis page has currently some technical problems. Please try looking on oher page or connecting later.<br />";
        if (isset($base_path)){
            echo 'You can try visiting main page of this site: <a href="http://'.$SERVER_NAME.$base_path.'main.php">http://'.$SERVER_NAME.$base_path.'main.php</a><br />'."\n";
        }
        echo "There is no need to contact administrator, because he surely knows about this....<br />\n";
    }

    echo $show_error_detail?"<p>Error details:<br />\n<code>\n":"<!--Error details:\n";
    echo $err_name;
    echo $show_error_detail?"<br />\n":"\n";
    echo $err_nfo;
    echo $show_error_detail?"\n</code>\n</p>":"\n-->";
    log_error($err_type.' ['.$err_name.'] - '.$err_nfo);
    echo '</body></html>';
    exit;
}
?>
