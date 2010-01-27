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
./inc/langs/en/lang.inc.php
14:27 2008-08-06
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

// WINDOW STATUS
$rudweb_ln['WinStatDef']      = _RUDWEB_WSTT;
$rudweb_ln['WinStatOver']     = _RUDWEB_WSTT;
$rudweb_ln['WinStatOut']      = _RUDWEB_WSTT;

// VISITORS STATISTICS
$rudweb_ln['total_visitors']  = "total visitors";
$rudweb_ln['visitors']        = "visitors";
$rudweb_ln['unique_visitors'] = "unique visitors";
$rudweb_ln['online_visitors'] = "visitor(s) online";
$rudweb_ln['since']           = "since";

//LOGIN STATUS & MESSAGES
$rudweb_ln['lgnst'][1] = "Not submitted";
$rudweb_ln['lgnst'][2] = "Empty strings";
$rudweb_ln['lgnst'][3] = "Invalid login";
$rudweb_ln['lgnst'][4] = "Account disabled";
$rudweb_ln['lgnst'][5] = "Logged in ok";
$rudweb_ln['lgnst'][6] = "Logged in";
$rudweb_ln['lgnst'][7] = "Image verification failed";

$rudweb_ln['level']    = "Access level: ";
$rudweb_ln['logout']   = "Logout";

// COPYRIGHT
$rudweb_ln['cpy']['1'] = "Copyright";
$rudweb_ln['cpy']['2'] = "All rights reserved";
$rudweb_ln['cpy']['3'] = "Web presence by";

// COMMENTS
$rudweb_ln['cmnts']['comments'] = "comments";

// BLOG RELATED
$rudweb_ln['blg']['postedby'] = "Posted by ";
$rudweb_ln['blg']['on']       = " on ";
$rudweb_ln['blg']['lastmod']  = "Last modified by ";


// ADMIN FORMS
$rudweb_ln['adm']['mnu_tt']       = "Menu Title:";
$rudweb_ln['adm']['mnu_trg']      = "Target:";
$rudweb_ln['adm']['pic0']         = "Pictures [0]:";
$rudweb_ln['adm']['pic1']         = "Pictures [1]:";
$rudweb_ln['adm']['pic2']         = "Pictures [2]:";
$rudweb_ln['adm']['pic3']         = "Pictures [3]:";
$rudweb_ln['adm']['pic4']         = "Pictures [4]:";
$rudweb_ln['adm']['nopic']        = "NO PICTURE"; // NO SPECIAL CHARS HERE !
$rudweb_ln['adm']['new_pic']      = "New Picture:";
$rudweb_ln['adm']['pic_tmb']      = "thumbnail";
$rudweb_ln['adm']['new_content']  = "ADD CONTENT";
$rudweb_ln['adm']['new_link']     = "ADD LINK";
$rudweb_ln['adm']['new_page']     = "ADD PAGE";
$rudweb_ln['adm']['cnt_tt']       = "Content Title:";
$rudweb_ln['adm']['cnt_stt']      = "Content Subtitle:";
$rudweb_ln['adm']['cnt_kw']       = "Content Keywords:";
$rudweb_ln['adm']['cnt_dsc']      = "Content Description:";
$rudweb_ln['adm']['cnt_txt']      = "Content Text:";
$rudweb_ln['adm']['cnt_mod']      = "Modify content";
$rudweb_ln['adm']['cnt_del']      = "Delete content";
$rudweb_ln['adm']['cnt_add']      = "Add content";
$rudweb_ln['adm']['lnk_tt']       = "Link Title:";
$rudweb_ln['adm']['lnk_url']      = "Link URL:";
$rudweb_ln['adm']['lnk_trg']      = "Link Target:";
$rudweb_ln['adm']['lnk_dsc']      = "Link Description:";
$rudweb_ln['adm']['cnt_add_lnk']  = "Add link";
$rudweb_ln['adm']['pg_name']      = "Page name:";
$rudweb_ln['adm']['cnt_add_pg']   = "Add page";
$rudweb_ln['adm']['pic_del']      = "Delete picture:";
$rudweb_ln['adm']['pic_repl']     = "Replace picture:";
$rudweb_ln['adm']['ftr_sup']      = "Description:";
$rudweb_ln['adm']['ftr_valid']    = "Validity:";
$rudweb_ln['adm']['cal_months']   = "'January','February','March','April','May','June','July','August','September','October','November','December'";
$rudweb_ln['adm']['cal_days']     = "'S','M','T','W','T','F','S'";
$rudweb_ln['adm']['cal_today']    = "Today";

