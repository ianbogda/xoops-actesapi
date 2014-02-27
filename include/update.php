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
 * @author	yann bogdanovic <http://pole-numerique.cdg46.fr>
**/

if (!defined("XOOPS_ROOT_PATH")) { die("XOOPS root path not defined"); }

include_once XOOPS_ROOT_PATH . "/modules/actesapi/include/install.php";

function xoops_module_update_actesapi() {
    if ( !call_user_func("xoops_module_pre_install_actesapi") ) {
        return false;
    }
    return true;
}
?>