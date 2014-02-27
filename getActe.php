<?php
/**
 * ActesAPI module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright    The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license             http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    ActesAPI
 * @since        2.3.0
 * @author	yann bogdanovic <http://pole-numerique.cdg46.fr>
**/

if ( !include("../../mainfile.php") ) {
    die("XOOPS root path not defined");
}
$module_dirname = basename( dirname( __FILE__ ) ) ;

global $xoopsModuleConfig;

$actesapi_url     = $xoopsModuleConfig["actesapiconf1"];
$actesapi_key     = $xoopsModuleConfig["actesapiconf2"];
$actesapi_secret  = $xoopsModuleConfig["actesapiconf3"];

/* FUNCTION CURL */
function readHeader($ch, $header)
{
    global $responseHeaders;
    $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    $responseHeaders[$url][] = $header;

    return strlen($header);
}

/* Récupération du fichier et renvoi au navgateur pour téléchargment */
$content     = '/api/v1/acte/'.$_GET['id'].'/document';
if (isset($_GET['tampon'])) $content.='/tampon';

$hash = hash_hmac('sha256', $content, $privateHash);

$headers = array(
    'X-Public: ' . $publicHash,
    'X-Hash: '   . $hash
);

$hash = hash_hmac('sha256', $content, $xoopsModuleConfig["actesapiconf3"]);

$headers = array(
    'X-Public: '. $xoopsModuleConfig["actesapiconf2"],
    'X-Hash: '  . $hash
);

$server = $xoopsModuleConfig["actesapiconf1"];
$url = $server.$content;

$ch = curl_init($url);
curl_setopt_array($ch, array(
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_HTTPHEADER     => $headers,
    CURLOPT_HEADER         => 0,
    CURLOPT_HEADERFUNCTION => 'readHeader',

    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSLVERSION     => 3,
    CURLOPT_PORT           => 443,

    CURLOPT_TIMEOUT        => 50,
));

$string = curl_exec ($ch);
curl_close($ch);
var_dump($responseHeaders);
foreach($responseHeaders["{$url}"] as $responseHeader)
{
    if (false !== strpos($responseHeader, ':'))
    {

        list($header, $message) = explode(':', $responseHeader);

        if (in_array($header, array('Content-Type', 'Content-Disposition')))
        {

            if (false !== strpos($message, 'filename'))
            {

                $fileNameFromHeader = str_replace(' attachment; filename=', '', $message);

            }
            header($header . ':' . $message);
        }
    }
}

echo($string);