//USER MODULE
$rudweb_ln['usr']['alreadyreg']    = 'Registered User';
$rudweb_ln['usr']['retuser']       = "Returning User";
$rudweb_ln['usr']['newuser']       = "New User";
$rudweb_ln['usr']['signup']        = "Sign Up";

$rudweb_ln['usr']['newuserreg']    = "New User Registration";
$rudweb_ln['usr']['usrfirstname']  = "First Name";
$rudweb_ln['usr']['usrmiddlename'] = "Middle Name";
$rudweb_ln['usr']['usrlastname']   = "Last Name";
$rudweb_ln['usr']['usrphone']      = "Phone Number";
$rudweb_ln['usr']['usraddress']    = "Postal Address";
$rudweb_ln['usr']['usrcountry']    = "Country";
$rudweb_ln['usr']['usremail1']     = "E-Mail Address";
$rudweb_ln['usr']['usremail2']     = "E-Mail Address again";
$rudweb_ln['usr']['usrpass1']      = "Desired Password";
$rudweb_ln['usr']['usrpass2']      = "Desired Password again";
$rudweb_ln['usr']['usrprefln']     = "Preffered Website Language";
$rudweb_ln['usr']['usrsubscribe1'] = "Subscribe";
$rudweb_ln['usr']['usrsubscribe2'] = "I would like to subscribe";
$rudweb_ln['usr']['usragree1']     = "Agree";
$rudweb_ln['usr']['usragree2']     = "I agree to the";
$rudweb_ln['usr']['usragree3']     = "terms and conditions";
$rudweb_ln['usr']['usragree4']     = "of the website";
$rudweb_ln['usr']['usrverif']      = "Verification";
$rudweb_ln['usr']['regerr1']       = "First Name field is blank!";
$rudweb_ln['usr']['regerr2']       = "Last Name field is blank!";
$rudweb_ln['usr']['regerr3']       = "Country field is blank!";
$rudweb_ln['usr']['regerr4']       = "Email field is blank!";
$rudweb_ln['usr']['regerr5']       = "Email address is not valid!";
$rudweb_ln['usr']['regerr6']       = "Email addresses do not match!";
$rudweb_ln['usr']['regerr7']       = "Password field is empty!";
$rudweb_ln['usr']['regerr8']       = "Password is to short!";
$rudweb_ln['usr']['regerr9']       = "Passwords do not match!";
$rudweb_ln['usr']['regerr10']      = "You have to agree!";
$rudweb_ln['usr']['regerr11']      = "Image verification failed!";
$rudweb_ln['usr']['regerr12']      = "Email address is already in our database!";
$rudweb_ln['usr']['regerr13']      = "You have already applied for an account! Please check your email for details how to activate it!";
$rudweb_ln['usr']['regerr14']      = "You have already applied for an account but we weren't unable to send you the activation email!";

$rudweb_ln['usr']['accact']        = "New Account Activation";
$rudweb_ln['usr']['aaerror1']      = "Invalid authorization code.";
$rudweb_ln['usr']['aaerror2']      = "Perhaps the account is already activated?";

$rudweb_ln['usr']['lostpass']      = "Lost Password?";
$rudweb_ln['usr']['lostpsubmit']   = "Next";
$rudweb_ln['usr']['lpaerror1']     = "Invalid authorization code.";
$rudweb_ln['usr']['lpaerror2']     = "Perhaps it has expired?";

// CATALOG
$rudweb_ln['cat']['noitems']       = 'No Items';
$rudweb_ln['cat']['quantity']      = 'Quantity';
$rudweb_ln['cat']['itemaddok']     = 'Item added sucessfully!';
$rudweb_ln['cat']['itemmodok']     = 'Item modified sucessfully!';
$rudweb_ln['cat']['itemdelok']     = 'Item deleted sucessfully!';
$rudweb_ln['cat']['itemaddnew']    = 'Add new item';
$rudweb_ln['cat']['itemmod']       = 'Modify item';
$rudweb_ln['cat']['itemviewcat']   = 'View items in this category';
$rudweb_ln['cat']['ipg']           = 'Items / page';
$rudweb_ln['cat']['pcs']           = 'Picture uploads at once';
// PAGINATION
$rudweb_ln['pgnav']['first']       = '&#60;&#60;';
$rudweb_ln['pgnav']['prev']        = '&#60;';
$rudweb_ln['pgnav']['next']        = '&#62;';
$rudweb_ln['pgnav']['last']        = '&#62;&#62;';
$rudweb_ln['pgnav']['page']        = 'page ';
$rudweb_ln['pgnav']['of']          = ' of ';

