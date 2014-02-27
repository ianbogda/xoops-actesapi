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

if (!defined("XOOPS_ROOT_PATH")) { die("XOOPS root path not defined"); }

function actesapi_killDir($chemin) {
    if ($chemin[strlen($chemin)-1] != '/') { $chemin .= '/'; } 
    if (is_dir($chemin)) {
         $sq = opendir($chemin); 
         while ($f = readdir($sq)) {
            if ($f != '.' && $f != '..'){
                $fichier = $chemin.$f; 
                if (is_dir($fichier)) {actesapi_killDir($fichier);} 
            else {unlink($fichier);}
        }
    }
    closedir($sq);
    rmdir($chemin); 
    }
    else {unlink($chemin); }
}

function xoops_module_uninstall_actesapi(&$module) {
    global $xoopsModuleConfig, $xoopsDB, $xoopsModule;
        actesapi_killDir(XOOPS_ROOT_PATH . "/uploads/actesapi" );
    return true;
}
?>