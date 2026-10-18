/**
 * $Id$ 
 * $URL$
 * $Revision$
 * Since: 2009-11-18 11:50:00
 */

    function formJump(field)
        {
            if (field.value.length == field.maxLength)
            {
                var next=field.tabIndex;
                if (next<document.forms[0].elements.length)
                {
                    document.forms[0].elements[next].focus();
                }
            }
        }