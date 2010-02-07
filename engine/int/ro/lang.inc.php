<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Engine internationalization file (romanian)
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-09-22 16:50:00
 * @access     public
 * @package    rwInt
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
 * Security check.
 */
if (!defined('_RW_VALID'))
{
	/**
	 * Display "Not Found" page.
	 */
	require_once('./var/err/404.php');
	/**
	 * Stop script execution.
	 */
	exit;
}

$langCore['ERROR']['CODESTR']['E_UNKNOWN']           = 'Cod eroare necunoscut.';
$langCore['ERROR']['CODESTR']['E_ERROR']             = 'Eroare fatal&#259; la execu&#355;ie.';
$langCore['ERROR']['CODESTR']['E_WARNING']           = 'Avertisment la execu&#355;ie.';
$langCore['ERROR']['CODESTR']['E_PARSE']             = 'Eroare de parsare &#238;n momentul compil&#259;rii.';
$langCore['ERROR']['CODESTR']['E_NOTICE']            = 'Aten&#355;ionare la execu&#355;ie.';
$langCore['ERROR']['CODESTR']['E_CORE_ERROR']        = 'Eroare fatal&#259; ap&#259;rut&#259; &#238;n timpul rul&#259;rii ini&#355;iale a PHP-ului.';
$langCore['ERROR']['CODESTR']['E_CORE_WARNING']      = 'Avertisment ap&#259;rut &#238;n timpul rul&#259;rii ini&#355;iale a PHP-ului.';
$langCore['ERROR']['CODESTR']['E_COMPILE_ERROR']     = 'Eroare fatal&#259; ap&#259;rut&#259; &#38;n timpul compil&#259;rii.';
$langCore['ERROR']['CODESTR']['E_COMPILE_WARNING']   = 'Avertisment ap&#259;rut &#38;n timpul compil&#259;rii.';
$langCore['ERROR']['CODESTR']['E_USER_ERROR']        = 'Mesaj de eroare generat de nucleul website-ului.';
$langCore['ERROR']['CODESTR']['E_USER_WARNING']      = 'Mesaj de avertisment generat de nucleul website-ului.';
$langCore['ERROR']['CODESTR']['E_USER_NOTICE']       = 'Mesaj de aten&#355;ionare generat de nucleul website-ului.';
$langCore['ERROR']['CODESTR']['E_STRICT']            = 'Aten&#355;ionare la execu&#355;ie.';
$langCore['ERROR']['CODESTR']['E_RECOVERABLE_ERROR'] = 'Eroare fatal&#259; ce poate fi capturat&#259;.';
$langCore['ERROR']['CODESTR']['E_DEPRECATED']        = 'Cod scos din uz.';
$langCore['ERROR']['CODESTR']['E_USER_DEPRECATED']   = 'Cod scos din uz (mesaj generat de nucleul website-ului).';
$langCore['ERROR']['CODESTR']['E_ALL']               = 'Toate erorile &#351;i avertismentele.';

$langCore['ERROR']['Database']['TYPE_NOT_SUPPORTED'] = 'Tipul de baze de date <b>%0%</b> nu este disponibil.';
$langCore['ERROR']['Database']['COULD_NOT_CONNECT']  = 'Conectarea la serverul de baze de date a e&#351;uat. V&#259; rug&#259;m verifica&#355;i detaliile conexiunii.';
$langCore['ERROR']['Database']['COULD_NOT_OPEN']     = 'Baza de date <b>%0%</b> nu a putut fi deschis&#259;. V&#259; rug&#259;m verifica&#355;i ca baza de date respeciv&#259; s&#259; fie disponibil&#259;, &#351;i dac&#259; ave&#355;i drepturi de acces asupra ei.';
$langCore['ERROR']['Database']['DEBUG']              = 'Debug. Query: <b>%0%</b>';
$langCore['ERROR']['Database']['QUERY']              = 'Eroare Query: <b>%0%</b> <b>%1%</b>';

$langCore['ERROR']['Engine']['NO_LIB_1']             = 'Biblioteca solicitat&#259; <b>%0%</b> nu exist&#259;.';
$langCore['ERROR']['Engine']['NO_LIB_2']             = 'Biblioteca solicitat&#259; <b>%0%</b> nu exist&#259; sau nu este accesibil&#259; pentru &#238;nc&#259;rcare.';
$langCore['ERROR']['Engine']['NO_EXT']               = 'Extensia <b>%0%</b> nu a fost g&#259;sit&#259;.';
$langCore['ERROR']['Engine']['LIB_OUTPUT_DISPLAY']   = 'Datele de ie&#351;ire nu pot fi afi&#351;ate. Biblioteca <b>Output</b> nu este &#238;nc&#259;rcat&#259;.';
$langCore['ERROR']['Engine']['LIB_OUTPUT_PARSE']     = 'Datele de ie&#351;ire nu pot fi parsate. Biblioteca <b>Output</b> nu este &#238;nc&#259;rcat&#259;.';

$langCore['ERROR']['Extension']['NO_LIB_DEP']        = 'Extensia <b>%0%</b> nu poate fi &#238;nc&#259;rcat&#259;. Lipsesc dependin&#355;e de bibliotec&#259; (<b>%1%</b>).';
$langCore['ERROR']['Extension']['NO_EXT_DEP']        = 'Extensia <b>%0%</b> nu poate fi &#238;nc&#259;rcat&#259;. Lipsesc dependin&#355;e de extensie (<b>%1%</b>).';
$langCore['ERROR']['Extension']['SET_PROPERTY']      = 'S-a &#238;ncercat stabilirea unei propriet&#259;&#355;i ce nu exist&#259; sau nu este disponibil&#259;.';
$langCore['ERROR']['Extension']['MAIL_INFO']         = 'Mesajul email nu a putut fi trimis. Nu sunt destule informa&#355;ii.';

$langCore['ERROR']['Module']['NO_FILE']              = 'Modulul <b>%0%</b> nu poate fi &#238;nc&#259;rcat. Fi&#351;ierul nu a fost g&#259;sit.';
$langCore['ERROR']['Module']['NO_LIB_DEP']           = 'Modulul <b>%0%</b> nu poate fi &#238;nc&#259;rcat. Lipsesc dependin&#355;e de bibliotec&#259; (<b>%1%</b>).';
$langCore['ERROR']['Module']['NO_EXT_DEP']           = 'Modulul <b>%0%</b> nu poate fi &#238;nc&#259;rcat. Lipsesc dependin&#355;e de extensie (<b>%1%</b>).';
$langCore['ERROR']['Module']['NO_MOD_DEP']           = 'Modulul <b>%0%</b> nu poate fi &#238;nc&#259;rcat. Lipsesc dependin&#355;e de modul (<b>%1%</b>).';
$langCore['ERROR']['Module']['NO_ACT']               = 'Opera&#355;ia specificat&#259; nu este valid&#259;.';
$langCore['ERROR']['Module']['NO_ACT_FOUND']         = 'Opera&#355;ia specificat&#259; nu a fost g&#259;sit&#259;.';

$langCore['ERROR']['Output']['NO_ENGINE']            = 'Motorul de ie&#351;ire a datelor specificat nu poate fi &#238;nc&#259;rcat. Fi&#351;ierul nu a fost g&#259;sit.';
$langCore['ERROR']['Output']['NO_TEMPLATE']          = 'Fi&#351;ierul &#351;ablon <b>%0%</b> nu a fost g&#259;sit.';
$langCore['ERROR']['Output']['NO_SMARTY']            = 'Biblioteca pentru motorul de ie&#351;ire a datelor <b>Smarty</b> nu a fost g&#259;sit&#259;.';
?>