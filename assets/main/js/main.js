/**
 * Created by jaskokoyn on 2/25/2015.
 */
jQuery(function($){
    Dropzone.autoDiscover = false;

    $(document).on( "click", ".profileNav > a", function(e){
        $(this).parent().children().removeClass("active");
        $(this).addClass("active");
    });

    soundManager.setup({
        url: 'assets/soundmanager/swf/',
        html5PollingInterval: 50,
        flashVersion: 9, // optional: shiny features (default = 8)
        // optional: ignore Flash where possible, use 100% HTML5 mode
        preferFlash: false,
        onready: function() {
            // Ready to use; soundManager.createSound() etc. can now be called.
        }
    });

    $(document).on( 'click', '#sidebarToggleBtn', function(e){
        e.preventDefault();

        var state           =   parseInt($('.nav-sidebar-ctr').css('left')) > -1;
        $('.nav-sidebar-ctr').animate({'left':(state ? -250: 0)});
    });

    $(document).on( 'click', '.nav-sidebar-ctr .visible-sm li a', function(e){
        e.preventDefault();
        $('.nav-sidebar-ctr').animate({'left': -250});
    });

    $(window).resize(function(){
        if($(document).width() > 1024 && parseInt($('.nav-sidebar-ctr').css('left')) < 0){
            $(".nav-sidebar-ctr").css('left', 0);
        }
    });
});

window.fbAsyncInit = function() {
    FB.init({
        appId      : settings.facebook_app_key,
        xfbml      : true,
        version    : 'v2.3'
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));