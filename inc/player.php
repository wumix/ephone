<div ng-controller="playerController" class="euphonizePlayer">
    <div class="sm2-bar-ui full-width fixed flat" ng-class="{'playing': isPlaying, 'paused': !isPlaying }">
        <div class="bd sm2-main-controls">
            <div class="sm2-inline-element sm2-button-element">
                <div class="sm2-button-bd">
                    <a class="sm2-inline-button play-pause" ng-click="togglePlay()">Play / pause</a>
                </div>
            </div>
            <div class="sm2-inline-element sm2-inline-status">
                <div class="sm2-playlist">
                    <div class="sm2-playlist-target text-center">
                        <b><a href="profile/{{ artist }}">{{ artist }}</a></b> {{ song_title }}
                    </div>
                </div>
                <div class="sm2-progress">
                    <div class="sm2-row">
                        <div class="sm2-inline-time">{{ currentTime }}</div>
                        <div class="sm2-progress-bd">
                            <div class="sm2-progress-track" ng-click="moveTrackBall($event)">
                                <div class="sm2-progress-bar"></div>
                                <div class="sm2-progress-ball"><div class="icon-overlay fa-spin"></div></div>
                            </div>
                        </div>
                        <div class="sm2-inline-duration">{{ trackDuration }}</div>
                    </div>
                </div>
            </div>
            <div class="sm2-inline-element sm2-button-element sm2-volume hidden-xs" ng-mousedown="checkVolume($event)"
                 ng-mousemove="mouseVolumeMove($event)" ng-mouseup="isMouseDown = false">
                <div class="sm2-button-bd" ><a class="sm2-inline-button sm2-volume-control">volume</a></div>
            </div>
            <div class="sm2-inline-element sm2-button-element">
                <div class="sm2-button-bd">
                    <a title="Previous" class="sm2-inline-button previous" ng-click="previousPlaylistTrack()">&lt; previous</a>
                </div>
            </div>
            <div class="sm2-inline-element sm2-button-element">
                <div class="sm2-button-bd">
                    <a title="Next" class="sm2-inline-button next" ng-click="nextPlaylistTrack()">&gt; next</a>
                </div>
            </div>
        </div>
    </div>
</div>