/**
 * $Id$
 *
 * $URL$
 * <BR>FCKeditor configuration
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-24 13:56:00
 * @access     public
 * @package    RudWEb
 * @subpackage Skins
 * @todo       stuff
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
 * Core styles.
 */
FCKConfig.CoreStyles.Bold           = { Element : 'span', Attributes : { 'class' : 'Bold' } } ;
FCKConfig.CoreStyles.Italic         = { Element : 'span', Attributes : { 'class' : 'Italic' } } ;
FCKConfig.CoreStyles.Underline      = { Element : 'span', Attributes : { 'class' : 'Underline' } } ;
FCKConfig.CoreStyles.StrikeThrough  = { Element : 'span', Attributes : { 'class' : 'StrikeThrough' } } ;
/**
 * Font face
 */
 FCKConfig.FontNames = 'FontArial/Arial;FontVerdana/Verdana;FontTimes/Times;FontCourier/Courier' ;
 FCKConfig.CoreStyles.FontFace =
  {
    Element   : 'span',
    Attributes  : { 'class' : '#("Font")' },
    Overrides : [ { Element : 'span', Attributes : { 'class' : /^Font(?:Arial|Verdana|Times|Courier)$/ } } ]
  } ;
/**
 * Font sizes.
 */
FCKConfig.FontSizes   = 'FontSmaller/Smaller;FontLarger/Larger;FontSmall/10px;FontBig/14px' ;
FCKConfig.CoreStyles.Size =
  {
    Element   : 'span',
    Attributes  : { 'class' : '#("Size")' },
    Overrides : [ { Element : 'span', Attributes : { 'class' : /^Font(?:Smaller|Larger|Small|Big)$/ } } ]
  } ;
/**
 * Font colors.
 */
FCKConfig.EnableMoreFontColors = false ;
FCKConfig.FontColors = 'ff9900/FontColor1,0066cc/FontColor2,ff0000/FontColor3' ;
FCKConfig.CoreStyles.Color =
  {
    Element   : 'span',
    Attributes  : { 'class' : '#("Color")' },
    Overrides : [ { Element : 'span', Attributes : { 'class' : /^FontColor(?:1|2|3)$/ } } ]
  } ;
FCKConfig.CoreStyles.BackColor =
  {
    Element   : 'span',
    Attributes  : { 'class' : '#("Color")BG' },
    Overrides : [ { Element : 'span', Attributes : { 'class' : /^FontColor(?:1|2|3)BG$/ } } ]
  } ;
 /**
 * Indentation.
 */
FCKConfig.IndentClasses = [ 'Indent1', 'Indent2', 'Indent3' ] ;
/**
 * Paragraph justification.
 */
