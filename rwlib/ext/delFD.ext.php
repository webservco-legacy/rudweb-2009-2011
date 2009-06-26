<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>Delete files and directories.
 * <BR>Option to delete only files older than a number of seconds.
 * <BR>Option to also delete files from subdirectories.
 * <BR>Option to also delete subdirectories.
 * <BR>Set file age to 0 to delete all files.
 * <BR>Subdirectories will only be deleted if file age is set to 0
 * <BR>Returns files and folders deleted and total size.
 * <BR>Main directory will never be deleted.
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-01-23 16:58:00
 * @access     public
 * @package    RudWEb
 * @subpackage Extensions
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
 * Prevent direct file access
 */
if(!defined('_RW_VALID')) {require_once('./index.php'); exit;}

error_reporting(E_ALL);

class rw_Ext_delFD extends rw_Ext_global implements rw_iExt
{
	/**
	 * Declare statistics
	 */
	public $stats = array();
	/**
	 * Constructor
	 *
	 * Initialize statistics.
	 * Set extension information and call parent constructor.
	 *
	 * @return null
	 */
	public function __construct($appCore)
	{
		/**
		 * Total directories processed
		 */
		$this->stats['dirs']  = 0;
		/**
		 * Total files processed
		 */
		$this->stats['files'] = 0;
		/**
		 * Total size processed
		 */
		$this->stats['size']  = 0;
		/**
		 * Extension info
		 */
		$about['name'] = 'delFD';
		$about['desc'] = 'Delete files and directories.';
		$about['ver']  = '$Revision$';
		$about['auth'] = 'Radu Maier';
		$about['web']  = 'http://www.rudisoft.net';
		$about['mail'] = 'rudisoft@rudisoft.net';
		$about['deps'] = array();
		$about['deps']['cfg'] = array();
		$about['deps']['ext'] = array();
		parent::__construct($about, $appCore);
	}
	/**
	 * Main extension functionality
	 *
	 * @param string $dir path to initial directory
	 * @param int $age number of seconds a file is considered old and deleted
	 * @param boolean $subdirs whether or not to delete files also from subdirectories
	 * @param boolean $deldirs whether or not to delete the subdirectories
	 * @return boolean result
	 */
	public function delFD($dir, $age=0, $subdirs=TRUE, $deldirs=TRUE)
	{
		if(is_dir($dir))
		{
			if($dh = opendir($dir))
			{
				while (FALSE !== ($file = readdir($dh)))
				{
					if($file != '.' && $file != '..')
					{
						if(is_file($dir.$file) && (filemtime($dir.$file) < (time()-$age)))
						{
							$this->stats['size'] += filesize($dir.$file);
							unlink($dir.$file);
							$this->stats['files']++;
						}
						else if(is_dir($dir.$file))
						{
							if($subdirs)
							{
								$subdir = $dir.basename($file) . '/';
								$this->delFD($subdir, $age, $subdirs, $deldirs);
								$this->stats['dirs']++;
							}
							if($deldirs && $age == 0)
							{
								rmdir($dir.$file);
							}
						}
					}
				}
				closedir($dh);
			}
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	/**
	 * Show statistics
	 *
	 * @return array statistics
	 */
	function showStats()
	{
		return $this->stats;
	}
	/*
	 * Reset statistics
	 *
	 * @return boolean result
	 */
	function resetStats()
	{
		$this->stats['dirs'] = 0;
		$this->stats['files'] = 0;
		$this->stats['size'] = 0;
	}
}
?>