//ADMINISTRATION
$rudweb_ln['adm']['adm']           = 'Administration';
$rudweb_ln['adm']['add']           = 'Add';
$rudweb_ln['adm']['mov']           = 'Move';
$rudweb_ln['adm']['mod']           = 'Modify';
$rudweb_ln['adm']['del']           = 'Delete';
$rudweb_ln['adm']['sel']           = 'Select';
$rudweb_ln['adm']['chl']           = 'characters left';
$rudweb_ln['adm']['viewrights']    = 'Viewing rights level';
$rudweb_ln['adm']['level']         = 'Level';
$rudweb_ln['adm']['lvl'][0]        = 'Visitors';
$rudweb_ln['adm']['lvl'][1]        = 'Users';
$rudweb_ln['adm']['lvl'][2]        = 'VIP Users';
$rudweb_ln['adm']['lvl'][3]        = 'Administrators';
$rudweb_ln['adm']['lvl'][4]        = 'Owner';
$rudweb_ln['adm']['lvl'][5]        = 'Root';
$rudweb_ln['adm']['tt']            = 'Title';
$rudweb_ln['adm']['stt']           = 'Subtitle';
$rudweb_ln['adm']['dsc']           = 'Description';
$rudweb_ln['adm']['txt']           = 'Content';
$rudweb_ln['adm']['noitems']       = 'No Items';
$rudweb_ln['adm']['itemaddok']     = 'Item added sucessfully!';
$rudweb_ln['adm']['itemmodok']     = 'Item modified sucessfully!';
$rudweb_ln['adm']['itemdelok']     = 'Item deleted sucessfully!';
$rudweb_ln['adm']['itemaddnew']    = 'Add new item';
$rudweb_ln['adm']['itemmod']       = 'Modify item';
$rudweb_ln['adm']['itemviewcat']   = 'View items in this category';
$rudweb_ln['adm']['settings']      = 'Settings';
$rudweb_ln['adm']['save']          = 'Save';
$rudweb_ln['adm']['savemod']       = 'Save changes';
$rudweb_ln['adm']['filter']        = 'Filter';
$rudweb_ln['adm']['reset']         = 'Reset';

// CATALOG SPECIAL OFFERS
$rudweb_ln['adm']['cspmodstat0']  = "Special Offers module is disabled.";
$rudweb_ln['adm']['cspmodstat00'] = "Modify your config file to enable it.";
$rudweb_ln['adm']['cspmodstat01'] = "Enable.";
$rudweb_ln['adm']['cspmodstat1']  = "Special Offers module is enabled.";
$rudweb_ln['adm']['cspmodstat11'] = "Modify your config file to disable it.";
$rudweb_ln['adm']['cspmodstat12'] = "Modify your config file to change it.";
$rudweb_ln['adm']['cspmodstat10'] = "Disable.";
$rudweb_ln['adm']['csplmttxt1']   = "Number of items to display: ";
$rudweb_ln['csp']['delone']       = "Delete this one: ";

// CONTENT
$rudweb_ln['cnt']['cnt']          = "Content";
// TAGS
$rudweb_ln['cnt']['tags']         = "Tags";
$rudweb_ln['cnt']['avltags']      = "Available tags";
$rudweb_ln['adm']['tagmodstat0']  = "Tags module is disabled.";
$rudweb_ln['adm']['tagmodstat00'] = "Modify your config file to enable it.";
$rudweb_ln['adm']['tagmodstat01'] = "Enable.";
$rudweb_ln['adm']['tagmodstat1']  = "Tags module is enabled.";
$rudweb_ln['adm']['tagmodstat11'] = "Modify your config file to disable it.";
$rudweb_ln['adm']['tagmodstat10'] = "Disable.";
$rudweb_ln['csp']['deltags']      = "Delete selected tags";
$rudweb_ln['csp']['delutags']     = "Delete unused tags";

