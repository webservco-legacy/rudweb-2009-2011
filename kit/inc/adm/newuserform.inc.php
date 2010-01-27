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
./inc/adm/newuserform.inc.php
11:23 2008-04-14
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

?>
<DIV CLASS="text" STYLE="text-align: center;">
<BR>
<!--Intro text (work in progress)-->
<FORM ENCTYPE="multipart/form-data" CLASS="contaddform" NAME="newuser1" ACTION="" METHOD="post">

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="5" ALIGN="center">

<TR>
  <TD STYLE="text-align: right;"><BR></TD>
  <TD STYLE="text-align: left;"></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php if($err_msg != '') {echo '<SPAN STYLE="font-weight: bold; color: #FF0000;">'.$rudweb_ln['err']['tt'].'</SPAN>';}?></TD>
  <TD STYLE="text-align: left;"><?php echo $err_msg;?></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrfirstname'];?>:</TD>
  <TD STYLE="text-align: left;">
  <INPUT CLASS="forminput" STYLE="background-color: <?php echo $rudweb_skin['BgReqColor'];?>" TYPE="text" NAME="usr_first_name" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_first_name;?>">
  &#160;&#42;
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrmiddlename'];?>:</TD>
  <TD STYLE="text-align: left;"><INPUT CLASS="forminput" TYPE="text" NAME="usr_middle_name" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_middle_name;?>"></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrlastname'];?>:</TD>
  <TD STYLE="text-align: left;">
  <INPUT CLASS="forminput" STYLE="background-color: <?php echo $rudweb_skin['BgReqColor'];?>" TYPE="text" NAME="usr_last_name" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_last_name;?>">
  &#160;&#42;
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><BR></TD>
  <TD STYLE="text-align: left;"></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrphone'];?>:</TD>
  <TD STYLE="text-align: left;">
  <INPUT CLASS="forminput" TYPE="text" NAME="usr_phone" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_phone;?>">
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usraddress'];?>:</TD>
  <TD STYLE="text-align: left;">
  <TEXTAREA CLASS="forminput" NAME="usr_address" COLS="17" ROWS="2"><?php echo $usr_address;?></TEXTAREA>
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrcountry'];?>:</TD>
  <TD STYLE="text-align: left;">
  <INPUT CLASS="forminput" STYLE="background-color: <?php echo $rudweb_skin['BgReqColor'];?>" TYPE="text" NAME="usr_country" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_country;?>">
  &#160;&#42;
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><BR></TD>
  <TD STYLE="text-align: left;"></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usremail1'];?>:</TD>
  <TD STYLE="text-align: left;">
  <INPUT CLASS="forminput" STYLE="background-color: <?php echo $rudweb_skin['BgReqColor'];?>" TYPE="text" NAME="usr_email1" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_email1;?>">
  &#160;&#42;
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usremail2'];?>:</TD>
  <TD STYLE="text-align: left;">
  <INPUT CLASS="forminput" STYLE="background-color: <?php echo $rudweb_skin['BgReqColor'];?>" TYPE="text" NAME="usr_email2" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_email2;?>">
  &#160;&#42;
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><BR></TD>
  <TD STYLE="text-align: left;"></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrpass1'];?>:</TD>
  <TD STYLE="text-align: left;">
  <INPUT CLASS="forminput" STYLE="background-color: <?php echo $rudweb_skin['BgReqColor'];?>" TYPE="password" NAME="usr_pass1" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_pass1;?>">
  &#160;&#42;
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrpass2'];?>:</TD>
  <TD STYLE="text-align: left;">
  <INPUT CLASS="forminput" STYLE="background-color: <?php echo $rudweb_skin['BgReqColor'];?>" TYPE="password" NAME="usr_pass2" SIZE="20" MAXLENGTH="30" VALUE="<?php echo $usr_pass2;?>">
  &#160;&#42;
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><BR></TD>
  <TD STYLE="text-align: left;"></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrprefln'];?>:</TD>
  <TD STYLE="text-align: left;">
<SELECT CLASS="forminput" NAME="usr_lang_index">
<?php  
$langs = lsdir(_RUDWEB_LANG_DIR);
$langst = count($langs);
for($lni = 1; $lni <= $langst; $lni++) {
?>
<OPTION VALUE="<?php echo $langs[$lni];?>"<?php if($usr_lang_index == $langs[$lni]) {echo ' SELECTED';}?>><?php echo $langs[$lni];?></OPTION>
<?php
}
?>
</SELECT>
  </TD>
</TR>
<TR>
  <TD STYLE="text-align: right;"><?php //echo $rudweb_ln['usr']['usrsubscribe1'];?><!--:--></TD>
  <TD STYLE="text-align: left;">
  <!--<INPUT TYPE="checkbox" CLASS="forminput" NAME="usr_subscribe"<?php //if($usr_subscribe == '1') {echo ' CHECKED';};?>>-->
  <!--&#160;-->
  <?php //echo $rudweb_ln['usr']['usrsubscribe2'];?>
  </TD>
</TR>
<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usragree1'];?>:</TD>
  <TD STYLE="text-align: left; background-color: <?php echo $rudweb_skin['BgReqColor'];?>">
  <INPUT TYPE="checkbox" STYLE="background-color: <?php echo $rudweb_skin['BgReqColor'];?>" CLASS="forminput" NAME="usr_agree"<?php if($usr_agree == '1') {echo ' CHECKED';};?>>
  &#160;
  <?php echo $rudweb_ln['usr']['usragree2'];?>&#160;<?php echo $rudweb_ln['usr']['usragree3'];?>&#160;<?php echo $rudweb_ln['usr']['usragree4'];?></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><BR></TD>
  <TD STYLE="text-align: left;"></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><?php echo $rudweb_ln['usr']['usrverif'];?>:</TD>
  <TD STYLE="text-align: left;">
  <IMG SRC="<?php echo _RUDWEB_LIB_URL; ?>picver.php" WIDTH="70" HEIGHT="20" ALT="verif" TITLE="verif">
  =
  <INPUT CLASS="forminput" TYPE="text" NAME="usr_verif" SIZE="5" MAXLENGTH="5" VALUE="<?php echo $usr_verif;?>">
  </TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"><BR></TD>
  <TD STYLE="text-align: left;"></TD>
</TR>

<TR>
  <TD STYLE="text-align: right;"></TD>
  <TD STYLE="text-align: left;"><INPUT CLASS="formsubmit" TYPE="submit" NAME="newuser" VALUE="<?php echo $rudweb_ln['usr']['signup'] ;?>"></TD>
</TR>

</TABLE>

</FORM>
</DIV>