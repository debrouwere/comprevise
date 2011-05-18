var animating = false;     // don't initiate a new animation if another one is in progress
var header_closed = false; // permanently keep the header closed
var header_pos = 0;

$.fn.appear = function (appear) {
    if (!animating && !header_closed) {
        animating = true;
        if (appear === false) {
            $("#header-bar").fadeOut(500, function(){ animating = false; });
        } else {
            $("#header-bar").fadeTo(200, 0.8, function(){ animating = false; });
        }        
    }
}

function fade_header () {
    $(document).bind('mousemove', function(e){
        if (NAV_POSITION == 'bottom') {
            var nearness = header_pos - e.pageY;
        } else {
            var nearness = e.pageY - $("body").scrollTop();
        }
        
        if (nearness <= 100) {
            $("#header-bar").appear();
        } else {
            $("#header-bar").appear(false);        
        }
    });
}

$(document).ready(function(){
    if ($("#header-bar").length) {
        $("#header-bar").fadeTo(0, 0.8);
        header_pos = $("#header-bar").offset().top;
        $(window).resize(function(){
            $("#header-bar").appear();
            header_pos = $("#header-bar").offset().top;
        });
    }

    $("time").timeago();
    
    $("#close").click(function(){
        $("#concept").css("top", 0);
        $("#header-bar").hide();
        header_closed = true;
        return false;
    });

    if (ANIMATE) {
        // fade out the chrome either after the user scrolls or 2,5 seconds, 
        // whichever comes soonest
        $(window).one('scroll', function(){
            $("#header-bar").appear(false);
        });
            
        setTimeout(function(){ $("#header-bar").fadeOut(fade_header); }, 2500);
    }
});