// COMMENTS
$rudweb_ln['cmt']['cmtt']         = "Comments";
$rudweb_ln['cmt']['cmt']          = "comments";
$rudweb_ln['cmt']['cmtal']        = "Add new comment";
$rudweb_ln['cmt']['cmtvl']        = "View all comments";

// MODULE ADMINISTARTION
$rudweb_ln['adm']['modules']    = "Modules";
$rudweb_ln['adm']['modstat0']   = "Module is disabled.";
$rudweb_ln['adm']['modstat00']  = "Modify your config file to enable it.";
$rudweb_ln['adm']['modstat01']  = "Enable.";
$rudweb_ln['adm']['modstat1']   = "Module is enabled.";
$rudweb_ln['adm']['modstat11']  = "Modify your config file to disable it.";
$rudweb_ln['adm']['modstat12']  = "Modify your config file to change it.";
$rudweb_ln['adm']['modstat10']  = "Disable.";
$rudweb_ln['adm']['lmttxt1']    = "Number of items to display: ";
$rudweb_ln['adm']['new']        = "Add new";

// NEWS
$rudweb_ln['nws']['tt']  = "News";
$rudweb_ln['nws']['allnews']  = "All news";
$rudweb_ln['nws']['ltstnews']  = "Latest news";

// ERROR MESSAGES
$rudweb_ln['err']['tt']           = 'OOPS!';
$rudweb_ln['err']['0']            = "Oops! Page not found!";
$rudweb_ln['err']['1']            = "Sorry! You don't have permission to access this page!";
$rudweb_ln['err']['3']            = "Sorry! Request not valid!";
$rudweb_ln['err']['itemadd']['1'] = 'Field ' .$rudweb_ln['prod']['pname'] . ' is blank!';
$rudweb_ln['err']['itemadd']['2'] = 'Please select an item from the list!';
$rudweb_ln['err']['itemadd']['3'] = 'Please fill out required fields!';
$rudweb_ln['err']['add']['1']     = 'Field ' .$rudweb_ln['adm']['tt'] . ' is blank!';
$rudweb_ln['err']['add']['2']     = 'Field ' .$rudweb_ln['adm']['stt'] . ' is blank!';
$rudweb_ln['err']['add']['3']     = 'Field ' .$rudweb_ln['adm']['dsc'] . ' is blank!';
$rudweb_ln['err']['add']['4']     = 'Field ' .$rudweb_ln['adm']['txt'] . ' is blank!';

// MSIC STUFF
$rudweb_ln['about']  = "About";
$rudweb_ln['name']   = "Name";
$rudweb_ln['yes']    = "Yes";
$rudweb_ln['no']     = "No";
$rudweb_ln['categs'] = "Categories";
$rudweb_ln['dets']   = "Details";
$rudweb_ln['opts']   = "Options";
$rudweb_ln['type']   = "Type";
$rudweb_ln['order']  = "Order";
$rudweb_ln['req']    = "Required";
$rudweb_ln['main']   = "Main";
$rudweb_ln['text']   = "Text";
$rudweb_ln['select'] = "Select";
$rudweb_ln['send']   = "Send";
$rudweb_ln['reset']  = "Reset";
$rudweb_ln['new']    = "New";
$rudweb_ln['new2']   = "New";
$rudweb_ln['number'] = "No";
$rudweb_ln['date']   = "Date";
$rudweb_ln['time']   = "Time";
$rudweb_ln['email']  = "Email";
$rudweb_ln['read']   = "Read";
$rudweb_ln['solved'] = "Solved";

// CONTACT
$rudweb_ln['con']['tt']      = "Contact";
$rudweb_ln['con']['not3']    = "Notify Level 3";
$rudweb_ln['con']['not4']    = "Notify Level 4";
$rudweb_ln['con']['notE']    = "Notify email";
$rudweb_ln['con']['sendE']   = "Send email";
$rudweb_ln['con']['name']    = "Name";
$rudweb_ln['con']['email']   = "Email";
$rudweb_ln['con']['msg']     = "Message";
$rudweb_ln['con']['msgs']    = "Messages";
$rudweb_ln['con']['amsg']    = "All Messages";
$rudweb_ln['con']['frby']    = "First read by ";
$rudweb_ln['con']['sby']     = "Solved by ";
$rudweb_ln['con']['sets']    = "Set Solved";
$rudweb_ln['con']['general'] = "General";

// PRINT
$rudweb_ln['print']['page'] = "Print this page";
?>