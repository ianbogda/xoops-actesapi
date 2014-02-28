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
 * @author    yann bogdanovic <http://pole-numerique.cdg46.fr>
**/

if ( !include("../../mainfile.php") ) {
    die("XOOPS root path not defined");
}
$module_dirname = basename( dirname( __FILE__ ) ) ;

global $xoopsModuleConfig, $xoopsDB;

// get collectivités from db
$sql = 'SELECT siren, nom FROM ' . $xoopsDB->prefix('stelamiat_collectivites') . ' WHERE groupid IN (' . implode(',', $xoopsUser->getGroups()) . ')';
$result = $xoopsDB->query($sql);

$sirens = $noms = array();
while (list($siren, $nom) = $xoopsDB->fetchRow($result)) {
    $sirens[]         = $siren;
    $noms["{$siren}"] = $nom;
}
$sirens = implode(',', $sirens);

// Module config
$actesapi_url     = $xoopsModuleConfig["actesapiconf1"];
$actesapi_key     = $xoopsModuleConfig["actesapiconf2"];
$actesapi_secret  = $xoopsModuleConfig["actesapiconf3"];

$xoopsOption["template_main"] =  $module_dirname ."_index.html";

include(XOOPS_ROOT_PATH."/header.php");

$content = "coll/{$sirens}/actes";

//récupération des N actes de la liste de coll
$actes = json_decode(get($content));

$nactes = array();
$i = 0;
foreach ($actes as $acte)
{
    $nacte = (array) $acte;

    // Récupération de la date de réception pref
    if (null !== $acte->aracteid)
    {
        $aracte = json_decode(get('acte/'.$acte->acteid.'/aracte'));
        $nacte['aracteDateReception'] = $aracte[0]->DateReception;
    }
    // Récupération de la date de réception pref d'une anomalie
    if (null !== $acte->anomalieacteid)
    {
        $anomalie = json_decode(get('acte/'.$acte->acteid.'/anomalie'));
        $nacte['anomalieDateReception'] = $anomalie[0]->DateReception;
    }
    // Récupération de la date de réception pref de l'annulation
    if (null !== $acte->annulationacteid)
    {
        $annulation = json_decode(get('acte/'.$acte->acteid.'/annulation'));
        $nacte['annulationDateReception'] = $annulation[0]->DateReception;
    }

    $nacte['coll'] = $noms[$nacte['siren']];
    $nactes[] = $nacte;

    // Envoi des infos au template Smarty pour affichage
    if(isset($xoTheme) && is_object($xoTheme)) {
        $xoopsTpl->append("actes",$nactes[$i]);
    }
    ++$i;
}

/* FUNCTION CURL */
function get($route)
{
    global $xoopsModuleConfig;

    $content = '/api/v1/'.$route;
    $hash    = hash_hmac('sha256', $content, $xoopsModuleConfig["actesapiconf3"]);
    $headers = array(
        'X-Public: ' . $xoopsModuleConfig["actesapiconf2"],
        'X-Hash: '   . $hash
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
