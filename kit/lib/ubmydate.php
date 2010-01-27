<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>No description
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @access     public
 * @package    RudWEb-1.0
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
 *
Project     : Ub My Date - PHP MySQL date conversion script
Purpose     : Get the date in MySQL format and convert it in other formats
File name   : ubmydate.php
Version     : 1.0.070825
Author(s)   : Radu Maier
Copyright   : Copyright (C) 2006 Radu Maier oimoroiATgmailDOTcom
License     : GNU/GPL
Website     : http://underbeat.evonet.ro

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public  License for more details.

You should have received a copy of the GNU General Public License
along with this program from the site that you downloaded it
from; if not. write to the Free Software Foundation, Inc., 59 Temple
Place, Suite 330, Boston, MA 02111-1307 USA
*/

// EXAMPLE:
//MyDate('2006-30-15', 'dd/mm/yyyy');

function MyDate($dataSQL, $dateformat) {
  $mydateDD  = substr($dataSQL, 8, 2);
  $mydateMM  = substr($dataSQL, 5, 2);
  $mydateYY  = substr($dataSQL, 0, 4);

  switch($dateformat) {
    case "dd": {
      $mydate = $mydateDD;
      break;
    }
    case "mm": {
      $mydate = $mydateMM;
      break;
    }
    case "yyyy": {
      $mydate = $mydateYY;
      break;
    }
    case "dd/mm": {
      $mydate = $mydateDD . '&#47;' . $mydateMM;
      break;
    }
    case "mm/yyyy": {
      $mydate = $mydateMM . '&#47;' . $mydateYY;
      break;
    }
    case "dd/mm/yyyy": {
      $mydate = $mydateDD . '&#47;' . $mydateMM . '&#47;' . $mydateYY;
      break;
    }
    case "dd-mm-yyyy": {
      $mydate = $mydateDD . '&#45;' . $mydateMM . '&#45;' . $mydateYY;
      break;
    }
    default: { // dd/mm/yyyy
      $mydate = $mydateDD . '&#47;' . $mydateMM . '&#47;' . $mydateYY;
      break;
    }
  }
  return $mydate;
}
?>