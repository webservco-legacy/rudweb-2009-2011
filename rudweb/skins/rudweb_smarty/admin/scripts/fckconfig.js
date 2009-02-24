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