/**
 * Created by jaskokoyn on 4/5/2015.
 */
jQuery(function($){
    var currentTrack    =   null;
    var volumeElem      =   {
        x: 0,
        y: 0,
        width: 0,
        height: 0,
        backgroundSize: 0
    };
    var isMouseDown     =   false;
    soundManager.setup({
        url: 'assets/soundmanager/swf/',
        html5PollingInterval: 50,
        flashVersion: 9, // optional: shiny features (default = 8)
        // optional: ignore Flash where possible, use 100% HTML5 mode
        preferFlash: false,
        onready: function() {
            currentTrack        =   soundManager.createSound({
                url: 'uploads/' + track_url,
                whileplaying: function () {
                    var progressMaxLeft = 100,
                        left = Math.min(progressMaxLeft, Math.max(0, (progressMaxLeft * (currentTrack.position / currentTrack.durationEstimate)))) + '%',
                        width = Math.min(100, Math.max(0, (100 * currentTrack.position / currentTrack.durationEstimate))) + '%';

                    if (currentTrack.duration) {
                        $(".sm2-progress-ball").css('left', left);
                        $(".sm2-progress-bar").css('width', width);
                        $(".sm2-inline-time").text(getTime(currentTrack.position, true));
                    }
                },
                whileloading: function () {
                    $(".sm2-inline-duration").text(getTime(currentTrack.durationEstimate, true));
                },
                onload: function () {
                    $(".sm2-inline-duration").text(getTime(currentTrack.duration, true));
                },
                onfinish: function () {
                    $(".sm2-progress-ball").css('left', "0%");
                    $(".sm2-progress-bar").css('width', "0%");
                    $(".sm2-inline-time").text("0:00");
                },
                onbufferchange: function (isBuffering) {
                    if (isBuffering) {
                        $(".icon-overlay").show();
                    } else {
                        $(".icon-overlay").hide();
                    }
                }
            });
        }
    });

    function getTime(msec, useString){
        // convert milliseconds to hh:mm:ss, return as object literal or string
        var nSec = Math.floor(msec/1000),
            hh = Math.floor(nSec/3600),
            min = Math.floor(nSec/60) - Math.floor(hh * 60),
            sec = Math.floor(nSec -(hh*3600) -(min*60));

        // if (min === 0 && sec === 0) return null; // return 0:00 as null

        return (useString ? ((hh ? hh + ':' : '') + (hh && min < 10 ? '0' + min : min) + ':' + ( sec < 10 ? '0' + sec : sec ) ) : { 'min': min, 'sec': sec });
    }

    $(document).on( "click", ".play-pause", function(e){
        currentTrack.togglePause();
        if($(".sm2-bar-ui").hasClass("playing")){
            $(".sm2-bar-ui").removeClass("playing");
            $(".sm2-bar-ui").addClass("paused");
        }else{
            $(".sm2-bar-ui").addClass("playing");
            $(".sm2-bar-ui").removeClass("paused");
        }
    });

    $(document).on("mousedown", ".sm2-volume", function(evt){
        // Volume button is clicked. Update volume element values.
        var target                  =   target = evt.target || evt.srcElement;
        isMouseDown                 =   true;

        volumeElem.x                =   $(target).offset().left;
        volumeElem.y                =   0;
        volumeElem.width            =   target.offsetWidth;
        volumeElem.height           =   target.offsetHeight;

        // potentially dangerous: this should, but may not be a percentage-based value.
        if($(evt.target).hasClass("sm2-volume-control")){
            volumeElem.backgroundSize = parseInt($(target).css('background-size'), 10);
        }else{
            volumeElem.backgroundSize = parseInt($(target).find("a").css('background-size'), 10);
        }

        // IE gives pixels even if background-size specified as % in CSS. Boourns.
        if (window.navigator.userAgent.match(/msie|trident/i)) {
            volumeElem.backgroundSize = (volumeElem.backgroundSize / volumeElem.width) * 100;
        }

        adjustVolume(evt);
    });

    $(document).on( "mousemove", ".sm2-volume", function(evt){
        if(isMouseDown){
            adjustVolume(evt);
        }
    });

    $(document).on( "mouseup", ".sm2-volume", function(evt){
        isMouseDown                 =   false;
    });

    function adjustVolume(evt){
        var backgroundSize,
            backgroundMargin,
            pixelMargin,
            value,
            volume;

        // based on getStyle() result
        backgroundSize  =  volumeElem.backgroundSize;

        // figure out spacing around background image based on background size, eg. 60% background size.
        backgroundSize  =   100 - backgroundSize;
        // 60% wide means 20% margin on each side.
        backgroundMargin = backgroundSize / 2;

        // relative position of mouse over element
        value = Math.max(0, Math.min(1, (evt.clientX - volumeElem.x) / volumeElem.width));

        if($(evt.target).hasClass("sm2-volume-control")){
            $(evt.target).css(
                'clip',
                'rect(0px, ' + (volumeElem.width * value) + 'px, ' + volumeElem.height + 'px, ' + (volumeElem.width * (backgroundMargin/100)) + 'px)'
            );
        }else{
            $(evt.target).find(".sm2-volume-control").css(
                'clip',
                'rect(0px, ' + (volumeElem.width * value) + 'px, ' + volumeElem.height + 'px, ' + (volumeElem.width * (backgroundMargin/100)) + 'px)'
            );
        }

        // determine logical volume, including background margin
        pixelMargin = ((backgroundMargin/100) * volumeElem.width);

        volume = Math.max(0, Math.min(1, ((evt.clientX - volumeElem.x) - pixelMargin) / (volumeElem.width - (pixelMargin*2))));

        // set volume
        if (currentTrack) {
            currentTrack.setVolume(volume * 100);
        }
    }

    $(document).on( "click", ".sm2-progress-track", function(e){
        if(!currentTrack){
            return null;
        }

        var xPos                =   parseInt(e.clientX - $(".sm2-progress-track").offset().left);
        var trackWidth          =   parseInt($(".sm2-progress-track").width());
        var newDurationPerc     =   (xPos / trackWidth);
        var newDuractionSecs    =   currentTrack.duration * newDurationPerc;
        currentTrack.setPosition(newDuractionSecs);
    });
});