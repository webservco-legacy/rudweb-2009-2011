<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>layout.tpl.php
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-04 18:19:00
 * @access     public
 * @package    rwOut
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
?>
<?php echo '<?xml version="1.0" encoding="utf-8" standalone="no"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $_SESSION[_APP_PRE.'_usr']['ln']?>" lang="<?php echo $_SESSION[_APP_PRE.'_usr']['ln']?>">
<head>
	<?php echo $header; ?>
</head>
<body>
	<div id="interface">
		<div id="taskbar">
			<div id="start">
				<?php echo $menu; ?>
			</div>
		</div>
		
		<div id="reload" class="icon">
			<div class="name">Reload</div>
		</div>
		<?php echo $content; ?>
	</div>
	<?php echo $footer; ?>
</body>
</html>