FCKConfig.JustifyClasses = [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull' ] ;
/**
 * Styles combo.
 */
FCKConfig.StylesXmlPath = '' ;
FCKConfig.CustomStyles =
  {
    'Strong Emphasis' : { Element : 'strong' },
    'Emphasis' : { Element : 'em' },

    'Computer Code' : { Element : 'code' },
    'Keyboard Phrase' : { Element : 'kbd' },
    'Sample Text' : { Element : 'samp' },
    'Variable' : { Element : 'var' },

    'Deleted Text' : { Element : 'del' },
    'Inserted Text' : { Element : 'ins' },

    'Cited Work' : { Element : 'cite' },
    'Inline Quotation' : { Element : 'q' }
  } ;
 
 FCKConfig.ToolbarSets["rudweb"] = [
  ['Source','-','Save','Preview'],
  ['Cut','Copy','Paste','PasteText','PasteWord'],
  ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
  ['Link','Unlink','Anchor'],
  '/',
  ['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote','CreateDiv'],
  ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
  ['TextColor','BGColor'],
  ['Image','Table','Rule','Smiley','SpecialChar','PageBreak'],
  '/',
  ['FontFormat','FontName','FontSize']
] ;

FCKConfig.ToolbarSets["rudweb_full"] = [
  ['Source','DocProps','-','Save','NewPage','Preview','-','Templates'],
  ['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
  ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
  ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
  '/',
  ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
  ['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote','CreateDiv'],
  ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
  ['Link','Unlink','Anchor'],
  ['Image','Flash','Table','Rule','Smiley','SpecialChar','PageBreak'],
  '/',
  ['Style','FontFormat','FontName','FontSize'],
  ['TextColor','BGColor'],
  ['FitWindow','ShowBlocks','-','About']    // No comma for the last row.
] ;

FCKConfig.EnterMode = 'p' ;     // p | div | br
FCKConfig.ShiftEnterMode = 'br' ; // p | div | br

FCKConfig.LinkBrowser = true ;
FCKConfig.LinkBrowserURL = FCKConfig.BasePath + 'filemanager/browser/default/browser.html?Connector=' + encodeURIComponent( FCKConfig.BasePath + 'filemanager/connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ) ;
FCKConfig.LinkBrowserWindowWidth  = FCKConfig.ScreenWidth * 0.7 ;   // 70%
FCKConfig.LinkBrowserWindowHeight = FCKConfig.ScreenHeight * 0.7 ;  // 70%

FCKConfig.ImageBrowser = true ;
FCKConfig.ImageBrowserURL = FCKConfig.BasePath + 'filemanager/browser/default/browser.html?Type=Image&Connector=' + encodeURIComponent( FCKConfig.BasePath + 'filemanager/connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ) ;
FCKConfig.ImageBrowserWindowWidth  = FCKConfig.ScreenWidth * 0.7 ;  // 70% ;
FCKConfig.ImageBrowserWindowHeight = FCKConfig.ScreenHeight * 0.7 ; // 70% ;

FCKConfig.FlashBrowser = true ;
FCKConfig.FlashBrowserURL = FCKConfig.BasePath + 'filemanager/browser/default/browser.html?Type=Flash&Connector=' + encodeURIComponent( FCKConfig.BasePath + 'filemanager/connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ) ;
FCKConfig.FlashBrowserWindowWidth  = FCKConfig.ScreenWidth * 0.7 ;  //70% ;
FCKConfig.FlashBrowserWindowHeight = FCKConfig.ScreenHeight * 0.7 ; //70% ;

FCKConfig.LinkUpload = true ;
FCKConfig.LinkUploadURL = FCKConfig.BasePath + 'filemanager/connectors/' + _QuickUploadLanguage + '/upload.' + _QuickUploadExtension ;
FCKConfig.LinkUploadAllowedExtensions = ".(7z|aiff|asf|avi|bmp|csv|doc|fla|flv|gif|gz|gzip|jpeg|jpg|mid|mov|mp3|mp4|mpc|mpeg|mpg|ods|odt|pdf|png|ppt|pxd|qt|ram|rar|rm|rmi|rmvb|rtf|sdc|sitd|swf|sxc|sxw|tar|tgz|tif|tiff|txt|vsd|wav|wma|wmv|xls|xml|zip)$" ;      // empty for all
FCKConfig.LinkUploadDeniedExtensions  = "" ;  // empty for no one

FCKConfig.ImageUpload = true ;
FCKConfig.ImageUploadURL = FCKConfig.BasePath + 'filemanager/connectors/' + _QuickUploadLanguage + '/upload.' + _QuickUploadExtension + '?Type=Image' ;
FCKConfig.ImageUploadAllowedExtensions  = ".(jpg|gif|jpeg|png|bmp)$" ;    // empty for all
FCKConfig.ImageUploadDeniedExtensions = "" ;              // empty for no one

FCKConfig.FlashUpload = true ;
FCKConfig.FlashUploadURL = FCKConfig.BasePath + 'filemanager/connectors/' + _QuickUploadLanguage + '/upload.' + _QuickUploadExtension + '?Type=Flash' ;
FCKConfig.FlashUploadAllowedExtensions  = ".(swf|flv)$" ;   // empty for all
FCKConfig.FlashUploadDeniedExtensions = "" ;          // empty for no one