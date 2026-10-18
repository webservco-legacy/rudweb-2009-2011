/**
 * $Id$ 
 * $URL$
 * $Revision$
 */

var rudwi = $("#interface");
var reload = $("#reload");
var icons = $(".icon");

//Mouse status
var mouseDiffY = 0;
var mouseDiffX = 0;
var mouseActiveIcon = 0;
var mouseActiveCloneIcon = 0;

$(document).ready(function(){

    //cancel context menu
    /*
    $(document).bind("contextmenu",function(e){
        return false;
    });
    */
    
    //show icons
    reload.css({'top':(rudwi.height()) - (128), 'left':rudwi.width() - 128});
    icons.fadeIn(1500);
    
    //mouse click
    icons.mousedown(function(e){
        //only accepts left click; all navs uses 0 but IE uses 1 lol...
        if(e.button <= 1){
            //calculate differences when user clicks the icon
            mouseDiffY = e.pageY - this.offsetTop;
            mouseDiffX = e.pageX - this.offsetLeft;
            if(mouseActiveIcon !=0){
                mouseActiveIcon.removeClass("active");
            }
            mouseActiveIcon = $(this);
            mouseActiveCloneIcon = mouseActiveIcon.clone(false).insertBefore(mouseActiveIcon);
        }
    });
    
    //moving mouse
    $(document).mousemove(function(e){
        if(mouseActiveIcon){
            //update position
            mouseActiveIcon.css({"top":e.pageY - mouseDiffY, "left":e.pageX - mouseDiffX, "opacity":0.35});
            var restaY = e.pageY - $(this).css("top");
            var restaX = e.pageX - $(this).css("left");
        }
    });
    
    //release mouse click
    $(document).mouseup(function(){
        if(mouseActiveIcon != 0){
            mouseActiveIcon.css({"opacity":1.0});
            mouseActiveIcon = 0;
            mouseActiveCloneIcon.remove();
            mouseActiveCloneIcon = 0;
        }
    });
    
    //mouse double click
    //icons.dblclick(function(){
        //alert(this.id);
    //});
    
    reload.dblclick(function(){
        location.reload();
    });
    
    //custom context menu on right click
    //rudwi.mousedown(function(e){
    icons.mousedown(function(e){
        if(e.button == 2){
            alert("context menu");
        }
    });

});