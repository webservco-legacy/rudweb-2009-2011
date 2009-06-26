/**
 * $Id$
 *
 * $URL$
 * <BR>JavaScript for the template
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2008, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @since      2009-02-13 16:26:00
 * @access     public
 * @package    RudWEb
 * @subpackage rwSkinRwS
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
function toggleTRows(thisname) {
  tr=document.getElementsByTagName('tr')
  for (i=0;i<tr.length;i++){
    if (tr[i].getAttribute(thisname)){
      if ( tr[i].style.display=='none' ){
        tr[i].style.display = '';
      }
      else {
        tr[i].style.display = 'none';
      }
    }
  }
}
function toggleTRowGroups(thisname, thisvalue)
{
  tr=document.getElementsByTagName('tr');
  for(i=0;i<tr.length;i++)
  {
    if(tr[i].getAttribute(thisname)>=thisvalue)
    {
      if(tr[i].style.display=='none')
      {
        tr[i].style.display='';
      }
      else
      {
        tr[i].style.display='none';
      }
    }
  }
}
function addToFCK(url, width, height, alt)
{
  var url = (url == null) ? null : url;
  var width = (width == null) ? null : width;
  var height = (height == null) ? null : height;
  var alt = (alt == null) ? null : alt;
  if(window.opener && (url != null))
  {
    window.opener.SetUrl(url, width, height, alt);
    //window.opener.SetUrl(url) ;
    window.close() ;
  }
}
function jsCancel(url)
{
  if(window.opener)
  {
    window.close();
  }
  else
  {
    window.location = url;
  }
}