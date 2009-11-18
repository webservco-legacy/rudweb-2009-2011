<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>addNumbers.tpl.php
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-18 11:36:00
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

		<div id="win_ticket_add" class="win">
			<div class="win_top">
				<div class="win_tt">
					<h1><?php echo $lang['NUM_ADD']; ?></h1>
					<div class="btn_cls"></div>
					<!--<div class="btn_max"></div>-->
					<!--<div class="btn_min"></div>-->
					<!--<div class="btn_mov"></div>-->
				</div>
			</div>
			
			<div class="win_mid">
				<div class="win_ct_pre">
					<div class="win_ct">

						<form enctype="multipart/form-data"	name="<?php echo _APP_PRE; ?>_cm_an" id="<?php echo _APP_PRE; ?>_cm_an" action="" method="post">
							<?php echo $lang['NR']; ?>:
							<br />
							<?php 
							for ($j=1;$j<=7;$j++)
							{
								echo '&#160;'.$formErr['n_'.$j];
							}
							echo '&#160;'.$formErr['l_1'];
							?>
							<br />
							<?php
							for ($i=1;$i<=7;$i++)
							{
							?>
							<input class="num" id="n_<?php echo $i; ?>" name="n_<?php echo $i; ?>" type="text" size="2" maxlength="2" tabindex="<?php echo $i; ?>" value="<?php echo $formData['n_'.$i]; ?>" onkeyup="JavaScript:formJump(this);" />
							<?php
							}
							?>
							<input class="num diag" id="l_1" name="l_1" type="text" size="2" maxlength="2" tabindex="8" value="<?php echo $formData['l_1']; ?>" onkeyup="JavaScript:formJump(this);" />
							<br />
							<br />
							<input id="<?php echo _APP_PRE; ?>_submit" name="<?php echo _APP_PRE; ?>_submit" type="submit" tabindex="9" value="<?php echo $lang['S_ADD']; ?>" />
							&#160;&#160;&#160;
							<input id="<?php echo _APP_PRE; ?>_reset" name="<?php echo _APP_PRE; ?>_reset" type="reset" tabindex="10" value="<?php echo $lang['S_RESET']; ?>" />
						</form>
						
					</div>
				</div>
			</div>
			
			<div class="win_bot">
				<div class="win_st_pre">
					<div class="win_st">
					</div>
				</div>
				<div class="btn_res"></div>
			</div>
		</div>