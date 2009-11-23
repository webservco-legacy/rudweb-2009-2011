<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>modTicket.tpl.php
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-11-16 15:54:00
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
					<h1><?php echo $lang['MOD']; ?></h1>
					<div class="btn_cls"></div>
					<!--<div class="btn_max"></div>-->
					<!--<div class="btn_min"></div>-->
					<!--<div class="btn_mov"></div>-->
				</div>
			</div>
			
			<div class="win_mid">
				<div class="win_ct_pre">
					<div class="win_ct">

						<form enctype="multipart/form-data"	name="c_<?php echo _APP_PRE; ?>_cm_at" id="<?php echo _APP_PRE; ?>_cm_at" action="" method="post">
							<label for="t_week"><?php echo $lang['WEEK']; ?>:</label>
							<input id="t_week" name="t_week" type="text" size="1" maxlength="2" tabindex="1" value="<?php echo $formData['t_week']; ?>" onkeyup="JavaScript:formJump(this);" />
							&#160;<?php echo $formErr['t_week']; ?>
							<br />
							<label for="t_sn"><?php echo $lang['SN']; ?>:</label>
							<input id="t_sn" name="t_sn" type="text" size="9" maxlength="9" tabindex="2" value="<?php echo $formData['t_sn']; ?>" onkeyup="JavaScript:formJump(this);" />
							&#160;<?php echo $formErr['t_sn']; ?>
							<br />
							<?php echo $lang['NR']; ?>:
							<br />
							<?php 
							foreach ($cells as $cell)
							{
								echo '&#160;'.$formErr['c_'.$cell];
							}
							?>
							<table>
								<tr>
									<td>#</td>
									<td>1</td>
									<td>2</td>
									<td>3</td>
									<td>4</td>
									<td>5</td>
									<td>6</td>
									<td>7</td>
									<td class="check">L</td>
								</tr>
								<?php
								$t=3;
								$n_all = 0;
								$n_today = 0;
								for ($i=1;$i<=7;$i++)
								{
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<?php
										
										for ($j=1;$j<=7;$j++)
										{
											$c = $i.$j;
												$class = '';
												$tclass = '';
												if (in_array($c, $cellsDiag))
												{
													$class = 'diag';
												}
												if ($data[$i.$j]['t_date'] != '0000-00-00')
												{
													$class .= ' check';
													$n_all++;
												}
												if ($data[$i.$j]['t_date'] == date('Y-m-d'))
												{
													$class .= ' today';
													$n_today++;
												}
										?>
											<td><input class="<?php echo $class; ?>" id="c_<?php echo $i.$j; ?>" name="c_<?php echo $i.$j; ?>" type="text" size="2" maxlength="2" tabindex="<?php echo $t; ?>" value="<?php echo $formData['c_'.$i.$j]; ?>" onkeyup="JavaScript:formJump(this);" /></td>
											<?php
											$t++;
										}
										?>
										<td class="check"><?php echo $stats['items']['L'.$i]?></td>
									</tr>
									<?php 
								}
								?>
								<tr>
									<td class="check">C</td>
								<?php
								for ($c=1;$c<=7;$c++)
								{
									?>
									<td class="check"><?php echo $stats['items']['C'.$c]?></td>
									<?php
								}
								?>
								</tr>
							</table>
							<br />
							<!-- 
							<input id="<?php echo _APP_PRE; ?>_submit" name="<?php echo _APP_PRE; ?>_submit" type="submit" tabindex="52" value="<?php echo $lang['S_MOD']; ?>" />
							&#160;&#160;&#160;
							<input id="<?php echo _APP_PRE; ?>_reset" name="<?php echo _APP_PRE; ?>_reset" type="reset" tabindex="53" value="<?php echo $lang['S_RESET']; ?>" />
							 -->
						</form>
						<?php echo $lang['NR']; ?>: <?php echo $n_today; ?> <?php echo $lang['TODAY']; ?>, <?php echo $n_all; ?> <?php echo $lang['TOTAL']; ?>
						<br />
						<?php echo $lang['NUM_LUCKY']; ?>: <?php echo $stats['lucky']; ?>
						<br />
						<?php echo $lang['D1']; ?>: <?php echo $stats['items']['D1']; ?> / 7
						<br />
						<?php echo $lang['D2']; ?>: <?php echo $stats['items']['D2']; ?> / 7
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