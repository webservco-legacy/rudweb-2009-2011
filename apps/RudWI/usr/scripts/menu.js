/**
 * $Id$ 
 * $URL$
 * $Revision$
 */

/*
MAIN JS
This file contains common javascript logic needed on all|most pages
*/

function isFormEvent(e) {
    // this function checks if the supplied event came from a form element
    es = e.target.nodeName;
    return (es == 'HTML' || es == 'BODY' || es == 'DIV' || es == 'A' || es == 'FIELDSET' ? false: true);
}

$(document).ready(function() {
    $('#taskbar').hide(0);

    // when the user presses and holds the space key outside a form, launch the quicknav panel
    $().keydown(function (e) {
        // key pressed
        if (e.which == 32) {
            // space key pressed
            if (!isFormEvent(e)) {
                // space key pressed outside form (so not in an input element)
                // darken background and show the navigation panel.
                $('#taskbar').show(0);
                // stop the default behavior (space is usually used as extra pagedown key)
                e.preventDefault();
            }
        }
    });

    // when the user releases the space key outside a form, hide the quicknav panel
    $().keyup(function (e) {
        // key pressed
        if (e.which == 32) {
            // space key pressed
            if (!isFormEvent(e)) {
                // space key pressed outside form (so not in an input element)
                // lighten background and hide the navigation panel.
                $('#taskbar').hide(0);
                // stop the default behavior (space is usually used as extra pagedown key)
                e.preventDefault();
            }
        }
    });

});