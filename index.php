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
 * @copyright	The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license             http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package	ActesAPI
 * @since		2.3.0
 * @author 	kris <http://www.xoofoo.org>
 * @version	$Id: index.php 531 2011-01-08 13:25:26Z kris_fr $
**/

if ( !include("../../mainfile.php") ) {
    die("XOOPS root path not defined");
}
$module_dirname = basename( dirname( __FILE__ ) ) ;



global $xoopsModuleConfig;

$actesapi_url     = $xoopsModuleConfig["actesapiconf1"];
$actesapi_key     = $xoopsModuleConfig["actesapiconf2"];
$actesapi_secret  = $xoopsModuleConfig["actesapiconf3"];

$xoopsOption["template_main"] =  $module_dirname ."_index.html";

include(XOOPS_ROOT_PATH."/header.php");

// FIXME
$content = "coll/214602104/actes";

$total = json_decode(get($content.'/total', $publicHash,$privateHash));

$total = $total[0];

if (isset($_GET['page']))    $content .= '/page/'    . $_GET['page'];
if (isset($_GET['perpage'])) $content .= '/pagination/' . $_GET['perpage'];


$perpage = (isset($_GET['perpage'])) ? $_GET['perpage'] : 10;
$page    = (isset($_GET['page']))    ? $_GET['page']    : 1;
$debut = ($page - 1 ) * $perpage + 1;


$actes = json_decode(get($content));

$nactes = array();
$i = 0;
foreach ($actes as $acte)
{
    $nacte = (array) $acte;

    if (null !== $acte->aracteid)
    {
        $aracte = json_decode(get('acte/'.$acte->acteid.'/aracte'));
        $nacte['aracteDateReception'] = $aracte[0]->DateReception;
    }
    if (null !== $acte->anomalieacteid)
    {
        $anomalie = json_decode(get('acte/'.$acte->acteid.'/anomalie'));
        $nacte['anomalieDateReception'] = $anomalie[0]->DateReception;
    }
    if (null !== $acte->annulationacteid)
    {
        $annulation = json_decode(get('acte/'.$acte->acteid.'/annulation'));
        $nacte['annulationDateReception'] = $annulation[0]->DateReception;
    }
    $nactes[] = $nacte;

    if(isset($xoTheme) && is_object($xoTheme)) {
        $xoopsTpl->append("actes",$nactes[$i]);
    }
    ++$i;
}

/* FUNCTION CURL */
function get($route)
{
	global $xoopsModuleConfig;

	$content     = '/api/v1/'.$route;

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

		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_SSLVERSION     => 3,
		CURLOPT_PORT           => 443,

		CURLOPT_TIMEOUT        => 50,
	));

	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

include(XOOPS_ROOT_PATH."/footer.php");
?>
