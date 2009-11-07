<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>login.tpl.php
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-05 11:41:00
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
		<div id="loginwin" class="win">
			<div class="win_top">
				<div class="win_tt">
					<h1>Log In</h1>
					<div class="btn_cls"></div>
					<!--<div class="btn_max"></div>-->
					<!--<div class="btn_min"></div>-->
					<!--<div class="btn_mov"></div>-->
				</div>
			</div>
			
			<div class="win_mid">
				<div class="win_ct_pre">
					<div class="win_ct">
						
						<form enctype="multipart/form-data"	name="<?php echo _APP_PRE; ?>_login_form" id="<?php echo _APP_PRE; ?>_login_form" action="" method="post">
							<input	type="hidden" name="<?php echo _APP_PRE; ?>_token" value="<?php echo $_SESSION[_APP_PRE.'_usr']['token'];?>" />
							User login:
							<input class="" type="text" name="<?php echo _APP_PRE; ?>_login" id="<?php echo _APP_PRE; ?>_login" maxlength="30" value="<?php echo $formData[_APP_PRE.'_login']; ?>" />
							<?php echo $formErr[_APP_PRE.'_login']; ?>
							<br />
							Password:
							<input class="" type="password" name="<?php echo _APP_PRE; ?>_pass" id="<?php echo _APP_PRE; ?>_pass" maxlength="30" value="<?php echo $formData[_APP_PRE.'_pass']; ?>" />
							<?php echo $formErr[_APP_PRE.'_pass']; ?>
							<br />
							Security code: <img src="<?php echo _APP_URL; ?>RudWI/captcha.png" />
							<input class="" type="text" name="<?php echo _APP_PRE; ?>_captcha" id="<?php echo _APP_PRE; ?>_captcha" maxlength="5" value="<?php echo $formData[_APP_PRE.'_captcha']; ?>" />
							<?php echo $formErr[_APP_PRE.'_captcha']; ?>
							<br />
							<input class="" type="submit" name="<?php echo _APP_PRE; ?>_submit" id="<?php echo _APP_PRE; ?>_submit" value="Submit" />
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