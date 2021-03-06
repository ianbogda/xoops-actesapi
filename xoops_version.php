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

$module_dirname = basename( dirname( __FILE__ ) ) ;

$modversion["name"]                =  _MI_ACTESAPI_NAME;
$modversion["version"]             = '1.0.0';
$modversion["description"]         = _MI_ACTESAPI_DESC;
$modversion["author"]              = "Yann Bogdanovic";
$modversion["credits"]             = "Pôle Numérique du CDGFPT46";
$modversion["help"]                = "";
$modversion["dirname"]             = $module_dirname;
$modversion["image"]               = "images/" . $module_dirname . "_slogo.png";
$modversion["license"]             = "GNU General Public License";
$modversion["license_url"]         = "http://www.gnu.org/licenses/gpl.html";
$modversion["official"]            = 0;
$modversion["author_website_url"]  = "http://pole-numerique.cdg46.fr";
$modversion["author_website_name"] = "Pôle Numérique du CDGFPT46";

// About
$modversion["demo_site_url"]       = "";
$modversion["demo_site_name"]      = "";
$modversion["module_website_url"]  = "http://pole-numerique.cdg46.fr";
$modversion["module_website_name"] = "Pôle Numérique du CDGFPT46";
$modversion["module_release"]      = "27 Fev. 2014";
$modversion["module_status"]       = "Final";

// Scripts to run upon install, uninstall or update
$modversion["onInstall"]   = "include/install.php"; // example for create folder in root/uploads
$modversion["onUninstall"] = "include/uninstall.php";
$modversion["onUpdate"]    = "include/update.php";

// Admin Menu
$modversion["system_menu"] = 1 ; // Set to 1 if you want to display menu tabs generated by system module
$modversion["hasAdmin"]    = 1; // active = 1
$modversion["adminindex"]  = "admin/index.php";
$modversion["adminmenu"]   = "admin/menu.php";

// Menu
$modversion["hasMain"]     = 1; // active = 1

$i = 1;
$modversion["sub"][$i]["name"] = _MI_ACTESAPI_SMNAME1;
$modversion["sub"][$i]["url"]  = "index.php";

// Config
$i = 1;
$modversion["config"][$i]["name"]        = "actesapiconf1"; // API URL
$modversion["config"][$i]["title"]       = "_MI_ACTESAPI_CONF1";
$modversion["config"][$i]["description"] = "_MI_ACTESAPI_CONF1_DESC";
$modversion["config"][$i]["formtype"]    = "textbox";
$modversion["config"][$i]["valuetype"]   = "text";
$modversion["config"][$i]["default"]     = _MI_ACTESAPI_CONF1_DEFAULT;
$i++;
$modversion["config"][$i]["name"]        = "actesapiconf2"; // API KEY
$modversion["config"][$i]["title"]       = "_MI_ACTESAPI_CONF2";
$modversion["config"][$i]["description"] = "_MI_ACTESAPI_CONF2_DESC";
$modversion["config"][$i]["formtype"]    = "textbox";
$modversion["config"][$i]["valuetype"]   = "text";
$modversion["config"][$i]["default"]     = _MI_ACTESAPI_CONF2_DEFAULT;
$i++;
$modversion["config"][$i]["name"]        = "actesapiconf3"; // API Secret
$modversion["config"][$i]["title"]       = "_MI_ACTESAPI_CONF3";
$modversion["config"][$i]["description"] = "_MI_ACTESAPI_CONF3_DESC";
$modversion["config"][$i]["formtype"]    = "textbox";
$modversion["config"][$i]["valuetype"]   = "text";
$modversion["config"][$i]["default"]     = _MI_ACTESAPI_CONF3_DEFAULT;

// Templates
$i = 1;
$modversion["templates"][$i]["file"]        = $module_dirname . "_index.html";
$modversion["templates"][$i]["description"] = _MI_ACTESAPI_DSCTPL1;
$i++;
$modversion["templates"][$i]["file"]        = $module_dirname . "_detailActe.html";
$modversion["templates"][$i]["description"] = _MI_ACTESAPI_DSCTPL2;
$i++;
$modversion["templates"][$i]["file"]        = "admin/". $module_dirname . "_admin_index.html";
$modversion["templates"][$i]["description"] = _MI_ACTESAPI_MANAGER_INDEX_DESC;

$i++;
$modversion["templates"][$i]["file"]        = "admin/". $module_dirname . "_admin_about.html";
$modversion["templates"][$i]["description"] = _MI_ACTESAPI_MANAGER_ABOUT_DESC;
$i++;
$modversion["templates"][$i]["file"]        = "admin/". $module_dirname . "_admin_help.html";
$modversion["templates"][$i]["description"] = _MI_ACTESAPI_MANAGER_HELP_DESC;

?>
