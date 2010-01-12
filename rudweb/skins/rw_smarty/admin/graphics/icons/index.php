<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Display custom 404 page
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-17 16:09:00
 * @access     public
 * @package    rwSec
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

header('HTTP/1.1 404 Not Found');
echo '<?xml version="1.0" encoding="utf-8" standalone="no"?>'."\n";
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<meta http-equiv="content-language" content="en" />';
echo '<title>404 Not Found</title>';
echo '</head><body>';
echo '<h1>404 Not Found</h1>' . "\n\t" . 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found on this server.';
echo '</body></html>';
exit;
?>